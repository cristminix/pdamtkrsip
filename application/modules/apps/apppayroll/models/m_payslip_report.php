<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// require_once 'apppayroll_frontmdl' . EXT;

class M_payslip_report extends  CI_Model
{
	
	public function get_report_data($bulan,$tahun,$id_unor)
	{
		$lastdate  = date('t', strtotime("{$tahun}-{$bulan}-01"));
		$print_dt = "{$tahun}-{$bulan}-{$lastdate}"; 
		if(!empty($id_unor)){
			$this->db->where('id_unor',$id_unor);

		}
		return $this->db->where('print_dt',$print_dt)->order_by('empl_name','asc')->get('apr_sv_payslip')
					 
					 ->result();
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