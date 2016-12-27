<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
class CommonController extends Controller{
  public function init()
  {
    if(Yii::$app->session['admin']['is_login'] != 1){
      //-------此处需要这样定义路径方法----------
      return $this->redirect(['/public/login']);
    }
  }
}