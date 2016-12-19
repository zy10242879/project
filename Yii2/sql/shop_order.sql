DROP TABLE IF EXISTS `shop_order`;#定单表
CREATE TABLE IF NOT EXISTS `shop_order`(
    `order_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '定单id',
    `user_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '下单人',
    `address_id` BIGINT UNSIGNED NOT NULL DEFAULT '0'  COMMENT '地址id',
    `amount` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '定单总价',
    `status` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '定单状态',
    `express_id` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '快递方式',
    `express_no` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '快递单号',
    #`trade_no` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '交易单号',
    #`trade_ext` TEXT COMMENT '交易备注',
    `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '自动更新时间',#此字段定义以order表更新当前记录时会自动更新此字段的时间
    KEY shop_order_user_id(`user_id`),
    KEY shop_order_status(`status`),
    KEY shop_order_address_id(`address_id`),
    KEY shop_order_express_id(`express_id`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';