<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Category;
class CategoryController extends Controller{
  //分类列表
  public function actionList(){
    $this->layout = 'layout_backend';
    return $this->render('cates');
  }
  //添加分类-----无限级分类方法-----isPost写法与之前类似
  public function actionAdd(){
    $this->layout = 'layout_backend';
    $model = new Category();
    //无限级分类方法步骤
    //1.---获得所有分类数据---（可通过Category活动记录中的getData()方法，或下面的方法两种来获得）
    $cates = Category::find()->asArray()->all();
    //2.---递归重组$cates--- 按照顶级一路往下分类排序
    $tree = $model->getTree($cates);
    //3.---将排序好的$tree数组进行增加前缀---　通过调用Category活动记录中的getPrefix($tree)方法来实现
    $tree = $model->setPrefix($tree);
    //4.---获得$list分类数据---　通过调用getOptions($tree)来完成
    $list = $model->getOptions($tree);
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->add($post)){
        Yii::$app->session->setFlash('info','添加成功');
        $this->redirect(['category/add']);  //注：此处需要跳转，不然添加的信息将不会显示，需要刷新
        Yii::$app->end();
      }
    }
    return $this->render('add',['list'=>$list,'model'=>$model]);
  }
}