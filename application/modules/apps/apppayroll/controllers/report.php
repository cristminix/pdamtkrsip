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
    
    public function payslip($content_type='',$b='',$t='',$iu='')
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

        if(!empty($content_type) && !empty($b) && !empty($t) ){
            $bulan = $b;
            $tahun = $t;
            $id_unor = $id_unor;
            $proses = 'yes';
        }
        if($proses == 'yes'){
            $button_pressed = true;
            $report_data = $this->{$mdl}->get_report_data($bulan,$tahun,$id_unor);

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
        require_once(APPPATH.'/libraries/TCPDF/config/tcpdf_config.php');
        require_once(APPPATH.'/libraries/TCPDF/tcpdf.php');
        

        // create new PDF document
        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        // $pdf->SetAuthor('Nicola Asuni');
        // $pdf->SetTitle('TCPDF Example 048');
        // $pdf->SetSubject('TCPDF Tutorial');
        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

        // set header and footer fonts
        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

         

        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', 'B', 20);

        // add a page
        $pdf->AddPage();

        // $pdf->Write(0, 'Example of HTML tables', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 8);


        $pdf->writeHTML($content, true, false, false, false, '');

        // -----------------------------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('Laporan_Payslip.pdf', 'I');
        exit();
        //
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
