/*
 Navicat Premium Data Transfer

 Source Server         : starbright
 Source Server Type    : MySQL
 Source Server Version : 100428 (10.4.28-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : crm_gfi

 Target Server Type    : MySQL
 Target Server Version : 100428 (10.4.28-MariaDB)
 File Encoding         : 65001

 Date: 03/09/2024 16:44:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for medicines
-- ----------------------------
DROP TABLE IF EXISTS `medicines`;
CREATE TABLE `medicines`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `medicine_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `manufacturer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dosage` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `frequency` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `duration` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `storage_temperature` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `storage_instructions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  `stock` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of medicines
-- ----------------------------
INSERT INTO `medicines` VALUES (1, 'asd', 'asd', 'Capsule', '2024-08-13', 'asd', '123', '123', '123', 'asd', '123', '2024-08-12 11:07:57', '99', 'Received');
INSERT INTO `medicines` VALUES (2, 'Bioflu', 'Bear Brand', 'Tablet', '2024-08-29', 'shinko', '123', '123', '21', '35%', 'normal', '2024-08-29 14:01:12', '497', NULL);

-- ----------------------------
-- Table structure for prescribed_medicine_table
-- ----------------------------
DROP TABLE IF EXISTS `prescribed_medicine_table`;
CREATE TABLE `prescribed_medicine_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `record_id` int NULL DEFAULT NULL,
  `medicine_id` int NULL DEFAULT NULL,
  `quantity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of prescribed_medicine_table
-- ----------------------------
INSERT INTO `prescribed_medicine_table` VALUES (1, 1, 1, '100', '1');
INSERT INTO `prescribed_medicine_table` VALUES (2, 1, 2, '500', '1');
INSERT INTO `prescribed_medicine_table` VALUES (3, 1, 1, '1', '1');
INSERT INTO `prescribed_medicine_table` VALUES (4, 12, 2, '3', '1');

-- ----------------------------
-- Table structure for registrations
-- ----------------------------
DROP TABLE IF EXISTS `registrations`;
CREATE TABLE `registrations`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `student_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_grade` int NOT NULL,
  `organization_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `organization_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `personal_statement` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of registrations
-- ----------------------------

-- ----------------------------
-- Table structure for reorder_medicine
-- ----------------------------
DROP TABLE IF EXISTS `reorder_medicine`;
CREATE TABLE `reorder_medicine`  (
  `reorder_id` int NOT NULL AUTO_INCREMENT,
  `medicine_id` int NOT NULL,
  `current_stock` int NOT NULL,
  `reorder_quantity` int NOT NULL,
  `reorder_status` enum('Pending','Ordered','Received') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Pending',
  `reorder_date` date NOT NULL,
  `reorder_process_date` date NOT NULL,
  `additional_notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`reorder_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reorder_medicine
-- ----------------------------
INSERT INTO `reorder_medicine` VALUES (2, 1, 1, 500, 'Received', '2024-08-29', '2024-08-30', '123');

-- ----------------------------
-- Table structure for staff_table
-- ----------------------------
DROP TABLE IF EXISTS `staff_table`;
CREATE TABLE `staff_table`  (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_hired` date NOT NULL,
  PRIMARY KEY (`staff_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of staff_table
-- ----------------------------
INSERT INTO `staff_table` VALUES (1, 'admin', 'admin', 'asd', 'asd', '2024-08-29', 'Male', '', '', '', '', '', '', 'Administrator', '', '0000-00-00');

-- ----------------------------
-- Table structure for student_clinic_record_table
-- ----------------------------
DROP TABLE IF EXISTS `student_clinic_record_table`;
CREATE TABLE `student_clinic_record_table`  (
  `record_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NULL DEFAULT NULL,
  `illness` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `symptoms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date_diagnosed` date NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`record_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student_clinic_record_table
-- ----------------------------
INSERT INTO `student_clinic_record_table` VALUES (1, 1231, 'asd', 'asd', '2024-08-31', 'asdasd');
INSERT INTO `student_clinic_record_table` VALUES (12, 1231, 'asd', 'asd', '2024-09-04', 'asd');

-- ----------------------------
-- Table structure for students_table
-- ----------------------------
DROP TABLE IF EXISTS `students_table`;
CREATE TABLE `students_table`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `year` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `section` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `course` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of students_table
-- ----------------------------
INSERT INTO `students_table` VALUES (2, '1231', 'sample', 'sample', 'sample', 'sample', '2024-08-30', 'Male', 'sample@gmail.com', '09124804022', 'yusaville', 'sinawal', 'general santos city', 'south cotabato', '2024', 'zara', 'Information Technology', '2024-09-02');
INSERT INTO `students_table` VALUES (3, 'asd', 'asd', '2Sgk3S5r_oR1', 'asd', 'asd', '2024-09-03', 'Female', 'asd@gmail.com', '1231231', 'asdasd', 'asd', 'asdas', 'dasd', '123', 'asd', 'Information Technology', '0000-00-00');

-- ----------------------------
-- Table structure for teachers_table
-- ----------------------------
DROP TABLE IF EXISTS `teachers_table`;
CREATE TABLE `teachers_table`  (
  `teacher_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `street` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `municipality` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_hired` date NOT NULL,
  PRIMARY KEY (`teacher_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of teachers_table
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;