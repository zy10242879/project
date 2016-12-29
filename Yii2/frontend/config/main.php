<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'urlManager' => [ //Url美化
          'enablePrettyUrl' => true,
          'enableStrictParsing' => false,  //不启用严格解析
          'showScriptName' => false, //隐藏index.php
          //'suffix'=>'.html',//此处如果加了后缀，在qq登录中的inc.php中也要加后缀不能qq登录失败
          'rules'=>[ //设置url地址更换，包括参数效果的更换，可以更换任意url连接地址
            'index.html'=>'index/index',  //此处同样可以为指定方法加后缀
            'product-<product_id:\d+>.html'=>'product/detail',
            'product-cate/<cate_id:\d+>.html'=>'product/index',
          ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
          'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
