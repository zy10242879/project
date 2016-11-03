<?php
namespace frontend\controllers;

use yii\web\Controller;
class ProductController extends Controller{
  //商品分类页
  public function actionCategory(){
    return $this->renderPartial('category');
  }
  //商品详情页
  public function actionDetail(){
    return $this->render('detail');
  }
}