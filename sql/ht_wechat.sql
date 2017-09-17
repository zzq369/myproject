/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-09-17 11:55:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ht_wechat
-- ----------------------------
DROP TABLE IF EXISTS `ht_wechat`;
CREATE TABLE `ht_wechat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wechat_name` varchar(100) DEFAULT NULL,
  `wechat_account` varchar(100) DEFAULT NULL,
  `wechat_category` int(11) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `like` int(11) DEFAULT NULL COMMENT '点赞',
  `fans` int(11) DEFAULT NULL COMMENT '关注度',
  `qr_code` varchar(255) DEFAULT NULL COMMENT '二维码',
  `describe` text COMMENT '描述',
  `is_v` tinyint(1) DEFAULT NULL COMMENT '是否认证  1是 0否',
  `qq` varchar(20) DEFAULT NULL COMMENT '客服qq',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号 ';
