<?php
namespace frontend\controllers;

use yii\web\Controller;
class ProductController extends Controller{
  //商品分类页
  //public $layout =false; //三种不加载头部和脚部的方法  方法一：
  public function actionCategory(){
    //$this->layout = false;                    //  方法二：
    //return $this->renderPartial('category');   // 方法三：
    $this->layout = 'layout2';
    return $this->render('category');
  }
  //商品详情页
  public function actionDetail(){
    $this->layout = 'layout2';
    return $this->render('detail');
  }
}