DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE IF NOT EXISTS `shop_cart`(
  `cart_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '购物车id',
  `product_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品id',
  `product_num` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品数量',
  `price` DECIMAL (10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `user_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id',
  `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  KEY shop_cart_product_id(`product_id`),
  KEY shop_cart_user_id(`user_id`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';