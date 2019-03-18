<?php
class M_web extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function getopsivalue(){
		$hslqueryp = $this->db->get_where('p_setting_item', array('id_setting' => '5'))->result();
		$ff=json_decode($hslqueryp[0]->meta_value);
		return $ff;
	}

	function getwrapper($path,$posisi){
		$this->db->select('meta_value');
		$this->db->from('p_setting_item');
		$this->db->where('id_setting','10');
		$this->db->where('nama_item',$posisi);
		$this->db->like('meta_value','\"path_kanal\":\"'.$path.'\"');
		$hslquery = $this->db->get()->result();

		$res=(!empty($hslquery[0]->meta_value))	?	json_decode($hslquery[0]->meta_value)	:	json_decode("{\"widget\":[]}");
		return $res;
	}

	function cari_kanal($idd){
		$this->db->select('meta_value,nama_item,id_item');
		$this->db->from('p_setting_item');
		$this->db->where('id_setting','1');
		$this->db->like('meta_value','\"path_kanal\":\"'.$idd.'\"');
		$hslquery = $this->db->get()->result();

					@$hsl = json_decode($hslquery[0]->meta_value);
					@$hslq->nama_kanal=$hslquery[0]->nama_item;
					$hslq->path_kanal=@$hsl->path_root;
					$hslq->tipe=@$hsl->tipe;
					$hslq->theme=@$hsl->theme;
					$hslq->id_kanal=@$hslquery[0]->id_item;
					return $hslq;
	}

	function get_komponen(){
		$hslquery = $this->db->get_where('p_setting_item', array('id_setting' => '7'))->result();
		$hsl = array();
		foreach ($hslquery AS $key=>$val){ $hsl[]=$val->nama_item;}
		return $hsl;
	}


}
