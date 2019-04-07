<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// require_once 'apppayroll_frontmdl' . EXT;

class M_payslip_report extends  CI_Model
{
	
	public function get_report_data($bulan,$tahun,$id_unor,$empl_stat)
	{
		$lastdate  = date('t', strtotime("{$tahun}-{$bulan}-01"));
		$print_dt = "{$tahun}-{$bulan}-{$lastdate}"; 
		if(!empty($id_unor)){
			$this->db->like('p.kode_unor',$id_unor);

		}
		if(!empty($empl_stat)){
			$this->db->where('p.empl_stat',$empl_stat);

		}
		$result = $this->db->select('p.*')
						   ->where('p.print_dt',$print_dt)
						   // ->join('m_unor u','u.id_unor = p.id_unor','left')
						   ->order_by('p.empl_name','asc')->get('apr_sv_payslip p')

					 ->result();
		$fmt_num_kys = [
			'base_sal','gross_sal','net_pay',
			'alw_mar','alw_ch','alw_rc','alw_rs','alw_tr','alw_fd','alw_adv','alw_wt',
			'alw_jt','alw_ot','alw_prf','alw_sh','alw_vhc_rt','alw_tpp','alw_pph21',
			'alw_amt','ddc_amt',
			'ddc_pph21','ddc_bpjs_ket','ddc_bpjs_kes','ddc_aspen','ddc_wb','ddc_f_kp','ddc_wc','ddc_wcl',
			'ddc_dw','ddc_zk','ddc_shd','ddc_tpt',
		];			 
		foreach ($result as &$r) {
		 	$r->empid = substr($r->nipp, -4);
		 	foreach ($fmt_num_kys as $prop) {
		 		$r->{$prop} = $r->{$prop} + 0;
		 		$r->{$prop} = number_format($r->{$prop}, 0, ",", ".");
		 	}
		 }			 
		return $result;
	}
	public function get_unor_list()
	{
		$rs = $this->db->select('kode_unor,nama_unor')
				 ->where('LENGTH(kode_unor) = 5',null,false)
				 ->get('m_unor')
				 ->result();
		$result = [];
		
		foreach ($rs as $u) {
	 		$result[$u->kode_unor]=$u->nama_unor;
	    }
	    return $result;		 
	}
}