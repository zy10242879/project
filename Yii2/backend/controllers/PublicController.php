<?php
namespace backend\controllers;
use yii\web\Controller;
class PublicController extends Controller{
  public function actionLogin(){
    return $this->renderPartial('login');
  }
}