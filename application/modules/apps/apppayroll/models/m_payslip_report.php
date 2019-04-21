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

	public function get_rekap_data($bulan,$tahun)
	{
		$select = "
			m.nama_unor,
			m.kode_unor AS kode_unor,
			Sum(p.attn_s) AS attn_s,
			Sum(p.attn_i) AS attn_i,
			Sum(p.attn_a) AS attn_a,
			Sum(p.attn_l) AS attn_l,
			Sum(p.attn_c) AS attn_c,
			Sum(p.base_sal) AS base_sal,
			Sum(p.gross_sal) AS gross_sal,
			Sum(p.net_pay) AS net_pay,
			Sum(p.alw_mar) AS alw_mar,
			Sum(p.alw_ch) AS alw_ch,
			Sum(p.alw_rc) AS alw_rc,
			Sum(p.alw_adv) AS alw_adv,
			Sum(p.alw_wt) AS alw_wt,
			Sum(p.alw_jt) AS alw_jt,
			Sum(p.alw_fd) AS alw_fd,
			Sum(p.alw_rs) AS alw_rs,
			Sum(p.alw_ot) AS alw_ot,
			Sum(p.alw_tr) AS alw_tr,
			Sum(p.alw_vhc_rt) AS alw_vhc_rt,
			Sum(p.alw_prf) AS alw_prf,
			Sum(p.alw_sh) AS alw_sh,
			Sum(p.alw_tpp) AS alw_tpp,
			Sum(p.alw_pph21) AS alw_pph21,
			Sum(p.alw_amt) AS alw_amt,
			Sum(p.ddc_pph21) AS ddc_pph21,

			Sum(p.ddc_bpjs_ket) AS ddc_bpjs_ket,
			Sum(p.ddc_bpjs_kes) AS ddc_bpjs_kes,
			Sum(p.ddc_aspen) AS ddc_aspen,
			Sum(p.ddc_f_kp) AS ddc_f_kp,
			Sum(p.ddc_wcl) AS ddc_wcl,
			Sum(p.ddc_wc) AS ddc_wc,
			Sum(p.ddc_dw) AS ddc_dw,
			Sum(p.ddc_zk) AS ddc_zk,
			Sum(p.ddc_shd) AS ddc_shd,
			Sum(p.ddc_tpt) AS ddc_tpt,
			Sum(p.ddc_wb) AS ddc_wb,
			Sum(p.ddc_amt) AS ddc_amt";

		$lastdate  = date('t', strtotime("{$tahun}-{$bulan}-01"));
		$print_dt = "{$tahun}-{$bulan}-{$lastdate}"; 

		$list_tmp =
		$this->db->select($select)
				 ->from('apr_sv_payslip AS p')
				 ->join('m_unor AS m','m.kode_unor = substr(p.kode_unor,1,5)','left')
				 ->where('print_dt',$print_dt)
				 ->group_by('substr(p.kode_unor,1,5)')
				 ->get()
				 ->result();
		$list_group = [
			'pusat' => [$this->_empty_rekap_str_row('PUSAT')],
			'wilayah_cabang_ikk' => [$this->_empty_rekap_str_row('WILAYAH/CABANG/IKK')]
		];		
		
		$group = [
			'pusat' => explode(',','03.01,05.01,02.01,04.01,14.01,15.01,21.01,17.01,22.01,19.01,24.01,18.01,20.01,25.01'),
			'wilayah_cabang_ikk'=>explode(',', '10.01,09.01,06.01,07.01,08.01,12.01,11.01')
		];
		$group_total = [
			'pusat' => $this->_empty_rekap_row('JUMLAH TOTAL : PUSAT'),
			'wilayah_cabang_ikk' => $this->_empty_rekap_row("JUMLAH TOTAL : \nWILAYAH/CABANG/IKK"),
			'total' =>  $this->_empty_rekap_row('JUMLAH TOTAL : ')
		];
		// $index = 0;
		// $total_rec = count($list_tmp);
		
		foreach ($list_tmp as $rec) {
			$kode_unor = $rec->kode_unor;
			$key = 'pusat';
		 
			if(in_array($kode_unor, $group['wilayah_cabang_ikk'])){
				$key = 'wilayah_cabang_ikk';
			}
			else if(in_array($kode_unor, $group['pusat'])){
				$key = 'pusat';
			}
			else {
				continue;
			}
			$rec->t = 'r';
			$list_group[$key][] = $rec;

			foreach ($rec as $prop => $value) {
				if(in_array($prop,['kode_unor','nama_unor','t'])){
					continue;
				}
				$group_total[$key][$prop] += (0 + $value);
				$group_total['total'][$prop] += (0 + $value);

				$rec->{$prop} = number_format($rec->{$prop}, 0, ",", ".");

				

			}

			// $index += 1; 
		}
		foreach ($group_total as &$rec) {
			foreach ($rec as $prop => $value) {
				if(in_array($prop,['kode_unor','nama_unor','t'])){
					continue;
				} 
				$rec[$prop] = number_format($rec[$prop], 0, ",", ".");
			}
		}
		$list_group['pusat'][] = $group_total['pusat'];
		$list_group['wilayah_cabang_ikk'][] = $group_total['wilayah_cabang_ikk'];
		$list_group['wilayah_cabang_ikk'][] = $group_total['total'];
		return [
			'list_group'  => array_merge($list_group['pusat']  , $list_group['wilayah_cabang_ikk'] ),
			'group_total' => $group_total,
			'group'=>$group
		];
	}

	public function _empty_rekap_row($nama_unor){
		return ['t'=>'r','nama_unor'=>$nama_unor,'attn_s'=>0,'attn_i'=>0,'attn_a'=>0,'attn_l'=>0,'attn_c'=>0,'base_sal'=>0,'gross_sal'=>0,'net_pay'=>0,'alw_mar'=>0,'alw_ch'=>0,'alw_rc'=>0,'alw_adv'=>0,'alw_wt'=>0,'alw_jt'=>0,'alw_fd'=>0,'alw_rs'=>0,'alw_ot'=>0,'alw_tr'=>0,'alw_prf'=>0,'alw_sh'=>0,'alw_tpp'=>0,'alw_pph21'=>0,'alw_amt'=>0,'ddc_bpjs_kes'=>0,'ddc_bpjs_ket'=>0,'ddc_aspen'=>0,'ddc_f_kp'=>0,'ddc_wcl'=>0,'ddc_wc'=>0,'ddc_dw'=>0,'ddc_zk'=>0,'ddc_shd'=>0,'ddc_tpt'=>0,'ddc_wb'=>0,'ddc_amt'=>0,'alw_vhc_rt'=>0,'ddc_pph21'=>0];
	}
	public function _empty_rekap_str_row($nama_unor)
	{
		return ['t'=>'c','nama_unor'=>$nama_unor,'kode_unor'=>'', 'attn_s'=>'','attn_i'=>'','attn_a'=>'','attn_l'=>'','attn_c'=>'','base_sal'=>'','gross_sal'=>'','net_pay'=>'','alw_mar'=>'','alw_ch'=>'','alw_rc'=>'','alw_adv'=>'','alw_wt'=>'','alw_jt'=>'','alw_fd'=>'','alw_rs'=>'','alw_ot'=>'','alw_tr'=>'','alw_prf'=>'','alw_sh'=>'','alw_tpp'=>'','alw_pph21'=>'','alw_amt'=>'','ddc_bpjs_kes'=>'','ddc_bpjs_ket'=>'','ddc_aspen'=>'','ddc_f_kp'=>'','ddc_wcl'=>'','ddc_wc'=>'','ddc_dw'=>'','ddc_zk'=>'','ddc_shd'=>'','ddc_tpt'=>'','ddc_wb'=>'','ddc_amt'=>'','alw_vhc_rt'=>'','ddc_pph21'=>'']; 
	}
}