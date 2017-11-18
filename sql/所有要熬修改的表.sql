-- 20171118
ALTER TABLE `ht_user_info` ADD INDEX (`user_id`) ;

ALTER TABLE `ht_user_info` ADD COLUMN `area_id`  int(11) NOT NULL AFTER `city_id`;

