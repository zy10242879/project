DROP TABLE IF EXISTS `shop_product`;  #创建商品表
CREATE TABLE IF NOT EXISTS `shop_product`(
  `product_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品主键id',
  `cate_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类id',
  `title` VARCHAR (200) NOT NULL DEFAULT '' COMMENT '商品标题',
  `description` TEXT COMMENT '商品描述',
  `num` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品库存',
  `price` DECIMAL (10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格', #用DECIMAL更精确,10位含2位小数
  `cover` VARCHAR (200) NOT NULL DEFAULT '' COMMENT '封面图片', #保存为图片上传后图床的地址
  `pics` TEXT COMMENT '所有图片',  #多张图片地址整合为json 存入pics 省略关联性 否则要创建关联表来存储图片地址
  `is_sale` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否促销', #默认为不促销
  `sale_price` DECIMAL (10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `is_hot` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否热卖',
  `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`product_id`),#主键索引
  KEY shop_product_cate_id(`cate_id`) #普通索引,由于cate_id为外键
  #其它索引,如果需要搜索,可以针对搜索字段来进行索引创建
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `shop_product`; #创建商品表
CREATE TABLE IF NOT EXISTS `shop_product`(
    `product_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '商品主键id',
    `cate_id` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类id',
    `title` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品标题',
    `description` TEXT COMMENT '商品描述',
    `num` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品库存',
    `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品价格', #用DECIMAL更精确,10位含2位小数
    `cover` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '封面图片', #保存为图片上传后图床的地址
    `pics` TEXT COMMENT '所有图片',  #多张图片地址整合为json 存入pics 省略关联性 否则要创建关联表来存储图片地址
    `is_sale` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否促销', #默认为不促销
    `is_hot` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否热卖',
    `is_tui` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否推荐',
    `sale_price` DECIMAL(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
    `is_on` ENUM('0','1') NOT NULL DEFAULT '1' COMMENT '是否上架',
    `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    KEY shop_product_cate_id(`cate_id`),#普通索引,由于cate_id为外键
    KEY shop_product_is_on(`is_on`) #普通索引，用于查看是否上架
)ENGINE=InnoDB DEFAULT CHARSET='utf8';