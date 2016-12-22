<?php
namespace backend\controllers;
use common\models\Order;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
class OrderController extends Controller{
  //后台订单显示　查找所有订单　通过订单id来获取其它需要显示的数据 以及分页
  public function actionList(){
    $this->layout = 'layout_backend';
    $model = Order::find();
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['order'];
    $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
    $data = $model->offset($pager->offset)->limit($pager->limit)->all();
    //由于order表中只存储了某些需要查询数据的id 所以需要通过关联查询找到对应数据，存入data中才能正确返回
    $data = Order::getDetail($data);  //创建order活动记录中getDetail静态方法来处理$data数据
    return $this->render('list',['orders'=>$data,'pager'=>$pager]);
  }
}