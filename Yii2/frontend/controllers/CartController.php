<?php
namespace frontend\controllers;
use yii\web\Controller;
class CartController extends Controller{
  //购物车首页
  public function actionIndex(){
    //views/cart/index.php
    return $this->renderPartial('index');
  }
}