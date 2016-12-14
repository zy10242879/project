<?php
namespace frontend\controllers;
use Yii;
use common\models\Product;
use yii\data\Pagination;
class ProductController extends CommonController{
  //商品分类页
  public function actionIndex(){
    $this->layout = "layout_frontend_nav";
    $cid = Yii::$app->request->get("cate_id");
    $where = "cate_id = :cid and is_on = '1'";
    $params = [':cid' => $cid];
    $model = Product::find()->where($where, $params);
    $all = $model->asArray()->all();

    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['frontProduct'];
    $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
    $all = $model->offset($pager->offset)->limit($pager->limit)->asArray()->all();

    $tui = $model->where($where . ' and is_tui = \'1\'', $params)->orderBy('create_time desc')->limit(5)->asArray()->all();
    $hot = $model->where($where . ' and is_hot = \'1\'', $params)->orderBy('create_time desc')->limit(5)->asArray()->all();
    $sale = $model->where($where . ' and is_sale = \'1\'', $params)->orderBy('create_time desc')->limit(5)->asArray()->all();
    return $this->render("index", ['sale' => $sale, 'tui' => $tui, 'hot' => $hot, 'all' => $all, 'pager' => $pager, 'count' => $count]);
  }
  //商品详情页
  public function actionDetail(){
    $this->layout = 'layout_frontend_nav';
    $product_id = Yii::$app->request->get("product_id");
    $product = Product::find()->where('product_id = :id', [':id' => $product_id])->asArray()->one();
    $data['all'] = Product::find()->where('is_on = "1"')->orderBy('create_time desc')->limit(7)->all();
    return $this->render("detail", ['product' => $product, 'data' => $data]);
  }

}