<?php
namespace frontend\controllers;
//由于是在同一目录下，可以不使用use
//use frontend\controllers\CommonController; //创建CommonController来初始化数据其继承Controller
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

//    $fff = new Aaa();
//    $a = $fff;
//    $b = $a;
//    $c = &$a;
//    $a->val = 'a';
//    var_dump($a->val,$b->val,$c->val);
//    $b->val = 'b';
//    var_dump($a->val,$b->val,$c->val);
//    $c->val = 'c';
//    var_dump($a->val,$b->val,$c->val);
//    $c->val = null;
//    var_dump($a->val,$b->val,$c->val);die;

    return $this->render('index');

  }

}