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
            'ddc_bpjs_kes' => 0,                //     ASKES
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
        ];

        // $ptkp = 54000000;
        $table = new LucidFrame\Console\ConsoleTable();
        $table_calc = new LucidFrame\Console\ConsoleTable();

        //foreach ($select_keys as $field => $caption) {
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
        foreach ($records as $row) {
            $ad = 0; $bl = -1;
            // $row->alw_fd = $row->alw_tr;
            while(true){

                $o  = round($row->base_sal); // GAJI POKOK
                $p  = round($row->alw_mar); // ISTERI 
                $q  = round($row->alw_ch); // ANAK
                $r  = round($row->alw_rc); // BERAS
                $s  = round($row->alw_wt); // AIR
                $t  = round($row->alw_jt); // JABATAN
                $u  = round($row->alw_adv); // PRESTASI
                $v  = round($row->alw_ot); // LEMBUR
                $w  = round($row->alw_adv); // KHUSUS
                $x  = round($row->alw_rs); // PERUMAHAN 
                $y  = round($row->alw_tr); // TRANSPORT 
                
                $z  = round($row->alw_vhc_rt); // TTPP
                
                $aa = $y; // MAKAN
                $ab = round($row->alw_sh); // SHIFT
                $ac = round($row->alw_tpp); // TPP

                $ad = $bl > 0 ? $bl: 0; // PPH21 , BL look at bottom

                
                
                $ai = ($o + $p + $q + $x) * 0.05;//$r->ddc_aspen;  // POTOGAN ASPEN, =(SUM(O4:Q4)+X4)*5%
                
                $ah = $row->ddc_bpjs_kes;  // POTONGAN ASKES
                
                $ae = $o + $p + $q + $r + $s + $t + $u + $v + $w + $x + $y + $z + $aa + $ab + $ac + $ad  ;  // GAJI KOTOR , =SUM(O4:AD4)
                
                $ag = ($ae - $z) * 0.02;  // POTONGAN ASTEK  , =(AE4-Z4)*2% 
                 
                
                $ay = $ae; // GAJI BRUTO

                $az = $ag; // POTONGAN ASTEK
                $ba = $ai; // POTONGAN ASPEN
                $bb = $ah; // POTONGAN ASKES
                //    
                $bc = $ay + $az + $ba + $bb; // PAJAK BRUTO, =SUM(AY4:BB4)

                $bd = (0.05 * $bc) <= 500000 ? (0.05 * $bc) : 500000; //BIAYA JABATAN , =IF((5%*BC4)<=500000,BC4*5%,500000) 
                

                $be = $az + $ba + $bb; // Astek + Aspen + Askes, =SUM(AZ4:BB4)
                
                $bf = ($bd + $be); // TOTAL PENGURANG , =SUM(BD4:BE4)

                $bg = ($bc - $bf); // PAJAK NETTO , BC4-BF4 

                $bh = ($bg * 12); // PAJAK DISTAHUNKAN , BG4*12
                $bi = round($row->ptkp_tariff); // PTKP

                $bj = ($bh - $bi) > 0 ? ($bh - $bi) : 0; // NILAI KENA PAJAK , =IF(BH4-BI4>0,BH4-BI4,0)
                //PAJAK SETAHUN
                $bk   = $bj <= 0 ? 0 : (
                                            $bj <= 50000000 ? ($bj * 0.05) : (
                                                                                $bj > 50000000 ? ((($bj-500000000)*0.3)+95000000) : (
                                                                                                                                      $bj > 250000000 ?  ((($bj-250000000)*0.25)+32500000) : (
                                                                                                                                                                                                $bj > 50000000 ? ((($bj-50000000)*0.15)+2500000) : 0
                                                                                                                                                                                             ) 

                                                                                                                                    )
                                                                             )
                                       );

                $bl = ($bk / 12); // PAJAK PERBULAN , =BK4/12

                $ad = $bl; // PPH21 
                $af = $ad; // PPH21

                // $ag = 0;
                // $ah = 0;
                
                

                $aj = 0; // FKP
                $ak = 0; // Koperasi
                $al = 0; // Koperasi Wajib
                $am = 0; // DM ., Dharma wanita
                $an = 0; // TPTGR
                $ao = 0; // REK AER
                $ap = ($ae * 0.025);  // ZAKAT , 2.5%*AE4
                $aq = 0;  // SHODAQOH

                $ar   = $af + $ag + $ah + $ai + $aj + $ak + $al + $am + $an + $ao + $ap + $aq; // JUMLAH POTONGAN , =SUM(AF4:AQ4)
         
                $as   = $ae - $ar; // GAJI DITERIMA

                $aw   = 0; // ?

                $bn   = $as - $aw;

                
                $pph_21_calc = (object)[
                    'gaji_bruto'    => $row->gross_sal,
                    
                    'potongan_astek' => $row->ddc_bpjs_ket,    
                    'potongan_aspen' => $row->ddc_aspen,    
                    'potongan_askes' => $row->ddc_bpjs_kes,  

                    'pajak_bruto'   => $row->tax_bruto,

                    'biaya_jabatan' => 0,
                    'biaya_astek_askes_aspen' => ($row->ddc_bpjs_kes + $row->ddc_bpjs_ket + $row->ddc_aspen),
                    'total_pengurang' => 0,
                    'pajak_netto'   => 0,
                    'pajak_disetahunkan' => 0,
                    'ptkp' => $row->ptkp_tariff,
                    'nilai_kena_pajak' => 0,
                    'pajak_setahun' => 0,
                    'pajak_perbulan' => 0,
                    'bn' => 0
                ];    

                if($bl === $ad || $bl == 0){
                    break;
                }


            }
            echo $ad . "\n";
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
}