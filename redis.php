<?php
    $redis = new redis();//实例化redis类
    $redis -> connect('127.0.0.1',6379);//redis连接，这里127.0.0.1是本地服务器，因为该php文件和所连的redis数据库同在一台主机上，6379是redis的默认端口，可以省略
    $redis -> set('name','lsgogroup');//设置缓存值
    $res = $redis -> get('name');//获取缓存值
    echo $res;
    $reids -> setex('name',3600,'lsgogroup');//设置缓存值得有效时间为1小时
    $redis -> del('name');//手动删除缓存

?>

