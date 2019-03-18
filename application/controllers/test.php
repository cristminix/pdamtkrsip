<?php

class Test extends CI_Controller{

	public function index($value='')
	{
		// $this->load->library('encrypt');
		$password = $this->encrypt->sha1("jingga");
		echo $password;
	}
}