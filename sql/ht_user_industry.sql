/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ht

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-17 20:56:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ht_user_industry`
-- ----------------------------
DROP TABLE IF EXISTS `ht_user_industry`;
CREATE TABLE `ht_user_industry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1正常  0 删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COMMENT='商家行业表';

-- ----------------------------
-- Records of ht_user_industry
-- ----------------------------
INSERT INTO `ht_user_industry` VALUES ('1', 'IT/互联网', '2017-10-15 22:36:52', '2017-10-15 22:36:55', '1');
INSERT INTO `ht_user_industry` VALUES ('2', '游戏/动漫', '2017-10-15 22:37:06', '2017-10-15 22:37:10', '1');
INSERT INTO `ht_user_industry` VALUES ('3', '亲子/母婴', '2017-10-15 22:37:36', '2017-10-15 22:37:38', '1');
INSERT INTO `ht_user_industry` VALUES ('4', '教育/培训', '2017-10-15 22:37:47', '2017-10-15 22:37:50', '1');
INSERT INTO `ht_user_industry` VALUES ('5', '银行/金融/保险', '2017-10-15 22:37:56', '2017-10-15 22:37:59', '1');
INSERT INTO `ht_user_industry` VALUES ('6', '旅游', '2017-10-17 20:54:40', '2017-10-17 20:54:42', '1');
INSERT INTO `ht_user_industry` VALUES ('7', '汽车', '2017-10-17 20:54:44', '2017-10-17 20:54:46', '1');
INSERT INTO `ht_user_industry` VALUES ('8', '餐饮/酒店', '2017-10-17 20:54:49', '2017-10-17 20:54:52', '1');
INSERT INTO `ht_user_industry` VALUES ('9', '婚庆', '2017-10-17 20:54:55', '2017-10-17 20:54:58', '1');
INSERT INTO `ht_user_industry` VALUES ('10', '房产/家居', '2017-10-17 20:55:01', '2017-10-17 20:55:03', '1');
INSERT INTO `ht_user_industry` VALUES ('11', '家政', '2017-10-17 20:55:07', '2017-10-17 20:55:10', '1');
INSERT INTO `ht_user_industry` VALUES ('12', '娱乐/休闲', '2017-10-17 20:55:12', '2017-10-17 20:55:15', '1');
INSERT INTO `ht_user_industry` VALUES ('13', '媒体/广告/公关/展览', '2017-10-17 20:55:18', '2017-10-17 20:55:21', '1');
INSERT INTO `ht_user_industry` VALUES ('14', '医药/医疗/健康/保健', '2017-10-17 20:55:23', '2017-10-17 20:55:25', '1');
INSERT INTO `ht_user_industry` VALUES ('15', '化妆品/美容美体', '2017-10-17 20:55:29', '2017-10-17 20:55:37', '1');
INSERT INTO `ht_user_industry` VALUES ('16', '通讯', '2017-10-17 20:55:31', '2017-10-17 20:55:39', '1');
INSERT INTO `ht_user_industry` VALUES ('17', '能源/制造', '2017-10-17 20:55:35', '2017-10-17 20:55:41', '1');
INSERT INTO `ht_user_industry` VALUES ('18', '快消/食品饮料', '2017-10-17 20:55:46', '2017-10-17 20:55:44', '1');
INSERT INTO `ht_user_industry` VALUES ('19', '办公用品/生活用品', '2017-10-17 20:55:49', '2017-10-17 20:55:51', '1');
INSERT INTO `ht_user_industry` VALUES ('20', '智能产业', '2017-10-17 20:55:53', '2017-10-17 20:55:59', '1');
INSERT INTO `ht_user_industry` VALUES ('21', '企业服务', '2017-10-17 20:56:02', '2017-10-17 20:56:04', '1');
INSERT INTO `ht_user_industry` VALUES ('22', '服装/服饰', '2017-10-17 20:56:06', '2017-10-17 20:56:08', '1');
INSERT INTO `ht_user_industry` VALUES ('23', '家电/数码/手机', '2017-10-17 20:56:11', '2017-10-17 20:56:13', '1');
INSERT INTO `ht_user_industry` VALUES ('24', '其他', '2017-10-17 20:56:15', '2017-10-17 20:56:17', '1');
