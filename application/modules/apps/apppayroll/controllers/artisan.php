<?php
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use LucidFrameTest\Console\ConsoleTable;

class Artisan extends MX_Controller
{
    public function __construct($value = '')
    {
    	if(!defined('CLI_APP')){
    		// redirect(base_url());
    	}

        parent::__construct();
    }
    public function index($value='')
    {
    	echo 'This is index';
    }
    public function console($cmd = '', $a = '', $b = '', $c = '', $d = '', $e = '')
    {
        $method = str_replace(':', '_', $cmd);

        if (method_exists($this, $method)) {
            return $this->{$method}($a, $b, $c, $d, $e);
        }

        echo ('Unexistent command '."$cmd\n");
    }
    
    public function pph_21()
    {
        error_reporting(E_ALL);
        $tbl = 'apr_sv_payslip asp';

        $ql  = "

";

        $select_keys = [
            'base_sal' => 'GAJI POKOK',
            'alw_mar'  => 'ISTRI',
            'alw_ch'  => 'ANAK',
            'alw_rc' => 'BERAS',
            'alw_fd' => 'MAKAN',
            'alw_wt' => 'AIR',
            'alw_jt' => 'JABATAN',
            'alw_adv' => 'KHUSUS',
            'alw_prf' => 'PRESTASI',
            'alw_sh' => 'SHIFT',
            'alw_tpp' => 'TPP',
            'alw_vhc_rt' => 'TTPP',
            'alw_rs' => 'PERUMAHAN',
            'alw_tr' => 'TRANSPORT',
            'alw_ot' => 'LEMBUR',
            'ptkp_tariff' => 'PTKP',
            'ddc_bpjs_kes' => 'ASKES'
        ];
        $select = implode(',', array_keys($select_keys));
        // echo $select;
        // $records = $this->db->select('*')
        //                     ->from('apr_sv_payslip')
        //                     ->where('empl_stat','Tetap')
        //                     ->get()
        //                     ->result();
        $sample = (object)[
            'empl_name' => 'Nur Ilham',
            'ptkp_tariff' =>67500000,
            'base_sal'  => 2840885,
            'alw_mar'   => 426133,              // TNJ ISTRI
            'alw_ch'    => 568177,              //     ANAK
            'alw_rc'    => 400000,              //     BERAS
            'alw_wt'    => 66750,               //     AIR
            'alw_jt'    => 1500000,             //     JABATAN
            'alw_prf'   => 1592316,             //     PRESTASI
            'alw_adv'   => 0,                   //     KHUSUS
            'alw_ot'    => 0,                   //     LEMBUR
            'alw_rs'    => 450000,              //     PERUMAHAN
            'alw_tr'    => 570000,              //     TRANSPORTASI
            'alw_vhc_rt'  => 800000,            //     TTPP 
            'alw_fd'    => 570000,              //     MAKAN
            'alw_sh'    => 0,                   //     SHIFT
            'alw_tpp'   => 0,                   //     TPP
            'alw_pph21' => 0,                   //     PPH21
            'alw_amt'   => 0,                   // TOTAL TUNJANGAN
            'gross_sal' => 0,                   // GAJI KOTOR
            'ddc_pph21' => 0,                   // POT PPH21
            'ddc_bpjs_kes' => 47250,                //     ASKES
            'ddc_bpjs_ket' => 0,                //     ASTEK
            'ddc_aspen' => 0,                   //     ASPEN
            'ddc_f_kp'  => 0,                   //     FKP
            'ddc_wcl'   => 0,                   //     KOPERASI
            'ddc_wc'    => 100000,              //     KOPERASI WAJIB
            'ddc_dw'    => 206000,              //     DHARMA WANITA
            'ddc_tpt'   => 0,                   //     TPTGR
            'ddc_wb'    => 0,                   //     WATER BILL
            'ddc_zk'    => 0,                   //     ZAKAH
            'ddc_shd'   => 0,                   //     SHODAQOH
            'ddc_amt'   => 0,                   // JUMLAH POTONGAN
            'net_pay'   => 0,                   // GAJI DITERIMA

            'tax_bruto' => 0
        ];

        
        $records = [
            $sample
        ]+ $this->db->where('empl_stat','Tetap')->get('apr_sv_payslip')->result();

        // $ptkp = 54000000;
        $table = new LucidFrame\Console\ConsoleTable();
        $table_calc = new LucidFrame\Console\ConsoleTable();

        //foreach ($select_keys as $field => $caption) {
        $pph_21_calc = (object)[];
        $table->addHeader('NAMA')
              ->addHeader('GAPOK')
              ->addHeader('TNJ ISTERI')
              ->addHeader('TNJ ANAK')
              ->addHeader('TNJ BERAS')
              ->addHeader('TNJ AIR')
              ->addHeader('TNJ JABATAN')
              ->addHeader('TNJ PRESTASI')
              ->addHeader('TNJ LEMBUR')
              ->addHeader('TNJ KHUSUS')
              ->addHeader('TNJ PERUMAHAN')
              ->addHeader('TNJ TRANSPORT')
              ->addHeader('TNJ TTPP')
              ->addHeader('TNJ MAKAN')
              ->addHeader('TNJ SHIFT')
              ->addHeader('TNJ TPP')
              ->addHeader('TNJ PPH21')

              ->addHeader('GAJI KOTOR')
              
              ->addHeader('POT PPH21')
              ->addHeader('POT ASTEK')
              ->addHeader('POT ASKES')
              ->addHeader('POT ASPEN')
              ->addHeader('POT FKP')
              ->addHeader('POT KOPERASI')
              ->addHeader('POT KOPERASI WAJIB')
              ->addHeader('POT DHARMA WANITA')
              ->addHeader('POT TPTGR')
              ->addHeader('POT REK AIR')
              ->addHeader('POT ZAKAT')
              ->addHeader('POT SHODAQOH')

              ->addHeader('JUMLAH POTONGAN')

              ->addHeader('GAJI DITERIMA');

      $table_calc->addHeader('GAJI BRUTO')
              ->addHeader('POT ASTEK')
              ->addHeader('POT ASPEN')
              ->addHeader('POT ASPKES')
              ->addHeader('PAJAK BRUTO')
              ->addHeader('BIAYA JABATAN')
              ->addHeader('BIAYA ASTEK + ASPEN + ASPKES')
              ->addHeader('TOTAL PENGURANG')
              ->addHeader('PAJAK NETTO')
              ->addHeader('PAJAK DISETAHUNKAN')
              ->addHeader('PTKP')
              ->addHeader('NILAI KENA PAJAK')
              ->addHeader('PAJAK SETAHUN')
              ->addHeader('PAJAK PERBULAN')
              ->addHeader('BN');



            // $table->addRow()
       // }
        // $table
            // ->addHeader('Language')
            // ->addHeader('Year')
            // ->addRow()
            //     ->addColumn('PHP')
            //     ->addColumn(1994)
            // ->addRow()
            //     ->addColumn('C++')
            //     ->addColumn(1983)
            // ->addRow()
            //     ->addColumn('C')
            //     ->addColumn(1970)
            // ->display()
        // ;
        // print_r($records);
        // exit;
        foreach ($records as &$row) {
            $ad = 0; $bl = -1;
            $stop = false;
            // $row->alw_fd = $row->alw_tr;
            foreach ($row as &$item) {
                if(empty($item)){
                    $item = 0;
                }
            }
            while(!$stop){

                $o  = round($row->base_sal); // GAJI POKOK
                $p  = round($row->alw_mar); // ISTERI 
                $q  = round($row->alw_ch); // ANAK
                $r  = round($row->alw_rc); // BERAS
                $s  = round($row->alw_wt); // AIR
                $t  = round($row->alw_jt); // JABATAN
                $u  = round($row->alw_prf); // PRESTASI
                $v  = round($row->alw_ot); // LEMBUR
                $w  = round($row->alw_adv); // KHUSUS
                $x  = round($row->alw_rs); // PERUMAHAN 
                $y  = round($row->alw_tr); // TRANSPORT 
                
                $z  = round($row->alw_vhc_rt); // TTPP
                
                $aa = round($row->alw_fd); // MAKAN
                $ab = round($row->alw_sh); // SHIFT
                $ac = round($row->alw_tpp); // TPP

                $ad = $bl > 0 ? $bl: 0; // PPH21 , BL look at bottom

                // echo "alw_pph21 = $ad <br>";
                $row->alw_pph21 = $ad;
                $row->ddc_pph21 = $ad;
                
                $ae = $o + $p + $q + $r + $s + $t + $u + $v + $w + $x + $y + $z + $aa + $ab + $ac + $ad  ;  // GAJI KOTOR , =SUM(O4:AD4)
                // echo "$o + $p + $q + $r + $s + $t + $u + $v + $w + $x + $y + $z + $aa + $ab + $ac + $ad <br>";
                // echo "gaji_bruto :$ae<br>";
                $ag = round(($ae - $z) * 0.02);  // POTONGAN ASTEK  , =(AE4-Z4)*2% 
                $row->ddc_bpjs_ket = $ag;
                
                $ai = ($o + $p + $q + $x) * 0.05;//$r->ddc_aspen;  // POTOGAN ASPEN, =(SUM(O4:Q4)+X4)*5%
                $row->ddc_aspen = round($ai);

                $ah = $row->ddc_bpjs_kes;  // POTONGAN ASKES 
                
                $ay = $ae; // GAJI BRUTO
                
                $row->gross_sal = $ay;
                $pph_21_calc_gaji_bruto = $ay;

                $az = $ag; // POTONGAN ASTEK
                $ba = $ai; // POTONGAN ASPEN
                $bb = $ah; // POTONGAN ASKES
                //    
                $bc = $ay + $az + $ba + $bb; // PAJAK BRUTO, =SUM(AY4:BB4)

                $pph_21_calc_pajak_bruto = $bc;

                $bd = (0.05 * $bc) <= 500000 ? (0.05 * $bc) : 500000; //BIAYA JABATAN , =IF((5%*BC4)<=500000,BC4*5%,500000) 
                $pph_21_calc_biaya_jabatan = $bd;

                $be = $az + $ba + $bb; // Astek + Aspen + Askes, =SUM(AZ4:BB4)
                $pph_21_calc_biaya_astek_askes_aspen = $be;
                
                $bf = ($bd + $be); // TOTAL PENGURANG , =SUM(BD4:BE4)
                $pph_21_calc_total_pengurang = $bf;

                $bg = ($bc - $bf); // PAJAK NETTO , BC4-BF4 
                $pph_21_calc_pajak_netto = $bg;

                $bh = ($bg * 12); // PAJAK DISTAHUNKAN , BG4*12
                $pph_21_calc_pajak_disetahunkan = $bh;    

                $bi = round($row->ptkp_tariff); // PTKP
                $pph_21_calc_ptkp = $bi;

                $bj = ($bh - $bi) > 0 ? ($bh - $bi) : 0; // NILAI KENA PAJAK , =IF(BH4-BI4>0,BH4-BI4,0)
                
                $pph_21_calc_nilai_kena_pajak = $bj;
                
                $bk = round(($bj<=0?0:($bj<=50000000?($bj*0.05):($bj>500000000?(($bj-500000000)*0.30)+95000000:($bj>250000000?(($bj-250000000)*0.25)+32500000:($bj>50000000?((($bj-50000000)*0.15)+2500000):0))))),0);
                //PAJAK SETAHUN
                // if($bj <= 0){
                //     $bk = 0;
                // }else if($bj <= 50000000){
                //     $bk = ($bj * 0.05); 
                // }else if($bj > 50000000 ){
                //     $bk = ( ($bj-500000000) * 0.3 ) + 95000000;
                // }else if($bj > 250000000){
                //     $bk = (($bj-250000000) * 0.25 ) + 32500000;
                // }else if($bj > 50000000){
                //     $bk = ( ($bj-50000000) * 0.15 ) + 2500000;
                // }
                // $bk = round($bk,0);

                $pph_21_calc_pajak_setahun = $bk;
                $bl = ($bk / 12); // PAJAK PERBULAN , =BK4/12
                //  echo "pajak_perbulan = $bl <br>";
                $pph_21_calc_pajak_perbulan = $bl;

                // $ad = $bl; // PPH21 
                $af = $ad; // PPH21

                // $ag = 0;
                // $ah = 0;
                
                

                $aj = round($row->ddc_f_kp); // FKP
                $ak = round($row->ddc_wcl); // Koperasi
                $al = round($row->ddc_wc); // Koperasi Wajib
                $am = round($row->ddc_dw); // DM ., Dharma wanita
                $an = round($row->ddc_tpt); // TPTGR
                $ao = round($row->ddc_wb); // REK AER
                $ap = ($ae * 0.025);  // ZAKAT , 2.5%*AE4
                
                $row->ddc_zk = $ap;

                $aq = round($row->ddc_shd);  // SHODAQOH

                $ar   = $af + $ag + $ah + $ai + $aj + $ak + $al + $am + $an + $ao + $ap + $aq; // JUMLAH POTONGAN , =SUM(AF4:AQ4)
                
                $row->ddc_amt = $ar;     

                $as   = $ae - $ar; // GAJI DITERIMA
                
                $row->net_pay = $as;

                $aw   = 0; // ?

                $bn   = $as - $aw;

                
                $pph_21_calc = (object)[
                    'gaji_bruto'    => $pph_21_calc_gaji_bruto,
                    
                    'potongan_astek' => $row->ddc_bpjs_ket,    
                    'potongan_aspen' => $row->ddc_aspen,    
                    'potongan_askes' => $row->ddc_bpjs_kes,  

                    'pajak_bruto'   => $pph_21_calc_pajak_bruto,

                    'biaya_jabatan' => $pph_21_calc_biaya_jabatan,
                    'biaya_astek_askes_aspen' => ($row->ddc_bpjs_kes + $row->ddc_bpjs_ket + $row->ddc_aspen),
                    'total_pengurang' => $pph_21_calc_total_pengurang,
                    'pajak_netto'   => $pph_21_calc_pajak_netto,
                    'pajak_disetahunkan' => $pph_21_calc_pajak_disetahunkan,
                    'ptkp' => $pph_21_calc_ptkp,
                    'nilai_kena_pajak' => $pph_21_calc_nilai_kena_pajak,
                    'pajak_setahun' => $pph_21_calc_pajak_setahun,
                    'pajak_perbulan' =>  $pph_21_calc_pajak_perbulan ,
                    'bn' => $bn
                ];    

                
                
                if($bl == $ad || $bl < 0){
                    $stop = true;
                    // break;
                } 
                // $ad = $bl;

            }
            //echo $ad . "<br/>";
            $table->addRow();
            // foreach (array_keys($select_keys) as $prop) {
            $table->addColumn($row->empl_name)
                  ->addColumn($row->base_sal)
                  ->addColumn($row->alw_mar)
                  ->addColumn($row->alw_ch)
                  ->addColumn($row->alw_rc)
                  ->addColumn($row->alw_wt)
                  ->addColumn($row->alw_jt)
                  ->addColumn($row->alw_prf)
                  ->addColumn($row->alw_ot)
                  ->addColumn($row->alw_adv)
                  ->addColumn($row->alw_rs)
                  ->addColumn($row->alw_tr)
                  ->addColumn($row->alw_vhc_rt)
                  ->addColumn($row->alw_fd)
                  ->addColumn($row->alw_sh)
                  ->addColumn($row->alw_tpp)
                  ->addColumn($row->alw_pph21)

                  ->addColumn($row->gross_sal)
                  
                  ->addColumn($row->ddc_pph21)
                  ->addColumn($row->ddc_bpjs_ket)
                  ->addColumn($row->ddc_bpjs_kes)
                  ->addColumn($row->ddc_aspen)
                  ->addColumn($row->ddc_f_kp)
                  ->addColumn($row->ddc_wcl)
                  ->addColumn($row->ddc_wc)
                  ->addColumn($row->ddc_dw)
                  ->addColumn($row->ddc_tpt)
                  ->addColumn($row->ddc_wb)
                  ->addColumn($row->ddc_zk)
                  ->addColumn($row->ddc_shd)
                  ->addColumn($row->ddc_amt)
                  ->addColumn($row->net_pay);
        $table_calc->addRow()
                  ->addColumn($pph_21_calc->gaji_bruto)
                  ->addColumn($pph_21_calc->potongan_astek)
                  ->addColumn($pph_21_calc->potongan_aspen)
                  ->addColumn($pph_21_calc->potongan_askes)
                  ->addColumn($pph_21_calc->pajak_bruto)
                  ->addColumn($pph_21_calc->biaya_jabatan)
                  ->addColumn($pph_21_calc->biaya_astek_askes_aspen)
                  ->addColumn($pph_21_calc->total_pengurang)
                  ->addColumn($pph_21_calc->pajak_netto)
                  ->addColumn($pph_21_calc->pajak_disetahunkan)
                  ->addColumn($pph_21_calc->ptkp)
                  ->addColumn($pph_21_calc->nilai_kena_pajak)
                  ->addColumn($pph_21_calc->pajak_setahun)
                  ->addColumn($pph_21_calc->pajak_perbulan)
                  ->addColumn($pph_21_calc->bn);
                    
            // }

            // break;
        }

        $table->display();
        $table_calc->display();
    }
    public function test($value='')
    {
      echo md5('confirm-upload');
    }
    public function get_pegawai()
    {
       $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
      // header('content-type:text/plain');
      $post_keys = 'hal:1,batas:999999999,cari,pns:all,kode,pkt,jbt,gender,agama,status,jenjang';
      $post_keys = explode(',', $post_keys);
      foreach ($post_keys as $key => $value) {
        $post_kv = explode(':', $value);
        if(count($post_kv)==2){
          $_POST[$post_kv[0]]=$post_kv[1];
        }else{
          $_POST[$value] = '';
        }
      }
      $r = Modules::run("appbkpp/pegawai/getaktif");
      $r = trim($r);
      $r = json_decode($r);
      unset($r->pager);

      $table = new LucidFrame\Console\ConsoleTable();
      $props = ['nip_baru','status_peg'];
      $props = array_keys((array)$r->hslquery[0]);
      
           
      $unset_props =  ['id','nomor_telepon','tmt_cpns','tmt_pns','id_pangkat',
                       'kode_golongan','nama_golongan','kode_pangkat','nama_pangkat',
                       'tmt_pangkat','mk_gol_tahun','mk_gol_bulan','id_unor',
                       'kode_unor','nama_unor','jab_type','nomenklatur_jabatan','nomenklatur_pada',
                       'tugas_tambahan','tmt_jabatan','tmt_ese','id_pendidikan',
                       'nama_pendidikan','pend_jurusan', 'nama_sekolah', 'nama_jenjang', 'nama_jenjang_rumpun', 'tanggal_lulus', 'tahun_lulus', 'nama_diklat_struk', 
                       'tanggal_sttpl_diklat_struk', 'tmt_kontrak', 'tmt_capeg', 'tmt_tetap', 'bup','status_peg'
      ];


      // print_r($props);
      $table->addHeader('NO');
      foreach ($props as $prop) {
        if(!in_array($prop, $unset_props)){
            $table->addHeader($prop);
        }
        
      }
      $this->db->query("TRUNCATE apr_r_pegawai;");
      $no = 1;
      foreach($r->hslquery as $row){
        $table->addRow()->addColumn($no++);
        foreach ($props as $prop) {
           $keys =  (array_keys((array)$row));
           echo "'" . implode(",'", $keys) . "';\n\n";
           if(empty($row->{$prop})){
            $row->{$prop} = '';
          }
          if(in_array($prop, $unset_props)){
              unset($row->{$prop});
          }
          else{
            $table->addColumn($row->{$prop});
          }
        }

         $this->db->insert('apr_r_pegawai',$row);



        
      }
      $table->display();
      exit();
    }
}