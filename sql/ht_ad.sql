/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-09-03 10:22:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ht_ad
-- ----------------------------
DROP TABLE IF EXISTS `ht_ad`;
CREATE TABLE `ht_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `address` varchar(100) DEFAULT NULL COMMENT '地址',
  `company_name` varchar(100) DEFAULT NULL COMMENT '公司名',
  `type` varchar(100) DEFAULT NULL COMMENT '类型',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话',
  `content` longtext COMMENT '内容',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='广告表';
SET FOREIGN_KEY_CHECKS=1;
