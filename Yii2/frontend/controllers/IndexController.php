<?php
namespace frontend\controllers;
use yii\web\Controller;
class IndexController extends Controller{
  public function actionIndex(){
    //echo "Yii2!";
    return $this->render('index');
  }
}