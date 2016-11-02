<?php
namespace frontend\controllers;

use yii\web\Controller;
class ProductController extends Controller{
  public function actionCategory(){
    return $this->renderPartial('category');
  }
}