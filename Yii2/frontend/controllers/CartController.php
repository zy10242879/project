<?php
namespace frontend\controllers;

class CartController extends CommonController {
  //购物车首页
  public function actionIndex(){
    $this->layout = 'layout_frontend';
    //views/cart/index.php
    return $this->render('index');
  }
}