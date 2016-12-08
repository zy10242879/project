DROP TABLE IF EXISTS `shop_category`; #商品分类数据表-无限级分类
CREATE TABLE IF NOT EXISTS `shop_category`(
  `cate_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品分类id',
  `title` VARCHAR (32) NOT NULL DEFAULT '' COMMENT '标题',
  `parent_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '父类id',
  `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY(`cateid`),
  KEY shop_category_parentid(`parentid`) #常规索引-作用为以后要与cateid做关联查询使用
)ENGINE=InnoDB DEFAULT CHARSET=utf8;