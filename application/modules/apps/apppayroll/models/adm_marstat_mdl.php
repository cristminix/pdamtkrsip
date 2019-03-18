<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Marstat_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst = 'payslip_mdl';
    public $tbl              = 'r_pegawai';
    public $tbl_marstat      = 'apr_adm_marstat';
    public $tbl_payslip      = 'apr_sv_payslip';
    public $tbl_r_pegawai    = 'r_pegawai';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list    = array(
        '1' => 'nipp',
        'name',
        'text',
        'mar_stat',
        'alw_rc_sp_cnt',
        'eff_date',
        'term_date',
        'annotation',
    );
    public $rs_masked_field_list    = array(
        '1' => 'NIPP',
        'Name',
        'Latest Spouse',
        'Latest Status',
        'Rice Alw. Stat.',
        'Since',
        'Until',
        'Notes',
    );
    public $rs_masked_search_fields = array(
        '1' => 'r_pegawai.nip_baru',
        'r_pegawai.nama_pegawai',
        'apr_adm_marstat.text',
        'apr_adm_marstat.mar_stat',
        'apr_adm_marstat.alw_rc_sp_cnt',
        'apr_adm_marstat.eff_date',
        'apr_adm_marstat.term_date',
        'apr_adm_marstat.annotation',
    );
    public $rs_use_form_filter      = 'apr_adm_marstat';
    public $rs_select               = "*";
    public $rs_order_by             = null;
    public $rs_common_views         = array(
        /* date_field_list */
        'date_field_list' => array(
            'eff_date'  => 'd/m/Y',
            'term_date' => 'd/m/Y',
        )
    );
    public $rs_index_where          = "";

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);
        $this->{$payslip_mdl}->get_update_all_deduction();
    }

    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        if (method_exists($this, 'set_joins')) {
            $this->set_joins();
        }
        if (method_exists($this, 'set_rs_select')) {
            $this->set_rs_select();
        }

        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        $this->db->where('id', $id);
        $this->db->where($this->rs_index_where, null, false);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }    
    
    public function delete_row_by_id($id) {
        $detail = $this->fetch_detail($id);

        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->set('npwp', NULL);
        $this->db->set('reg_date', NULL);
        $this->db->set('text', NULL);
        $this->db->update($this->tbl);

        if ($this->db->affected_rows()) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                return array('error' => lang('Delete has failed'));
            } else {
                $this->_unset_npwp($detail->empl_id, $detail->reg_date);
                $this->db->trans_commit();
//$this->_update_payslip();
                return array('success' => lang('Delete success'));
            }
        }
        $this->db->trans_rollback();
        return array('error' => lang('Delete has failed'));
    }

    public function get_rs_action() {

        $r_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $dl_title .= lang('Download NPWP');

        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $im_title .= lang('Import NPWP');

        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',

                'action_list' => array(
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-list text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function get_detail_by_empl_id($empl_id) {
        //Max
        $sql_str = <<<SQL
            SELECT 
                r_pegawai.id_pegawai as id, 
                r_pegawai.nip_baru as nipp, 
                r_pegawai.nama_pegawai as name, 
                marjoin.mar_stat as mar_stat,
                marjoin.eff_date as eff_date, 
                marjoin.term_date as term_date,
                marjoin.annotation as annotation, 
                marjoin.text as text, 
                marjoin.alw_rc_sp_cnt as alw_rc_sp_cnt
            FROM (`r_pegawai`)
            LEFT JOIN (
                SELECT empl_id,mar_stat, eff_date, term_date, annotation, text, alw_rc_sp_cnt
                FROM apr_adm_marstat 
                WHERE empl_id='{$empl_id}'
                ORDER BY eff_date DESC
                LIMIT 1
            ) AS marjoin
                ON `marjoin`.`empl_id`=`r_pegawai`.`id_pegawai`
            WHERE `r_pegawai`.`id_pegawai` =  '{$empl_id}'
SQL;
        $res     = $this->db->query($sql_str)->result();
        if (!isset($res[0])) {
            return $res;
        }
        return $res[0];
    }

    public function set_joins() {
        $tbl_marstat       = $this->tbl_marstat;
        $tbl               = $this->tbl;
        $join_on           = <<<JOIN
            {$tbl_marstat}.empl_id={$tbl}.id_pegawai
            AND {$tbl_marstat}.active_status=1

JOIN;
        $joins             = array(
            array(
                "(
                SELECT apr_adm_marstat.empl_id, apr_adm_marstat.mar_stat, apr_adm_marstat.eff_date, apr_adm_marstat.term_date, apr_adm_marstat.annotation, apr_adm_marstat.text, apr_adm_marstat.alw_rc_sp_cnt
                FROM apr_adm_marstat 
                INNER JOIN (
  SELECT empl_id, MAX(eff_date) AS max_eff
  FROM apr_adm_marstat GROUP BY empl_id
) AS max_mar ON apr_adm_marstat.empl_id =max_mar.empl_id AND max_mar.max_eff = apr_adm_marstat.eff_date 
                GROUP BY apr_adm_marstat.empl_id
                
            ) AS {$tbl_marstat}",
                $join_on,
                'left'
            )
        );
        $this->rs_joins    = $joins;
        $this->rs_group_by = "{$tbl}.id_pegawai";
    }

    public function set_rs_select() {
//        '1' => 'nipp',
//        'name',
//        'text',
//        'mar_stat',
//        'alw_rc_sp_cnt',
//        'eff_date',
//        'term_date',
//        'annotation',
        $this->rs_select = $this->tbl . '.id_pegawai as id';
        $this->rs_select .= ',' . $this->tbl . '.nip_baru as nipp';
        $this->rs_select .= ',' . $this->tbl . '.nama_pegawai as name';
        $this->rs_select .= ',' . $this->tbl_marstat . '.mar_stat as mar_stat';
        $this->rs_select .= ', MAX(' . $this->tbl_marstat . '.eff_date) as eff_date';
        $this->rs_select .= ', MAX(' . $this->tbl_marstat . '.term_date) as term_date';
        $this->rs_select .= ',' . $this->tbl_marstat . '.annotation as annotation';
        $this->rs_select .= ',' . $this->tbl_marstat . '.text as text';
        $this->rs_select .= ',' . $this->tbl_marstat . '.alw_rc_sp_cnt as alw_rc_sp_cnt';
    }

}
