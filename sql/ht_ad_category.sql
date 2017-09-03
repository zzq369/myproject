/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-09-03 10:22:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ht_ad_category
-- ----------------------------
DROP TABLE IF EXISTS `ht_ad_category`;
CREATE TABLE `ht_ad_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COMMENT='广告分类';

-- ----------------------------
-- Records of ht_ad_category
-- ----------------------------
INSERT INTO `ht_ad_category` VALUES ('1', '户外', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('2', '电视', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('3', '广播', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('4', '报纸', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('5', '杂志', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('6', '制作', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('7', '策划', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('8', '设备', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('9', '材料', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
INSERT INTO `ht_ad_category` VALUES ('10', '新兴', '2017-09-03 10:20:08', '2017-09-03 10:20:08');
SET FOREIGN_KEY_CHECKS=1;
