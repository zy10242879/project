<?php
namespace frontend\controllers;
use Yii;
use frontend\controllers\CommonController; //创建CommonController来初始化数据其继承Controller
class IndexController extends CommonController{
  //前台首页控制器 //此处通过CommonController的init()方法获得了数据载入layout_frontend中及页面中
  public function actionIndex(){
    $this->layout = 'layout_frontend';
//    echo Yii::$app->cache->get('test');
//    die;
    //Yii::$app->session['loginName']='大头言言';
    //var_dump(Yii::$app->session['loginName']);die;
    //redis 测试正常
//    Yii::$app->redis->set('test','111');
//    echo Yii::$app->redis->get('test');
//    exit;
    return $this->render('index');

  }
}