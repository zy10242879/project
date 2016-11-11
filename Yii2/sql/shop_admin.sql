DROP TABLE IF EXISTS `shop_admin`; #查找数据表是否存在 注意表名用``标注
CREATE TABLE IF NOT EXISTS `shop_admin`(  #创建数据表及字段
  `admin_id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `admin_user` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `admin_pass` CHAR(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `admin_email` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '管理员电子邮箱',
  `login_time` INT UNSIGNED NOT NULL DEFAUlT '0' COMMENT '登录时间',
  `login_ip` BIGINT NOT NULL DEFAULT '0' COMMENT '登录IP',
  `create_time` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY(`admin_id`), #主键索引
  #登录时一定要查询用户名和密码　所以这里做联合索引　针对admin_user创建　联合唯一索引　*UNIQUE*　下同
  UNIQUE shop_admin_admin_user_admin_pass(`admin_user`,`admin_pass`),
  UNIQUE shop_admin_admin_user_admin_email(`admin_user`,`admin_email`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8; #ENGINE=InnoDB 设置数据库引擎　DEFAULT CHARSET=utf8 设置默认字符集

#初始化时插入一条管理员记录，用来登录
INSERT INTO `shop_admin`(admin_user,admin_pass,admin_email,create_time)
    VALUE ('admin',md5('admin'),'10242879@163.com',UNIX_TIMESTAMP());