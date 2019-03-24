<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontmdl.php';

/**
 * Description of dashboard_mdl
 *
 * @author ino
 */
class dashboard_mdl extends Apppayroll_Frontmdl {

    //put your code here
    protected $payslip_mdl = '';

    public function get_ptp($group_name, $print_dt = null) {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }
        $filters = $this->get_filter_by_group($group_name, $print_dt);
        $tbl     = 'apr_sv_payslip';
        $this->db->select('print_dt, max(IFNULL(gross_sal,0)-IFNULL(ddc_amt,0)) ptp', false);
//        debug($filters);die();
        $this->db->where($filters,null, false);
        $this->db->group_by('print_dt');
        $this->db->from($tbl);

        $res = $this->db->get()->result();
        return $res[0];
    }

    public function get_total($group_name, $print_dt = null) {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }
       $filters = $this->get_filter_by_group($group_name, $print_dt);
        $tbl     = 'apr_sv_payslip';
        $this->db->select('count(gross_sal) cnt_gross_sal');
        
        $this->db->where($filters,null, false);
        $this->db->group_by('print_dt');
        $this->db->from($tbl);

        $res = $this->db->get()->result();

        return $res[0];
    }

    public function get_bruto($group_name, $print_dt = null) {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }
        $filters = $this->get_filter_by_group($group_name, $print_dt);
        $tbl     = 'apr_sv_payslip';
        $this->db->select('SUM(gross_sal) sum_gross_sal');
        
        
        $this->db->where($filters,null, false);
        $this->db->group_by('print_dt');
        $this->db->from($tbl);

        $res = $this->db->get()->result();

        return $res[0];
    }

    protected function _get_filter_by_group($group_name, $print_dt = null) {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }

        $tbl = 'apr_payslip_group';
        $this->db->select('id');
        $this->db->where('name', $group_name);
        $this->db->where('active_status', 1);
        $this->db->from($tbl);
        $rs  = $this->db->get()->result();

        $res = array();
        if (!isset($rs[0])) {
            return $res;
        }
        $group_id = $rs[0]->id;

        $tbl = 'apr_payslip_group_detail';
        $this->db->select('field_name, operator, value');
        $this->db->where('apr_payslip_group_id', $group_id);
        $this->db->where('active_status', 1);
        $this->db->where('eff_date <=', $print_dt);
        $this->db->where("IF(term_date is NULL, true, term_date >= '{$print_dt}')", null, false);
        $this->db->from($tbl);
        $rs  = $this->db->get()->result();
        if (!$rs) {
            return $res;
        }

        return $rs;
    }

    public function get_filter_by_group($group_name, $print_dt = null) {
        $filter = $this->_get_filter_by_group($group_name, $print_dt);
        $filter_sql = '';
        if ($filter) {
            $filter_sql = '';
            $filter_arr = array();
            foreach ($filter as $n => $val) {
                $val->operator = $val->value == null && $val->operator == '!=' ? 'IS NOT' : $val->operator;
                $val->value    = $val->value == null ? 'NULL' : "'" . $val->value . "'";

                $filter_arr [] = $val->field_name . ' ' . $val->operator . " " . $val->value;
            }

            $filter_sql .= implode(' AND ', $filter_arr);
            $filter_sql .= '';
        }
        return $filter_sql;
    }

}
