-- 20171118
ALTER TABLE `ht_user_info` ADD INDEX (`user_id`) ;

ALTER TABLE `ht_user_info` ADD COLUMN `area_id`  int(11) NOT NULL AFTER `city_id`;


ALTER TABLE `ht_push`
MODIFY COLUMN `business_offer`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '商家提供的支持' AFTER `charge`,
MODIFY COLUMN `support`  text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '希望对方提供的支持' AFTER `business_offer`;

ALTER TABLE `ht_push`
ADD COLUMN `status`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '0正常 ， 2删除' AFTER `is_process`;

ALTER TABLE `ht_activity`
ADD COLUMN `start_time`  datetime NULL COMMENT '开始时间' AFTER `update_time`,
ADD COLUMN `end_time`  datetime NULL COMMENT '结束时间' AFTER `start_time`,
ADD COLUMN `content`  datetime NULL COMMENT '活动规则' AFTER `end_time`,
ADD COLUMN `status`  tinyint NULL DEFAULT 0 COMMENT '0 正常 2 删除' AFTER `content`;






