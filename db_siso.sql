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

 Date: 21/05/2022 09:49:15
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
INSERT INTO `nurse` VALUES (1, 'นาง', 'พยาบาล1', 'Y', 1, '2022-05-20 23:55:13', NULL, NULL);
INSERT INTO `nurse` VALUES (2, 'นาย', 'พยาบาล2', 'Y', 1, '2022-05-20 23:55:37', NULL, NULL);

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
INSERT INTO `patient` VALUES (2, 'aa', 'ss', '0910451096', 'ฟฟฟฟ', '2022-05-21', 'หหห', 'กกกก', NULL, 1, '2022-05-21 00:26:40', NULL, NULL);

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
-- Records of treatment
-- ----------------------------
INSERT INTO `treatment` VALUES (1, 1, '2022-05-20', 'aa', 'ss', 'dd', 2, 1, '2022-05-20 23:57:57', 1, '2022-05-20 23:58:04');
INSERT INTO `treatment` VALUES (2, 2, '2022-05-21', 'dd', 'ddd', 'dd', 2, 1, '2022-05-21 00:27:13', NULL, NULL);

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
