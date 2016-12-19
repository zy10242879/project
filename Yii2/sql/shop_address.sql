DROP TABLE IF EXISTS `shop_address`;#用户收货地址
CREATE TABLE IF NOT EXISTS `shop_address`(
    `address_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '收货地址id',
    `first_name` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '姓',
    `last_name` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '名',
    `company` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '公司名',
    `address` TEXT COMMENT '详细地址',
    `postcode` CHAR(6) NOT NULL DEFAULT '' COMMENT '邮编地址',
    `email` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '邮箱',
    `telephone` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '联系方式',
    `user_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
    `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    KEY shop_address_user_id(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';


#最后还需要生成一张快递表，包括id，快递名，价格等信息，此处不加该表，放在配置文件中params中