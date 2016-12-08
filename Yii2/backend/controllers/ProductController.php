<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Product;
use yii\data\Pagination; //载入分页类
use common\models\Category;
class ProductController extends Controller{
  //显示商品及分页
  public function actionList(){
    $model = Product::find();
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['product'];
    $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
    $products = $model->offset($pager->offset)->limit($pager->limit)->all();
    $this->layout = "layout_backend";
    return $this->render("products", ['pager' => $pager, 'products' => $products]);
  }
  //添加商品
  public function actionAdd(){
    $this->layout = "layout_backend";
    $model = new Product;
    $cate = new Category;
    $list = $cate->getOption();
    unset($list[0]);//去掉　$list[0]＝〉添加顶级分类

    return $this->render("add", ['opts' => $list, 'model' => $model]);
  }
}