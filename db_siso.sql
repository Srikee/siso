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

 Date: 24/05/2022 20:22:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for appointment
-- ----------------------------
DROP TABLE IF EXISTS `appointment`;
CREATE TABLE `appointment`  (
  `appointment_id` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'รหัสการนัด',
  `treatment_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสการรักษา',
  `patient_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสผู้ป่วย',
  `appointment_date` date NULL DEFAULT NULL COMMENT 'วันที่นัด',
  `appointment_desc` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รายละเอียดการนัด',
  `nurse_id` int(11) NULL DEFAULT NULL COMMENT 'ผู้นัด',
  `process` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การดำเนินการ\r\nW: กำลังนัด\r\nY: เข้าพบแล้ว\r\nC: ยกเลิก',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพิ่มเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`appointment_id`) USING BTREE,
  UNIQUE INDEX `uk_treatment_id`(`treatment_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลการนัดหมาย' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of appointment
-- ----------------------------
INSERT INTO `appointment` VALUES ('0000000002', 1, 2, '2022-06-05', 'ดูอาการ เข้ม3', 1, 'W', 1, '2022-05-22 17:28:07', 1, '2022-05-22 18:16:02');
INSERT INTO `appointment` VALUES ('0000000003', 4, 5, '2022-08-19', 'นัดฉีดยาคุม', 1, 'W', 1, '2022-05-22 18:25:38', 1, '2022-05-22 18:26:02');
INSERT INTO `appointment` VALUES ('0000000004', 5, 6, '2022-06-22', 'นัดฉีดยาคุม 1 ด', 1, 'W', 1, '2022-05-23 19:01:44', 1, '2022-05-23 19:06:11');
INSERT INTO `appointment` VALUES ('0000000005', 6, 7, '2022-06-22', 'นัีดฉีดยาคุม 1 ด เข้ม 2', 1, 'W', 1, '2022-05-23 19:26:44', 1, '2022-05-23 19:33:11');

-- ----------------------------
-- Table structure for gender
-- ----------------------------
DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender`  (
  `gender_id` int(11) NOT NULL COMMENT 'รหัสเพศ',
  `gender_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ชื่อเพศ',
  PRIMARY KEY (`gender_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลเพศ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gender
-- ----------------------------
INSERT INTO `gender` VALUES (1, 'ชาย');
INSERT INTO `gender` VALUES (2, 'หญิง');

-- ----------------------------
-- Table structure for laboratory
-- ----------------------------
DROP TABLE IF EXISTS `laboratory`;
CREATE TABLE `laboratory`  (
  `laboratory_id` int(11) NOT NULL COMMENT 'รหัสการตรวจแลป',
  `treatment_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสการรักษา',
  `patient_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสผู้ป่วย',
  `laboratory_date` date NULL DEFAULT NULL COMMENT 'วันที่ตรวจ Lab',
  `lab` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Lab',
  `xray` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'X-ray',
  `ultrasound` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Ultrasound',
  `file` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'pdf ผลการ Lab',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพิ่มเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`laboratory_id`) USING BTREE,
  UNIQUE INDEX `uk_treatment_id`(`treatment_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลการตรวจแลป' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for nurse
-- ----------------------------
DROP TABLE IF EXISTS `nurse`;
CREATE TABLE `nurse`  (
  `nurse_id` int(11) NOT NULL COMMENT 'รหัสผู้รักษา',
  `nurse_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ชื่อ',
  `nurse_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'นามสกุล',
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สถานะ',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพิ่มเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`nurse_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลผู้รักษา' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nurse
-- ----------------------------
INSERT INTO `nurse` VALUES (1, 'พว.มาหามะ', 'ซิโซะ', 'Y', 1, '2022-05-21 20:02:17', NULL, NULL);
INSERT INTO `nurse` VALUES (2, 'พว.อนุชิต', 'สิทธิกุล', 'Y', 1, '2022-05-21 20:02:57', NULL, NULL);
INSERT INTO `nurse` VALUES (3, 'พว.อับดุลเลาะมัน', 'ซิโซะ', 'Y', 1, '2022-05-21 20:03:20', NULL, NULL);
INSERT INTO `nurse` VALUES (4, 'ล่าม', 'สา', 'Y', 1, '2022-05-21 20:42:36', NULL, NULL);

-- ----------------------------
-- Table structure for patient
-- ----------------------------
DROP TABLE IF EXISTS `patient`;
CREATE TABLE `patient`  (
  `patient_id` int(11) NOT NULL COMMENT 'รหัสผู้ป่วย',
  `patient_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ชื่อ',
  `patient_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'นามสกุล',
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เบอร์โทรศัพท์',
  `idcard` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เลขที่ประจำตัว',
  `gender_id` int(11) NULL DEFAULT NULL COMMENT '1: ชาย\r\n2: หญิง',
  `bdate` date NULL DEFAULT NULL COMMENT 'วันเกิด',
  `disease` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'โรคประจำตัว',
  `lose` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'แพ้ยา',
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สถานะ',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพิ่มเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`patient_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลรายชื่อผู้ป่วย' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of patient
-- ----------------------------
INSERT INTO `patient` VALUES (3, 'aung thuya', 'htwe', '0945815131', 'mc264131', 1, '1986-09-16', 'ปฏฺิเสธ', 'ปฏิเสธ', NULL, 1, '2022-05-22 21:09:22', NULL, NULL);
INSERT INTO `patient` VALUES (2, 'moe', 'nwe', '0652044037', 'mb976551', 2, '1991-08-25', 'ปฏฺิเสธ', 'ปฏิเสธ', NULL, 1, '2022-05-22 17:24:10', NULL, NULL);
INSERT INTO `patient` VALUES (4, 'la', 'yee', '0804551783', '00000', 2, '1962-06-22', 'gert', 'ปฏิเสธ', NULL, 1, '2022-05-22 20:20:38', NULL, NULL);
INSERT INTO `patient` VALUES (5, 'swe swe', 'oo', '0660299823', 'mc472035', 1, '1983-11-06', 'ปฏฺิเสธ', 'ปฏิเสธ', NULL, 1, '2022-05-22 20:17:43', NULL, NULL);
INSERT INTO `patient` VALUES (6, 'zin moh', 'moh', '0809212163', 'me548057', 2, '1992-03-20', 'ปฏฺิเสธ', 'ปฏิเสธ', NULL, 1, '2022-05-23 18:59:03', NULL, NULL);
INSERT INTO `patient` VALUES (7, 'aye aye', 'soe', '0641893204', 'mc018600', 2, '1990-07-06', 'ปฏฺิเสธ', 'ปฏิเสธ', NULL, 1, '2022-05-23 19:26:09', NULL, NULL);
INSERT INTO `patient` VALUES (8, 'wai phyo', 'maunng', '0660768084', 'me603069', 1, '2000-12-21', 'ปฏฺิเสธ', 'ปฏิเสธ', NULL, 1, '2022-05-23 20:10:21', NULL, NULL);

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `payment_id` int(11) NOT NULL COMMENT 'รหัสการตรวจแลป',
  `treatment_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสการรักษา',
  `patient_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสผู้ป่วย',
  `payment_date` date NULL DEFAULT NULL COMMENT 'วันที่ชำระเงิน',
  `amount` float NULL DEFAULT NULL COMMENT 'ยอดเงิน',
  `file` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ไฟล์สลิป',
  `remark` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'หมายเหตุ',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพิ่มเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`payment_id`) USING BTREE,
  UNIQUE INDEX `uk_treatment_id`(`treatment_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลการชำระเงิน' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for treatment
-- ----------------------------
DROP TABLE IF EXISTS `treatment`;
CREATE TABLE `treatment`  (
  `treatment_id` int(11) NOT NULL COMMENT 'รหัสการรักษา',
  `patient_id` int(11) NULL DEFAULT NULL COMMENT 'รหัสผู้ป่วย',
  `treatment_date` date NULL DEFAULT NULL COMMENT 'วันที่รักษา',
  `symptom` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'อาการเจ็บป่วย',
  `diagnosis` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การวินิจฉัย',
  `treatment` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'การรักษา',
  `nurse_id` int(11) NULL DEFAULT NULL COMMENT 'พยาบาล',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพิ่มเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`treatment_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลประวัติการรักษา' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of treatment
-- ----------------------------
INSERT INTO `treatment` VALUES (1, 2, '2022-05-22', 'ประจำเดือนไม่มา สาวโสด มานัดเข้ม2', 'menopos', 'duoton  1', 1, 1, '2022-05-22 17:26:17', NULL, NULL);
INSERT INTO `treatment` VALUES (2, 3, '2022-05-22', 'ครบชุด จาก รพ ก่อน ไม่หาย', 'com', 'cef 3/dic/lin/ amo/brom/cpm/bru/dexa/ 940  b', 1, 1, '2022-05-22 17:35:04', 1, '2022-05-22 17:44:29');
INSERT INTO `treatment` VALUES (3, 4, '2022-05-22', 'ปวดหลังตลอดเวลา ไม่ช่า  กระเพาะหายแล้ว', 'pain back', 'tra/dic/ preni/dic/nor/losec/gaba/860 b', 1, 1, '2022-05-22 17:57:37', 1, '2022-05-22 18:01:37');
INSERT INTO `treatment` VALUES (4, 5, '2022-05-22', 'มาฉีดยาคุม ห่าง 1 ด ขอแบบ 3 ด', 'คุมกำหนิด', 'depo / upt', 1, 1, '2022-05-22 18:24:07', NULL, NULL);
INSERT INTO `treatment` VALUES (5, 6, '2022-05-23', 'เคย ฉีดที่อื่น 1ปี มาย้ายทีนี ยาคุม1', 'คุมกำเนิด', 'depo', 1, 1, '2022-05-23 19:00:28', 1, '2022-05-23 19:02:35');
INSERT INTO `treatment` VALUES (6, 7, '2022-05-23', 'มาฉีดยาคุม 1 ด', 'คุมกำหนิด', 'depo 1 m', 1, 1, '2022-05-23 19:32:46', NULL, NULL);
INSERT INTO `treatment` VALUES (7, 8, '2022-05-23', 'ครบชุด มา 4วัน', 'com', 'cef 3/dic/lin/ amo/brom/cpm/bru/dexa/ 900  b', 1, 1, '2022-05-23 20:12:00', 1, '2022-05-23 20:37:45');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_id` int(11) NOT NULL COMMENT 'รหัส pk',
  `user_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ชื่อ',
  `user_lname` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'นามสกุล',
  `username` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ชื่อผู้ใช้งาน',
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รหัสผ่าน',
  `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'รูปภาพโปรไฟล์',
  `status` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'สถานะ\r\nY: ใช้งานได้\r\nN: ใช้งานไม่ได้',
  `add_by` int(11) NULL DEFAULT NULL COMMENT 'เพิ่มโดย',
  `add_when` datetime(0) NULL DEFAULT NULL COMMENT 'เพื่อเมื่อ',
  `edit_by` int(11) NULL DEFAULT NULL COMMENT 'แก้ไขโดย',
  `edit_when` datetime(0) NULL DEFAULT NULL COMMENT 'แก้ไขเมื่อ',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ข้อมูลผู้ใช้งานระบบ' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'มาหามะ', 'ซิโซะ', 'siso', '1234', NULL, 'Y', 1, '2022-05-20 21:32:09', 1, '2022-05-21 19:24:50');
INSERT INTO `user` VALUES (2, 'สา', 'เลขา', 'sa', '08014', NULL, 'Y', NULL, NULL, 2, '2022-05-21 20:55:12');

SET FOREIGN_KEY_CHECKS = 1;
