<?php 
class Main_Dashboard extends MX_Controller{
	function __construct(){
	    parent::__construct();
		$this->load->model('m_web');
		$this->load->library('notifpanel');
  }

  public function index() 
  {
	    $id_app=$this->m_web->getopsivalue();
		$data['nama_app']=@$id_app->nama_aplikasi;
		$data['slogan_app']=@$id_app->slogan_aplikasi;
		$this->viewPath = '../../assets/themes/dashboard/';
		$this->load->view($this->viewPath.'index',$data);
  }
	
}