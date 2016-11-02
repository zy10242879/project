<?php
namespace frontend\controllers;

use yii\web\Controller;
class IndexController extends Controller{
  //前台首页控制器
  public function actionIndex(){
    /*$this->layout=false;
    return $this->render('index');*/
    //以上两条方法，同下方法，载入时不加载页头和页脚
    return $this->renderPartial('index');
  }
}