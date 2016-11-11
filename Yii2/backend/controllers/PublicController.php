<?php
namespace backend\controllers;
use yii\web\Controller;
use backend\models\Admin; //定义命名空间，为载入活动记录
class PublicController extends Controller{
  //登录页面
  public function actionLogin(){
    $model = new Admin;//载入活动记录（模型）
    return $this->renderPartial('login',['model'=>$model]);//将model载入为方便创建form表单
  }
}