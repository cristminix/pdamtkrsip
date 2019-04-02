<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Report extends Apppayroll_Frontctl {
    public $ibl_bjb_mdl_name = 'report_ibl_bjb_mdl';
    // public $m_payslip_report = 'm_payslip_report';
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
        $proses  = $this->input->post('proses');
        $periode = $this->input->post('periode');
        $id_unor = $this->input->post('id_unor');
       

        $button_pressed = false;
        $tpl = __FUNCTION__;
        $mdl = 'm_payslip_report';
        $this->load_mdl($mdl);

        $this->set_page_title("Laporan Payslip");
            
        if($proses == 'yes'){
            $button_pressed = true;
        }    

        if(empty($periode)){
            $periode = date('m/Y');
        }
         if(empty($id_unor)){
            $id_unor = '';
        }
        $periode_a = explode('/', $periode);
        $bulan     = $periode_a[0];
        $tahun     = $periode_a[1];

        $data = [
            'unor_list' => [''=>'All']+$this->{$mdl}->get_unor_list(),
            'button_pressed' => $button_pressed,
            'periode' => $periode,
            'list' => $this->{$mdl}->get_list($bulan,$tahun,$id_unor),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'id_unor' => $id_unor
        ];    
        $this->set_data($data);
        $this->print_page($tpl);
    }
    public function payslip_rekap()
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
