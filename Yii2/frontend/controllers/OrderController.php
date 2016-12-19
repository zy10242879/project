<?php
namespace frontend\controllers;
use common\models\Product;
use common\models\User;
use common\models\Order;
use common\models\OrderDetail;
use frontend\models\Cart;
use Yii;
class OrderController extends CommonController {
  //public $layout = false;  //关闭页头脚
  //订单中心
  public function actionIndex(){
    $this->layout = 'layout_frontend';
    $this->isLogin();
    $loginName = Yii::$app->session['loginName'];
    $user_id = User::find()->where('user_name=:name',[':name'=>$loginName])->one()->user_id;
    $orders = Order::getProducts($user_id);
    return $this->render('index',['orders'=>$orders]);
  }
  //收银台核对
  public function actionCheck(){
    $this->layout = 'layout_frontend';
    return $this->render('check');
  }
  //添加定单
  public function actionAdd(){
    //1.判断是否登录，使用CommonController中的isLogin()方法；
    $this->isLogin();
    //2.开始事务处理，由于添加的表较多，需要事务处理
    $transaction = Yii::$app->db->beginTransaction();
    try{
      //3.post提交获取数据 写入order表中
      if(Yii::$app->request->isPost){
        $post = Yii::$app->request->post();
        //①实例化order生成orderModel对象
        $order_model = new Order();  //注意查看order表的写法及常量的定义
        //②设置scenario验证场景
        $order_model->scenario = 'add';
        //③获得user_id用来写入order表中
        $user_model = User::find()->where('user_name = :user_name',[':user_name'=>Yii::$app->session['loginName']])->one();
        //④如果$user_model为空，就要抛异常
        if(!$user_model){
          throw new \Exception(1);
        }
        //⑤没问题就获取user_id;
        $user_id = $user_model->user_id;
        //⑥将数据写入$order_model中
        $order_model->user_id = $user_id;
        $order_model->status = Order::CREATE_ORDER; //查看定义的常量
        $order_model->create_time = time();
        //⑦执行save方法存入数据 失败抛异常
        if(!$order_model->save()){
          throw new \Exception(2);
        }
        //4.执行成功获得order_id ------此处注意写法插入成功后的id获得-----------
        //获得order_id后　要向order_detail表中添加数据
        $order_id = $order_model->getPrimaryKey();
        //①将所有post过来的数据中的$post['OrderDetail']定单详细数据　遍历出来　并写入order_detail表中
        foreach ($post['OrderDetail'] as $product) {
          //②生成活动记录对应的对象$model
          $model = new OrderDetail; //查看一下OrderDetail活动记录的创建
          //③将所有要存入detail的字段内容写入data['OrderDetail']中
          $product['order_id'] = $order_id;
          $product['create_time'] = time();
          //此时由于遍历的数据$product　所有$product中又加了以上两个数据
          //④将所有数据存入data['OrderDetail'] 固定写法　对应活动记录OrderDetail
          $data['OrderDetail'] = $product;
          //⑤通过调用$model中的add方法来进行载入数据及添加　并判断如果发生错误就抛出异常
          if(!$model->add($data)){
            throw new \Exception(3);
          }
          //5.将购物车中的数据进行清空
          Cart::deleteAll('product_id = :pid',[':pid'=>$product['product_id']]);
          //6.改变商品中的库存 ----以下方法为　将对某字段进行增减操作
          Product::updateAllCounters(['num'=>-$product['product_num']],'product_id = :pid',[':pid'=>$product['product_id']]);
        }
      }
      //7.没有任何异常进行commit提交
      $transaction->commit();
    }catch (\Exception $e){
      //8.有异常进行回滚 并跳转到购物车页面
      $transaction->rollBack();
      return $this->redirect(['cart/index']);
    }
    //9.没有异常提交后，就跳转到订单确认页 并将订单id传过去
    return $this->redirect(['order/check','order_id'=>$order_id]);
  }
}