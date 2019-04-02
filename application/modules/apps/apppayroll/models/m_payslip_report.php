<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// require_once 'apppayroll_frontmdl' . EXT;

class M_payslip_report extends  CI_Model
{
	
	public function get_list($bulan,$tahun)
	{
		# code...
	}
	public function get_unor_list()
	{
		$rs = $this->db->select('id_unor,nama_unor')
				 ->get('m_unor')
				 ->result();
		$result = [];
		
		foreach ($rs as $u) {
	 		$result[$u->id_unor]=$u->nama_unor;
	    }
	    return $result;		 
	}
}