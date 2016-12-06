<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Category;
class CategoryController extends Controller{
  //分类列表  可以做个分页显示，前面有不再重复
  public function actionList(){
    $this->layout = 'layout_backend';
    $model = new Category();
    $cates = $model->getTreeList();
    return $this->render('cates',['cates'=>$cates,'model'=>$model]);
  }

  //添加分类-----无限级分类方法-----isPost写法与之前类似
  public function actionAdd(){
    $this->layout = 'layout_backend';
    $model = new Category();
    //无限级分类方法步骤   以下1-4步可使用合并为一个方法的$model->getOption() 来直接调用
    //1.---获得所有分类数据---可通过 $cates = Category::find()->asArray()->all(); 来获得数据
    $cates = $model->getData();
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
  //编辑分类
  public function actionMod(){
    $this->layout = 'layout_backend';
    $cate_id = Yii::$app->request->get('cate_id');
    $model = Category::find()->where('cate_id=:cate_id',[':cate_id'=>$cate_id])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->mod($post)){
        Yii::$app->session->setFlash('info','修改成功');
      }
    }
    //getOption()可以通过魔术方法来直接当属性来使用
    $list = $model->option;
    return $this->render('mod',['model'=>$model,'list'=>$list]);
  }
}