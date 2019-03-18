<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datapegawai extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
/*
    if(!$this->session->userdata('loged_in')==true)
    {
        echo'<script type="text/javascript">window.location = "'.site_url('web/login').'";</script>';
    }
		$this->load->library('form_builder');
*/
		$this->content = array();
		$this->view_folder = 'admin/';
	}
	public function index()
	{
		$this->content['content'] =  Modules::run("appdatapegawai/appdatapegawai_home/index");
		$this->view('index',$this->content);
	}
	public function getdaftarpeg()
	{
		echo Modules::run("appdatapegawai/appdatapegawai_home/getdtbody",true);
	}
	public function getprofile()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		echo Modules::run("appdatapegawai/profile/index",$id_pegawai);
	}
	public function getprofile_ro()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		echo Modules::run("appdatapegawai/profile_ro/index",$id_pegawai);
	}
	public function gettab()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai);
	}
	public function gettab_ro()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."_ro/".$f,$id_pegawai);
	}
	public function getform()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$ID = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$ID);
	}
	public function submitform()
	{
		$id_pegawai = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		$data = $this->input->post();
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$data);
		// echo json_encode($this->input->post());
	}
	public function submitformriwayat()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$ID = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		$data = $this->input->post();
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$ID,$data);
		// echo json_encode($this->input->post());
	}
	public function del()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$ID = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$ID);
		// echo json_encode($this->input->post());
	}
	public function picker()
	{
		$name = $this->input->post('name');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/picker",$f);
	}
}

