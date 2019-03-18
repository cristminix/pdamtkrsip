<?php

/**
 * Front Controller
 */
class Admin_Payroll extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->auth->restrict();
        $this->lang->load('apppayroll', 'bahasa_indonesia');
        $helpers = array('language', 'html');
        $this->load->helper($helpers);
    }

    public function index() {
        redirect("apppayroll/dashboard/index");
        $sess               = $this->session->userdata('logged_in');
        $data['page_content'] = Modules::run("apppayroll/dashboard/index");

        $this->templateName = $sess['section_name'];

        $this->viewPath = '../../assets/themes/' . $this->templateName . '/';
        $this->load->view($this->viewPath . 'index', $data);
    }

    public function page($modulename = 'apppayroll', $modcontroller = 'dashboard', $modsegment = 'index') {

        $sess     = $this->session->userdata('logged_in');
        
        $data['page_content']    = Modules::run($modulename . "/" . $modcontroller . "/" . $modsegment);

        $this->templateName = $sess['section_name'];

        $this->viewPath = '../../assets/themes/' . $this->templateName . '/';
        $this->load->view($this->viewPath . 'index', $data);
    }
}
