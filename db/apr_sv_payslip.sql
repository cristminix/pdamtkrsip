/*
 Navicat Premium Data Transfer

 Source Server         : Maria DB Local
 Source Server Type    : MariaDB
 Source Server Version : 50560
 Source Host           : localhost:3306
 Source Schema         : db_pdamtkrsip

 Target Server Type    : MariaDB
 Target Server Version : 50560
 File Encoding         : 65001

 Date: 24/03/2019 19:17:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for apr_sv_payslip
-- ----------------------------
DROP TABLE IF EXISTS `apr_sv_payslip`;
CREATE TABLE `apr_sv_payslip`  (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `print_dt` date NULL DEFAULT NULL COMMENT 'Printed date - Periodical Report Group',
  `empl_id` int(20) NULL DEFAULT NULL COMMENT 'Employee ID for DB',
  `nipp` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Official Employee ID',
  `empl_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Employee Name',
  `job_unit` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `job_title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pdm_eff_date` date NULL DEFAULT NULL COMMENT 'Promotion,  Demotion and Mutation Effective Date',
  `attn_s` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'Attendance Code S',
  `attn_i` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'Attendance Code I',
  `attn_a` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'Attendance Code A',
  `attn_l` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'Attendance Code L',
  `attn_c` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'Attendance Code C',
  `attn_t` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0' COMMENT 'Attendance Code T',
  `alw_work_day` int(2) NULL DEFAULT 22 COMMENT 'Allowance Day on Current Month',
  `work_day` int(2) NULL DEFAULT 22 COMMENT 'Work Day on Current Month',
  `empl_work_day` int(2) NULL DEFAULT 22 COMMENT 'Attend Day on Current Month',
  `base_sal_id` int(11) NULL DEFAULT NULL COMMENT 'Base Salary ID on m_gaji_pokok',
  `base_sal` double NULL DEFAULT NULL COMMENT 'Base Salary',
  `base_sal_perhour` double NULL DEFAULT NULL COMMENT 'Base Salary per Hour',
  `gross_sal` double NULL DEFAULT NULL COMMENT 'Brutto',
  `gross_sal_tax` double NULL DEFAULT NULL COMMENT 'Brutto for Tax',
  `net_pay` double NULL DEFAULT NULL COMMENT 'Take home pay',
  `alw_mar` double NULL DEFAULT NULL COMMENT 'Marital Allowance',
  `alw_ch` double NULL DEFAULT NULL COMMENT 'Children Allowance',
  `alw_rc` double NULL DEFAULT NULL COMMENT 'Rice Allowance',
  `alw_rc_ch_cnt` int(2) NULL DEFAULT 0 COMMENT 'Children count for Rice Allowance',
  `alw_rc_sp_cnt` int(1) NULL DEFAULT 0 COMMENT 'Spouse count for Rice Allowance',
  `alw_adv` double NULL DEFAULT NULL COMMENT 'Advance Allowance',
  `alw_wt` double NULL DEFAULT NULL COMMENT 'Water Allowance',
  `alw_jt` double NULL DEFAULT NULL COMMENT 'Job Title Allowance',
  `alw_jt_tax` double NULL DEFAULT NULL COMMENT 'Job Title Allowance for Tax',
  `alw_fd` double NULL DEFAULT NULL COMMENT 'Lunch Allowance',
  `alw_fd_set` tinyint(1) NULL DEFAULT 1,
  `alw_fd_perday` double NULL DEFAULT 0 COMMENT 'Lunch Allowance per day',
  `alw_rs` double NULL DEFAULT NULL COMMENT 'Residence Allowance',
  `alw_ot` double NULL DEFAULT NULL COMMENT 'Overtime Allowance',
  `alw_tr` double NULL DEFAULT NULL COMMENT 'Transportation Allowance',
  `alw_tr_set` tinyint(1) NULL DEFAULT 1,
  `alw_tr_perday` double NULL DEFAULT 0 COMMENT 'Transportation Allowance per day per day',
  `alw_prf` double NULL DEFAULT NULL COMMENT 'Performance Allowance',
  `alw_prf_set` tinyint(1) NULL DEFAULT 1,
  `alw_prf_perday` double NULL DEFAULT 0 COMMENT 'Performance Allowance per day',
  `alw_sh` double NULL DEFAULT NULL COMMENT 'Work Shift Allowance',
  `alw_vhc_rt` double NULL DEFAULT NULL COMMENT 'Vehicle Rental Allowance',
  `alw_tpp` double NULL DEFAULT NULL COMMENT 'TPP Allowance',
  `alw_tpp_remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'TPP Allowance Remarks',
  `alw_pph21` double NULL DEFAULT NULL COMMENT 'PPh21 Allowance',
  `apr_ref_ptkp_tariff_id` int(11) NULL DEFAULT NULL,
  `ptkp_tariff` double NULL DEFAULT NULL COMMENT 'Tariff PTKP',
  `apr_ref_pph21_tariff_id` int(11) NULL DEFAULT NULL,
  `pph21_tax` double NULL DEFAULT NULL COMMENT 'Tariff Pph 21',
  `tax_ddc_jt` double NULL DEFAULT NULL COMMENT 'Job Title for Tax Deduction',
  `tax_ddc_jht` double NULL DEFAULT NULL COMMENT 'JHT for Tax Deduction',
  `tax_ddc_jp` double NULL DEFAULT NULL COMMENT 'JP for Tax Deduction',
  `tax_ddc` double NULL DEFAULT NULL COMMENT 'Tax Deduction',
  `tax_netto` double NULL DEFAULT NULL COMMENT 'Net Pay for Tax',
  `tax_base` double NULL DEFAULT NULL COMMENT 'Basic amount  for Tax calculation',
  `tax_annual` double NULL DEFAULT NULL COMMENT 'Tax in a year',
  `alw_amt` double NULL DEFAULT NULL COMMENT 'Total Allowance Amount',
  `ddc_pph21` double NULL DEFAULT NULL COMMENT 'PPh21 Deduction',
  `empl_npwp` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'NPWP',
  `ddc_bpjs_ket` double NULL DEFAULT NULL COMMENT 'BPJS Ketenagakerjaan Deduction',
  `ddc_bpjs_kes` double NULL DEFAULT NULL COMMENT 'BPJS Kesehatan Deduction',
  `ddc_aspen` double NULL DEFAULT NULL COMMENT 'ASPEN Deduction',
  `ddc_f_kp` double NULL DEFAULT NULL COMMENT 'F-KP Deduction',
  `empl_fkp` int(11) NULL DEFAULT NULL COMMENT 'FKP Member',
  `ddc_wcl` double NULL DEFAULT NULL COMMENT 'Worker Cooperative Loan Deduction',
  `ddc_wc` double NULL DEFAULT NULL COMMENT 'Worker Cooperative Obligatory Deposit Deduction',
  `empl_wc` int(1) NULL DEFAULT 0 COMMENT 'Worker Cooperative Member',
  `ddc_dw` double NULL DEFAULT NULL COMMENT 'DHARMA WANITA Deduction',
  `empl_dw` int(1) NULL DEFAULT NULL COMMENT 'DHARMA WANITA Member',
  `ddc_zk` double NULL DEFAULT NULL COMMENT 'ZAKAT Deduction',
  `empl_zk` int(1) NULL DEFAULT NULL COMMENT 'ZAKAT Member',
  `ddc_shd` double NULL DEFAULT NULL COMMENT 'SHODAQOH Deduction',
  `ddc_tpt` double NULL DEFAULT NULL COMMENT 'TPTGR Deduction',
  `ddc_tpt_remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'TPTGR Deduction Notes',
  `ddc_wb` double NULL DEFAULT NULL COMMENT 'Water Bill Deduction',
  `empl_wb` int(1) NULL DEFAULT NULL,
  `ddc_amt` double NULL DEFAULT NULL COMMENT 'Deduction Amount',
  `ptkp_amt` double NULL DEFAULT NULL COMMENT 'PTKP Amount',
  `gender` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pob` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Place of Birth',
  `dob` date NULL DEFAULT NULL COMMENT 'Date of Birth',
  `empl_stat` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Employement Status',
  `empl_gr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Employement Group',
  `mar_stat` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Marital Status',
  `child_cnt` tinyint(2) NULL DEFAULT 0 COMMENT 'Child count',
  `hire_date` date NULL DEFAULT NULL,
  `los` int(11) NULL DEFAULT NULL COMMENT 'Length of Service in year',
  `grade_id` int(11) NULL DEFAULT NULL COMMENT 'kode_golongan on r_peg_golongan',
  `grade` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lock` int(1) NULL DEFAULT 0 COMMENT 'No Update',
  `created` datetime(0) NULL DEFAULT NULL,
  `modified` datetime(0) NULL DEFAULT NULL,
  `kode_peringkat` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lama_kontrak` int(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `print_dt`(`print_dt`) USING BTREE,
  INDEX `empl_id`(`empl_id`) USING BTREE,
  INDEX `nipp`(`nipp`) USING BTREE,
  INDEX `apr_ref_pph21_tariff_id`(`apr_ref_pph21_tariff_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Sheet View of Employee\'s Pay Slip' ROW_FORMAT = Compact;

-- ----------------------------
-- Triggers structure for table apr_sv_payslip
-- ----------------------------
DROP TRIGGER IF EXISTS `payslip_total`;
delimiter ;;
CREATE TRIGGER `payslip_total` BEFORE UPDATE ON `apr_sv_payslip` FOR EACH ROW BEGIN
SET NEW.alw_amt = 
  IFNULL(NEW.alw_pph21, 0) +
  IFNULL(NEW.alw_mar, 0) +
  IFNULL(NEW.alw_ch, 0) +
  IFNULL(NEW.alw_rc, 0) +
  IFNULL(NEW.alw_adv, 0) +
  IFNULL(NEW.alw_wt, 0) +
  IFNULL(NEW.alw_jt, 0) +
  IFNULL(NEW.alw_fd, 0) +
  IFNULL(NEW.alw_rs, 0) +
  IFNULL(NEW.alw_ot, 0) +
  IFNULL(NEW.alw_tr, 0) +
  IFNULL(NEW.alw_prf, 0) +
  IFNULL(NEW.alw_sh, 0) +
  IFNULL(NEW.alw_vhc_rt, 0) +
  IFNULL(NEW.alw_tpp, 0)
  ,
  NEW.ddc_amt = 
  IFNULL(NEW.ddc_pph21, 0) +
  IFNULL(NEW.ddc_bpjs_ket, 0) +
  IFNULL(NEW.ddc_bpjs_kes, 0) +
  IFNULL(NEW.ddc_aspen, 0) +
  IFNULL(NEW.ddc_f_kp, 0) +
  IFNULL(NEW.ddc_wcl, 0) +
  IFNULL(NEW.ddc_wc, 0) +
  IFNULL(NEW.ddc_dw, 0) +
  IFNULL(NEW.ddc_zk, 0) +
  IFNULL(NEW.ddc_shd, 0) +
  IFNULL(NEW.ddc_tpt, 0) +
  IFNULL(NEW.ddc_wb, 0) 
  ,
  NEW.alw_work_day = 
    NEW.work_day - 
      (IFNULL(NEW.attn_i, 0) + 
        IFNULL(NEW.attn_a, 0) +
        IFNULL(NEW.attn_l, 0) 
      )
  ,
  NEW.empl_work_day = 
    NEW.work_day - 
      (
        IFNULL(NEW.attn_s, 0) + 
        IFNULL(NEW.attn_i, 0) + 
        IFNULL(NEW.attn_a, 0) +
        IFNULL(NEW.attn_c, 0) 
      )
  ,
  NEW.alw_fd = 
    IF(
      NEW.alw_fd_set = 1 AND NEW.empl_gr <> 'Dewan Pengawas'
      ,((IFNULL(NEW.work_day,0) - 
        (IFNULL(NEW.attn_i, 0) + 
          IFNULL(NEW.attn_a, 0) +
          IFNULL(NEW.attn_l, 0) 
        ))
        * NEW.alw_fd_perday
        )
      ,NULL
    )
  ,
    NEW.alw_tr = 
    IF(NEW.alw_tr_set =1 AND NEW.empl_gr <> 'Dewan Pengawas'
      ,((IFNULL(NEW.work_day,0) - 
        (IFNULL(NEW.attn_i, 0) + 
          IFNULL(NEW.attn_a, 0) +
          IFNULL(NEW.attn_l, 0) 
        ))
        * NEW.alw_tr_perday)
       ,NULL
     )
   ,
    NEW.alw_prf = 
     IF(NEW.alw_prf_set = 1 AND NEW.empl_gr <> 'Dewan Pengawas'  AND NEW.empl_stat <> 'Kontrak'
       ,((IFNULL(NEW.work_day,0) - 
        (IFNULL(NEW.attn_i, 0) + 
          IFNULL(NEW.attn_a, 0) +
          IFNULL(NEW.attn_l, 0) 
        ))
        * NEW.alw_prf_perday)
       ,NULL
    )
		,
		NEW.alw_adv =
		IF(NEW.empl_stat = 'Kontrak', 53731
			,NEW.alw_adv
		)
    
		
		,
    NEW.gross_sal = 
        IFNULL(NEW.base_sal, 0) + 
        IFNULL(NEW.alw_amt, 0)
    ,
    NEW.net_pay = 
        IFNULL(NEW.gross_sal, 0) - 
        IFNULL(NEW.ddc_amt, 0)
;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
