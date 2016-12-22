<?php
return [
    'adminEmail' => 'admin@example.com',
    'pageSize'=>[ //Ⅶ.设置manageController中actionManagers方法中的分页页数
      'manage'=>10,
      'user'=>10,
      'product'=>10,
      'order'=>6,
    ],
    'defaultValues'=>[
      'avatar'=>'statics/img/contact-img.png',
    ],
  //快递信息不仅前台要写在配置表中 后台也需要一份，不然无法使用
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
