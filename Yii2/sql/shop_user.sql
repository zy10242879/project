DROP TABLE IF EXISTS `shop_user`; #用户基本信息
CREATE TABLE IF NOT EXISTS `shop_user`(
  `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_name` VARCHAR(32) NOT NULL DEFAULT '',
  `user_pass` CHAR(32) NOT NULL DEFAULT '',
  `user_email` VARCHAR(100) NOT NULL DEFAULT '',
  `create_time` INT UNSIGNED NOT NULL DEFAULT '0',
  UNIQUE shop_user_user_name_user_pass(`user_name`,`user_pass`),
  UNIQUE shop_user_user_email_user_pass(`user_email`,`user_pass`),
  PRIMARY KEY(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;