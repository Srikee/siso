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

 Date: 21/05/2022 13:15:29
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
  `nurse_id` int(11) NULL DEFAULT NULL COMMENT 'ผู้นัด',
  `process` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การดำเนินการ\r\nW: กำลังนัด\r\nY: เข้าพบแล้ว\r\nC: ยกเลิก',
  `add_by` int(11) NULL DEFAULT NULL,
  `add_when` datetime(0) NULL DEFAULT NULL,
  `edit_by` int(11) NULL DEFAULT NULL,
  `edit_when` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`appointment_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for nurse
-- ----------------------------
DROP TABLE IF EXISTS `nurse`;
CREATE TABLE `nurse`  (
  `nurse_id` int(11) NOT NULL,
  `nurse_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nurse_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `add_by` int(11) NULL DEFAULT NULL,
  `add_when` datetime(0) NULL DEFAULT NULL,
  `edit_by` int(11) NULL DEFAULT NULL,
  `edit_when` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`nurse_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nurse
-- ----------------------------
INSERT INTO `nurse` VALUES (1, 'มะ', 'บอดอ', 'Y', 1, '2022-05-20 23:55:13', NULL, NULL);
INSERT INTO `nurse` VALUES (2, 'บาส', 'พยาบาล', 'Y', 1, '2022-05-20 23:55:37', NULL, NULL);

-- ----------------------------
-- Table structure for patient
-- ----------------------------
DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient`  (
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `patient_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `idcard` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เลขที่ประจำตัว',
  `bdate` date NULL DEFAULT NULL COMMENT 'วันเกิด',
  `disease` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'โรคประจำตัว',
  `lose` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'แพ้ยา',
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `add_by` int(11) NULL DEFAULT NULL,
  `add_when` datetime(0) NULL DEFAULT NULL,
  `edit_by` int(11) NULL DEFAULT NULL,
  `edit_when` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`patient_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patient
-- ----------------------------
INSERT INTO `patient` VALUES (1, 'เปาะมะ', 'ซิโซะ', '0812345678', '0001', '2022-05-21', 'กลัวควาย', 'ยากลัวควาย', 'Y', 1, '2022-05-20 21:32:09', 1, '2022-05-21 08:52:35');

-- ----------------------------
-- Table structure for treatment
-- ----------------------------
DROP TABLE IF EXISTS `treatment`;
CREATE TABLE `treatment`  (
  `treatment_id` int(11) NOT NULL,
  `patient_id` int(11) NULL DEFAULT NULL,
  `treatment_date` date NULL DEFAULT NULL,
  `symptom` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'อาการเจ็บป่วย',
  `diagnosis` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การวินิจฉัย',
  `treatment` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การรักษา',
  `nurse_id` int(11) NULL DEFAULT NULL COMMENT 'พยาบาล',
  `add_by` int(11) NULL DEFAULT NULL,
  `add_when` datetime(0) NULL DEFAULT NULL,
  `edit_by` int(11) NULL DEFAULT NULL,
  `edit_when` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`treatment_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `user_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `add_by` int(11) NULL DEFAULT NULL,
  `add_when` datetime(0) NULL DEFAULT NULL,
  `edit_by` int(11) NULL DEFAULT NULL,
  `edit_when` datetime(0) NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'มะ', 'ซิโซะควาย', 'siso', '1234', NULL, 'Y', 1, '2022-05-20 21:32:09', NULL, NULL);

SET FOREIGN_KEY_CHECKS = 1;
