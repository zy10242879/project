DROP TABLE IF EXISTS `shop_order_detail`;#定单详情表
CREATE TABLE IF NOT EXISTS `shop_order_detail`(
    `detail_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '定单详情id',
    `product_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品id',
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
    `product_num` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '数量',
    `order_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '定单id',
    `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    KEY shop_order_detail_product_id(`product_id`),
    KEY shop_order_detail_order_id(`order_id`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';