<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Test;
class IndexController extends Controller{
  public function actionIndex(){
    //echo "Yii2!";
    //views/index/index.php(新建index目录，以下渲染到index.php
    $model = new Test;
    $data = $model->find()->one();
    return $this->render('index',array('row'=>$data));
  }
}