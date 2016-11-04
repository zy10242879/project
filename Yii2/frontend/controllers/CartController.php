<?php
namespace frontend\controllers;
use yii\web\Controller;
class CartController extends Controller{
  //购物车首页
  public function actionIndex(){
    $this->layout = 'layout_frontend';
    //views/cart/index.php
    return $this->render('index');
  }
}