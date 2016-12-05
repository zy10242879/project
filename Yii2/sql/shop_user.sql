DROP TABLE IF EXISTS `shop_user`; #用户基本信息
CREATE TABLE IF NOT EXISTS `shop_user`(
  `user_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_name` VARCHAR(32) NOT NULL DEFAULT '',
  `user_pass` CHAR(32) NOT NULL DEFAULT '',
  `user_email` VARCHAR(100) NOT NULL DEFAULT '',
  #如果需要使用QQ登录，那么在数据库表中需要加入openid字段（去掉前面的#即可） 由于需要查找，所以添加索引
  #`openid` char(32) NOT NULL DEFAULT '0' COMMENT 'QQ登录使用字段',
  `create_time` INT UNSIGNED NOT NULL DEFAULT '0',
  UNIQUE shop_user_user_name_user_pass(`user_name`,`user_pass`),
  UNIQUE shop_user_user_email_user_pass(`user_email`,`user_pass`),
  INDEX shop_openid(`openid`), #此为普通索引　由于此字段不一定是用QQ登录，所以会出现默认0，不能用唯一索引
  PRIMARY KEY(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

#普通索引速度比唯一索引速度会慢许多  普通索引可取前缀多少长度进行查找

