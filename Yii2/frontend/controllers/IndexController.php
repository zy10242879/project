<?php
namespace frontend\controllers;
use frontend\controllers\CommonController; //创建CommonController来初始化数据其继承Controller
class IndexController extends CommonController{
  //前台首页控制器 //此处通过CommonController的init()方法获得了数据载入layout_frontend中及页面中
  public function actionIndex(){
    $this->layout = 'layout_frontend';
    return $this->render('index');

  }
}