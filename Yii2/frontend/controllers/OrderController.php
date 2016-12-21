<?php
namespace frontend\controllers;
use common\models\Address;
use common\models\Product;
use common\models\User;
use common\models\Order;
use common\models\OrderDetail;
use frontend\models\Cart;
use common\models\Pay;
use Yii;
class OrderController extends CommonController {
  //public $layout = false;  //关闭页头脚
  //订单中心
  public function actionIndex(){
    $this->layout = 'layout_frontend';
    $this->isLogin();
    $loginName = Yii::$app->session['loginName'];
    $user_id = User::find()->where('user_name=:name',[':name'=>$loginName])->one()->user_id;
    $orders = Order::getProducts($user_id); //------此方法中有两层遍历--------
    return $this->render('index',['orders'=>$orders]);
  }
  //收银台核对商品、地址及支付
  public function actionCheck(){
    $this->isLogin();
    //1.查看当前传过来的order_id的订单状态，并判断如果不处于订单初始化或待支付的情况下，跳转到订单中心
    $order_id = Yii::$app->request->get('order_id');
    $status = Order::find()->where('order_id=:oid',[':oid'=>$order_id])->one()->status;
    if($status != Order::CREATE_ORDER && $status != Order::CHECK_ORDER){
      return $this->redirect(['order/index']);
    }
    //2.查询该用户下的地址信息、订单详情、所有快递信息
    //①查询地址信息 获得user_id 根据user_id查询地址信息
    $user_id = User::find()->where('user_name = :name',[':name'=>Yii::$app->session['loginName']])->one()->user_id;
    $addresses = Address::find()->where('user_id = :uid',[':uid'=>$user_id])->asArray()->all();
    //②通过order_id获得details详细信息，遍历details,通过product_id获取商品的详细信息
    $details = OrderDetail::find()->where('order_id = :oid',[':oid'=>$order_id])->asArray()->all();
    $data = [];
    foreach ($details as $detail) {
      $model = Product::find()->where('product_id=:pid',[':pid'=>$detail['product_id']])->one();
      $detail['cover'] = $model->cover;
      $detail['title'] = $model->title;
      $data[] = $detail;
    }
    //3.获得快递信息
    $express = Yii::$app->params['express'];
    $expressPrice = Yii::$app->params['expressPrice'];
    $this->layout = 'layout_frontend';
    return $this->render('check',['express'=>$express,'expressPrice'=>$expressPrice,'products'=>$data,'addresses'=>$addresses]);
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
  //确认定单
  public function actionConfirm()
  {
    //addressid, expressid, status, amount(orderid,userid)
    try {
      $this->isLogin();
      if (!Yii::$app->request->isPost) {
        throw new \Exception();
      }
      $post = Yii::$app->request->post();
      $user_model = User::find()->where('user_name = :name', [':name' => Yii::$app->session['loginName']])->one();
      if (empty($user_model)) {
        throw new \Exception();
      }
      $user_id = $user_model->user_id;
      $model = Order::find()->where('order_id = :oid and user_id = :uid', [':oid' => $post['order_id'], ':uid' => $user_id])->one();
      if (empty($model)) {
        throw new \Exception();
      }
      $model->scenario = "update";
      $post['status'] = Order::CHECK_ORDER;
      $details = OrderDetail::find()->where('order_id = :oid', [':oid' => $post['order_id']])->all();
      $amount = 0;
      foreach($details as $detail) {
        $amount += $detail->product_num*$detail->price;
      }
      if ($amount <= 0) {
        throw new \Exception();
      }
      $express = Yii::$app->params['expressPrice'][$post['express_id']];
      if ($express < 0) {
        throw new \Exception();
      }
      $amount += $express;
      $post['amount'] = $amount;
      $data['Order'] = $post;
      if (empty($post['address_id'])) {
        return $this->redirect(['order/pay', 'order_id' => $post['order_id'], 'pay_method' => $post['pay_method']]);
      }
      if (!$model->load($data) || !$model->save()) {
        throw new \Exception();
      }else{
        return $this->redirect(['order/pay', 'order_id' => $post['order_id'], 'pay_method' => $post['pay_method']]);
      }
    }catch(\Exception $e) {
      return $this->redirect(['index/index']);
    }
  }

  //支付方式选择 此处为支付宝的即时到账
  public function actionPay(){
    try{
      $this->isLogin();
      //获取数据
      $order_id = Yii::$app->request->get('order_id');
      $pay_method = Yii::$app->request->get('pay_method');
      //验证传过来的参数
      if(empty($order_id) || empty($pay_method)){
        throw new \Exception();
      }
      //选择支付方式，此处为支付宝即时到账  新建pay.php活动记录，写入支付方法
      if($pay_method = 'alipay'){
        return Pay::alipay($order_id);
      }
//      if($pay_method = 'tenxpay'){
//        return Pay::tenxpay($order_id);
//      }
    }catch (\Exception $e){
      return $this->redirect(['order/index']);
    }
  }
}