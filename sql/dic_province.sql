/*
Navicat MySQL Data Transfer

Source Server         : 192.168.3.249
Source Server Version : 50550
Source Host           : 192.168.3.249:3306
Source Database       : bms

Target Server Type    : MYSQL
Target Server Version : 50550
File Encoding         : 65001

Date: 2017-10-16 11:39:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for dic_province
-- ----------------------------
DROP TABLE IF EXISTS `dic_province`;
CREATE TABLE `dic_province` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `province` varchar(50) NOT NULL DEFAULT '',
  `is_del` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dic_province
-- ----------------------------
INSERT INTO `dic_province` VALUES ('1', '直辖市', '\0');
INSERT INTO `dic_province` VALUES ('2', '河北省', '');
INSERT INTO `dic_province` VALUES ('3', '江西省', '\0');
INSERT INTO `dic_province` VALUES ('4', '山东省', '\0');
INSERT INTO `dic_province` VALUES ('5', '山西省', '\0');
INSERT INTO `dic_province` VALUES ('6', '内蒙古自治区', '\0');
INSERT INTO `dic_province` VALUES ('7', '河南省', '\0');
INSERT INTO `dic_province` VALUES ('8', '辽宁省', '\0');
INSERT INTO `dic_province` VALUES ('9', '湖北省', '\0');
INSERT INTO `dic_province` VALUES ('10', '吉林省', '\0');
INSERT INTO `dic_province` VALUES ('11', '湖南省', '\0');
INSERT INTO `dic_province` VALUES ('12', '黑龙江', '\0');
INSERT INTO `dic_province` VALUES ('13', '广东省', '\0');
INSERT INTO `dic_province` VALUES ('14', '江苏省', '\0');
INSERT INTO `dic_province` VALUES ('15', '广西壮族自治区', '\0');
INSERT INTO `dic_province` VALUES ('16', '海南省', '\0');
INSERT INTO `dic_province` VALUES ('17', '四川省', '\0');
INSERT INTO `dic_province` VALUES ('18', '浙江省', '\0');
INSERT INTO `dic_province` VALUES ('19', '贵州省', '\0');
INSERT INTO `dic_province` VALUES ('20', '安徽省', '\0');
INSERT INTO `dic_province` VALUES ('21', '云南省', '\0');
INSERT INTO `dic_province` VALUES ('22', '福建省', '\0');
INSERT INTO `dic_province` VALUES ('23', '澳门特别行政区', '\0');
INSERT INTO `dic_province` VALUES ('24', '甘肃省', '\0');
INSERT INTO `dic_province` VALUES ('25', '黑龙江省', '\0');
INSERT INTO `dic_province` VALUES ('26', '宁夏回族自治区', '\0');
INSERT INTO `dic_province` VALUES ('27', '青海省', '\0');
INSERT INTO `dic_province` VALUES ('28', '陕西省', '\0');
INSERT INTO `dic_province` VALUES ('29', '台湾省', '\0');
INSERT INTO `dic_province` VALUES ('30', '西藏自治区', '\0');
INSERT INTO `dic_province` VALUES ('31', '香港特别行政区', '\0');
INSERT INTO `dic_province` VALUES ('32', '新疆维吾尔自治区', '\0');
INSERT INTO `dic_province` VALUES ('33', 'asdfasd', '');
INSERT INTO `dic_province` VALUES ('34', '加利福尼亚州', '');
INSERT INTO `dic_province` VALUES ('35', 'abcdefg', '');
INSERT INTO `dic_province` VALUES ('36', '新泽西州', '');
