<?php
namespace backend\controllers;
class IndexController extends CommonController{
  //后台首页控制器
  public function actionIndex(){
    $this->layout = 'layout_backend';//后台公共页载入  views/layouts/layout_backend.php
    return $this->render('index');
  }
}