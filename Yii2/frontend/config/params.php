<?php
return [
    'adminEmail' => 'admin@example.com',
  'pageSize'=>[
    'frontProduct'=>9,
  ],
  //快递信息写在此配置表中 此处不用数据库来存储了
  'express' => [
    1 => '包邮',
    2 => '顺丰快递',
    3 => '中通快递',
    4 => '申通快递',
    5 => '圆通快递',
  ],
  'expressPrice' => [
    1 => 0,
    2 => 20,
    3 => 15,
    4 => 12,
    5 => 10,
  ],
];
