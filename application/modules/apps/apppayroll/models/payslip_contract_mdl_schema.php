<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'payslip_mdl_schema'. EXT;;
class Payslip_Contract_Mdl_Schema extends Payslip_Mdl_Schema
{
	public static function get_init_insert($tbl, $year, $month, $lastdate, $excl_ids_str) {
        return <<<SQL
        INSERT INTO {$tbl} (
                print_dt,
                empl_id,
                nipp,
                empl_name,
                gender,
                pob,
                dob,
                empl_gr,
                hire_date,
                los,
              
                created,
                modified
            )
                SELECT
                    '{$year}-{$month}-{$lastdate}',
                    rp.id_pegawai,
                    rp.nip_baru,
                    rp.nama_pegawai,
                    rp.gender,
                    rp.tempat_lahir,
                    rp.tanggal_lahir,
                    rp.kelompok_pegawai,
                    rp.tgl_terima,
                    YEAR('{$year}-{$month}-{$lastdate}') - YEAR(tgl_terima)- (DATE_FORMAT(tgl_terima, '%m%d') > DATE_FORMAT('{$year}-{$month}-{$lastdate}', '%m%d')),
                  
                    NOW(),
                    NOW()
                FROM r_pegawai rp
                    LEFT JOIN r_peg_golongan  rpg ON rpg.id_pegawai = rp.id_pegawai
                    WHERE rp.tgl_terima <= '{$year}-{$month}-{$lastdate}'
                    {$excl_ids_str}
                GROUP BY rp.id_pegawai;
SQL;
    }
}