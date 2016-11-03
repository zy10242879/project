<?php
namespace frontend\controllers;
use yii\web\Controller;
class OrderController extends Controller{
  //收银台核对
  public function actionCheck(){
    return $this->renderPartial('check');
  }
}