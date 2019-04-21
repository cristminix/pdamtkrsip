<?php
use Dompdf\Dompdf;
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
    
    public function payslip($content_type='',$b='',$t='',$iu='')
    {
        $proses  = $this->input->post('proses');
        $periode = $this->input->post('periode');
        $id_unor = $this->input->post('id_unor');
        $empl_stat = $this->input->post('empl_stat');
        
        $payload = json_decode(file_get_contents('php://input'));
        if(is_object($payload)){
            $proses = $payload->proses;
            $periode = $payload->periode;
            $id_unor = $payload->id_unor;
            $empl_stat = $payload->empl_stat;
        }

        $button_pressed = false;
        $report_data = [];

        $tpl = __FUNCTION__;
        $mdl = 'm_payslip_report';
        $this->load_mdl($mdl);

        $this->set_page_title("DAFTAR GAJI PEGAWAI");
            


        if(empty($periode)){
            $periode = date('m/Y');
        }
        if(empty($id_unor)){
            $id_unor = '';
        }

        $periode_a = explode('/', $periode);
        $bulan     = $periode_a[0];
        $tahun     = $periode_a[1];

        if(!empty($content_type) && !empty($b) && !empty($t) ){
            $bulan = $b;
            $tahun = $t;
            $id_unor = $id_unor;
            $proses = 'yes';
        }
        if($proses == 'yes'){
            $button_pressed = true;
            $report_data = $this->{$mdl}->get_report_data($bulan,$tahun,$id_unor,$empl_stat);

            if($content_type == 'pdf'){
                return $this->_payslip_pdf_report($report_data);
            }

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
    private function _payslip_pdf_report($report_data){
        $content = $this->load->view('report/payslip_pdf',['report_data'=>$report_data],true);
        //

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($content);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
        exit();
        //
    }
    public function payslip_rekap()
    {
        $tpl = __FUNCTION__;
        $mdl = 'm_payslip_report';

        $proses  = $this->input->post('proses');
        $periode = $this->input->post('periode');
        $id_unor = $this->input->post('id_unor');
        $empl_stat = $this->input->post('empl_stat');
        
        $payload = json_decode(file_get_contents('php://input'));
        if(is_object($payload)){
            $proses = $payload->proses;
            $periode = $payload->periode;
            $id_unor = $payload->id_unor;
            $empl_stat = $payload->empl_stat;
        }

        $button_pressed = false;
        $report_data = [];

        $this->load_mdl($mdl);

        $this->set_page_title("DAFTAR REKAP GAJI PEGAWAI");
            


        if(empty($periode)){
            $periode = date('m/Y');
        }
        if(empty($id_unor)){
            $id_unor = '';
        }

        $periode_a = explode('/', $periode);
        $bulan     = $periode_a[0];
        $tahun     = $periode_a[1];

        if(!empty($content_type) && !empty($b) && !empty($t) ){
            $bulan = $b;
            $tahun = $t;
            $id_unor = $id_unor;
            $proses = 'yes';
        }
        if($proses == 'yes'){
            $button_pressed = true;
            $report_data = $this->{$mdl}->get_rekap_data($bulan,$tahun,$id_unor,$empl_stat);

            // if($content_type == 'pdf'){
            //     return $this->_payslip_pdf_report($report_data);
            // }

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
}
