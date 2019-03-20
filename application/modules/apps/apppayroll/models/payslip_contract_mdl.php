<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'payslip_mdl' . EXT;

class Payslip_Contract_Mdl extends Payslip_Mdl
{
    public $rs_common_views       = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'base_sal',
            'gross_sal',
            'ddc_amt',
            'net_pay',
        ),
        'cell_alignments'     => array(
//            'print_dt'  => 'right',
//            'base_sal'  => 'right',
//            'gross_sal' => 'right',
//            'ddc_amt'   => 'right',
//            'net_pay'   => 'right',
//            'hire_date' => 'right',
//            'los'       => 'right',
        ),
        'date_field_list'     => array(
            'print_dt'  => 'd/m/Y',
            'hire_date' => 'd/m/Y',
        ),
        'cell_nowrap'         => array(
            'print_dt',
            'nipp',
            'empl_name',
            'base_sal',
            'gross_sal',
            'ddc_amt',
            'net_pay',
            'job_unit',
            'job_title',
            'grade',
            // 'kode_peringkat',
            'lama_kontrak',
        )
    );
    public $rs_field_list         = array(
        '1' => 'print_dt',
        'nipp',
        'empl_name',
        'base_sal',
        'gross_sal',
        'ddc_amt',
        'net_pay',
        'job_unit',
        'job_title',
        // 'grade',
        // 'kode_peringkat',
        'lama_kontrak', // length of service
    );
    public $rs_masked_field_list  = array(
        '1' => 'Print Date',
        'NIPP',
        'Name',
        'Base Salary',
        'Gross Salary',
        'Total Deduction',
        'Net Pay',
        'Job Unit',
        'Job Title',
        // 'Grade',
        // 'Ranking Code',
        'Contract',
    );
    public $rs_select             = "*, IFNULL(alw_pph21, 0) + IFNULL(gross_sal, 0) AS `gross_sal`,  IFNULL(ddc_pph21, 0) + IFNULL(ddc_amt, 0) AS `ddc_amt`,  IFNULL(gross_sal, 0) - IFNULL(ddc_amt, 0 ) AS `net_pay`, CONCAT( (CASE WHEN  TIMESTAMPDIFF( YEAR, hire_date, NOW( ) ) % 2 = 0 THEN 2 ELSE 1 END ), ' thn' ) lama_kontrak";
    
    
      public function update_base_sal($filter = null)
    {
//        debug($this->rs_cf_cur_year);
//        debug($this->rs_cf_cur_month);
        $t_date = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));

        $this->db->where('print_dt', $t_date);
        $this->db->where('lock', 0);
        $this->db->where('base_sal_id', null);
        if ($filter) {
            $this->db->where($filter, null, false);
        }
        $this->db->select("nipp as sample_NIP,empl_id as ID_PEGAWAI,IFNULL(grade_id, 'NULL') AS KODE_PERINGKAT,IFNULL(grade, 'NULL') AS PERINGKAT,los AS LAMA_KONTRAK", false);
        $this->db->group_by(array('grade_id', 'los'));
        $res = $this->db->get($this->tbl)->result();
        if (!$res) {
            return;
        }
        // Get Schema
        require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . basename(__FILE__, EXT) . '_schema' . EXT;

        $lastdate = date('t', strtotime($t_date));
        $tbl_join = 'm_gaji_pokok';
        $sqlstr   = Payslip_Contract_Mdl_Schema::get_update_base_salary($this->tbl, $tbl_join, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);
        // echo $sqlstr;
        // die();
        
        $query    = $this->db->query($sqlstr);
        $this->get_update_all_allowance();
        $this->get_update_all_deduction();

        $this->db->where('print_dt', $t_date);
        $this->db->where('lock', 0);
        $this->db->where('base_sal_id', null);
        if ($filter) {
            $this->db->where($filter, null, false);
        }
        $this->db->select("nipp as sample_NIP,empl_id as ID_PEGAWAI,IFNULL(grade_id, 'NULL') AS KODE_PERINGKAT,IFNULL(grade, 'NULL') AS PERINGKAT,los AS LAMA_KONTRAK", false);
        $this->db->group_by(array('grade_id', 'los'));
        $res = $this->db->get($this->tbl)->result();
        if (!$res) {
            return;
        }
        $flash_message             = array();
        // $flash_message ['warning'] = lang('Missing Base Salary Setup') . ':' .
            str_replace(array('(', 'Array', ')', 'stdClass Object'), array('', '<br>', '<br>', '', '=', " "), print_r($res, true));
        $this->session->set_userdata('flash_message', $flash_message);
//        die();
    }
}
