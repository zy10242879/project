<?php
//连接
$mem = new Memcache;
$mem->connect("127.0.01",  11211);
 
//保存数据
$mem->set('key1', 'This is first value', 0, 60);
$val = $mem->get('key1');
echo "Get key1 value: " . $val ."<br />";

