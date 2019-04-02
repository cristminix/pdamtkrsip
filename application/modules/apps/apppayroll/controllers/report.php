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
        
        $payload = json_decode(file_get_contents('php://input'));
        if(is_object($payload)){
            $proses = $payload->proses;
            $periode = $payload->periode;
            $id_unor = $payload->id_unor;
        }

        $button_pressed = false;
        $report_data = [];

        $tpl = __FUNCTION__;
        $mdl = 'm_payslip_report';
        $this->load_mdl($mdl);

        $this->set_page_title("Laporan Payslip");
            


        if(empty($periode)){
            $periode = date('m/Y');
        }
         if(empty($id_unor)){
            $id_unor = '';
        }
        $periode_a = explode('/', $periode);
        $bulan     = $periode_a[0];
        $tahun     = $periode_a[1];
        if($proses == 'yes'){
            $button_pressed = true;
            $report_data = $this->{$mdl}->get_report_data($bulan,$tahun,$id_unor);
            $this->output->set_content_type('application/json')
                         ->set_output(json_encode($report_data))
                         ->_display();
            exit();
        }  
        $data = [
            'unor_list' => [''=>'All']+$this->{$mdl}->get_unor_list(),
            'button_pressed' => $button_pressed,
            'periode' => $periode,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'id_unor' => $id_unor,
            'report_data' => $report_data
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
