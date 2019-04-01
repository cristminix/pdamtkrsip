<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Report extends Apppayroll_Frontctl {
    public $ibl_bjb_mdl_name = 'report_ibl_bjb_mdl';
    public function index() {        
        $this->print_page();
    }
    public function ibl_bjb($eid = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->ibl_bjb_mdl_name;
        $this->load_mdl($mdl);
//        $detail = array();
        if ($id) {
            $detail = $this->{$mdl}->fetch_detail($id);
            $data   = array('employee' => $detail);
            $this->set_data($data);
            return $this->print_page($tpl . '_detail');
        }
        $this->set_custom_filter($mdl);
       
        $this->set_form_filter($mdl);
        $ls       = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang('Net Pay and Loan of') . ' ' . $this->config->item('app_bjb_text'));
        $this->set_pagination($mdl);
        
        $this->set_data(compact('ls'));
        
        $this->set_common_views($mdl);
        $this->print_page($tpl);
    }
    
    public function payslip()
    {
        $tpl = __FUNCTION__;
        $mdl = $this->ibl_bjb_mdl_name;
        $this->load_mdl($mdl);

        $this->set_page_title("Laporan Payslip");
        
        $data = [
            
        ];    
        $this->set_data($data);
        $this->print_page($tpl);
    }
}
