<?php
namespace frontend\controllers;

use yii\web\Controller;
class ProductController extends Controller{
  //商品分类页
  public $layout =false; //三种不加载头部和脚部的方法  方法一：
  public function actionCategory(){
    $this->layout = false;                    //  方法二：
    return $this->renderPartial('category');   // 方法三：
  }
  //商品详情页
  public function actionDetail(){
    return $this->render('detail');
  }
}