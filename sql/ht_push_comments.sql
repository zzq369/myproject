/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-17 21:56:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ht_push_comments`
-- ----------------------------
DROP TABLE IF EXISTS `ht_push_comments`;
CREATE TABLE `ht_push_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `push_id` int(11) NOT NULL COMMENT '互推id',
  `comment_user_id` int(11) NOT NULL COMMENT '留言者ID',
  `content` text NOT NULL COMMENT '留言内容',
  `create_time` datetime NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级留言',
  PRIMARY KEY (`id`),
  KEY `push_id` (`push_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='互推留言表';

-- ----------------------------
-- Records of ht_push_comments
-- ----------------------------
