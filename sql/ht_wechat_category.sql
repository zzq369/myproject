/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-09-17 11:55:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ht_wechat_category
-- ----------------------------
DROP TABLE IF EXISTS `ht_wechat_category`;
CREATE TABLE `ht_wechat_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号分类';

-- ----------------------------
-- Records of ht_wechat_category
-- ----------------------------
INSERT INTO `ht_wechat_category` VALUES ('1', '新闻', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('2', '名人', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('3', '美食', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('4', '影娱', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('5', '购物', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('6', '家居', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('7', '天气', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('8', '旅游', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('9', '宠物', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('10', '社交', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('11', '体育', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('12', '高校', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('13', '互联网', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('14', '医疗', '2017-09-17 09:30:44', '1', '0');
INSERT INTO `ht_wechat_category` VALUES ('15', '育儿', '2017-09-17 09:30:44', '1', '0');
