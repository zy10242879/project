DROP TABLE IF EXISTS `shop_sphinx_id`;#用于sphinx存储当前索引最大值的表
CREATE TABLE IF NOT EXISTS `shop_sphinx_id`(
  `sphinx_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' PRIMARY KEY COMMENT '已经建好索引的最后一件商品的ID'
)ENGINE=InnoDB DEFAULT CHARSET='utf8' COMMENT 'sphinx';
INSERT INTO shop_sphinx_id VALUES(0);