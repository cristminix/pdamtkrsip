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

 Date: 08/04/2019 11:12:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for apr_ref_acc_number
-- ----------------------------
DROP TABLE IF EXISTS `apr_ref_acc_number`;
CREATE TABLE `apr_ref_acc_number`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empl_id` int(11) NULL DEFAULT NULL COMMENT 'Employee ID',
  `nipp` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `eff_date` date NULL DEFAULT NULL,
  `term_date` date NULL DEFAULT NULL COMMENT 'Termination date',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `annotation` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `active_status` tinyint(1) NULL DEFAULT 1,
  `menu_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `menu_order` int(10) NULL DEFAULT NULL,
  `created` datetime(0) NULL DEFAULT NULL,
  `modified` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Employee\'s Zakat Registration' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of apr_ref_acc_number
-- ----------------------------
INSERT INTO `apr_ref_acc_number` VALUES (1, 1, '690890268', '2019-04-30', NULL, 'RACHMAT INDRAJAYA', '12345678', NULL, 1, '', NULL, '2019-04-08 05:39:13', '2019-04-08 06:02:42');

SET FOREIGN_KEY_CHECKS = 1;
