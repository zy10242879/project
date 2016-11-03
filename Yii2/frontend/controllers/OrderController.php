<?php
namespace frontend\controllers;
use yii\web\Controller;
class OrderController extends Controller{
  //public $layout = false;  //关闭页头脚
  //订单中心
  public function actionIndex(){
    $this->layout = 'layout2';
    return $this->render('index');
  }
  //收银台核对
  public function actionCheck(){
    $this->layout = 'layout2';
    return $this->render('check');
  }
}