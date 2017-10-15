/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-09-05 22:58:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ht_push
-- ----------------------------
DROP TABLE IF EXISTS `ht_push`;
CREATE TABLE `ht_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL COMMENT '标题',
  `company_name` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `start_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `read_count` int(11) DEFAULT '0' COMMENT '阅读数',
  `is_top` tinyint(1) DEFAULT '0' COMMENT '是否置顶  0 否 1是',
  `is_anxious` tinyint(1) DEFAULT '0' COMMENT ' 是否急 0否  1 是',
  `category_id` int(11) DEFAULT NULL COMMENT '资源类型',
  `charge` tinyint(1) DEFAULT '0' COMMENT '收费方式 1 收费 0不收费',
  `business_offer` text COMMENT '商家提供',
  `support` text COMMENT '支持',
  `tel` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `title` (`title`(191))
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='商家互推表';
