/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100422
 Source Host           : localhost:3306
 Source Schema         : db_siso

 Target Server Type    : MySQL
 Target Server Version : 100422
 File Encoding         : 65001

 Date: 21/05/2022 11:37:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for appointment
-- ----------------------------
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment`  (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) NULL DEFAULT NULL,
  `appointment_date` date NULL DEFAULT NULL COMMENT 'วันที่นัด',
  `appointment_desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียดการนัด',
  `nurse_id` int(11) NULL DEFAULT NULL COMMENT 'พยาบาล',
  `process` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การดำเนินการ\r\nN: รอดำเนินการ\r\nY: ดำเนินการแล้ว',
  `add_by` int(11) NULL DEFAULT NULL,
  `add_when` datetime(0) NULL DEFAULT NULL,
  `edit_by` int(11) NULL DEFAULT NULL,
  `edit_when` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`appointment_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
