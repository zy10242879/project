<?php
namespace common\models;
use yii\db\ActiveRecord;
class Order extends ActiveRecord{
  //定义定单状态的常量
  const CREATE_ORDER = 0;
  const CHECK_ORDER = 100;
  const PAY_FAILED = 201;
  const PAY_SUCCESS = 202;
  const SENDED = 220;
  const RECEIVED = 260;
  public static $status = [
    self::CREATE_ORDER => '订单初始化',
    self::CHECK_ORDER => '待支付',
    self::PAY_FAILED => '支付失败',
    self::PAY_SUCCESS => '等待发货',
    self::SENDED => '已发货',
    self::RECEIVED => '订单完成',
  ];
  //由于getProducts()没有这些参数，所以要添加
  public $products;
  public $zhstatus;
  //上面及下面的属性由于getDetail()中没有，所以需要添加
  public $user_name;
  public $address;

  public static function tableName()
  {
    return '{{%order}}';
  }
  public function attributeLabels()
  {
    return [
      'express_no'=>'快递单号：'
    ];
  }

  public function rules()
  {
    return [
      [['user_id','status'],'required','on'=>['add']],
      ['create_time','safe','on'=>['add']],
      [['address_id', 'express_id', 'amount', 'status'], 'required','message'=>'不能为空', 'on' => ['update']],
      ['express_no','required','on'=>['send']],
    ];
  }
  //--------可以通过封装关联查询来尝试减少代码---------(可能效率会降低)
  //遍历订单表index中的orders数据  -----对4个数据表进行操作
  public static function getProducts($user_id){
    //通过user_id找到所有状态不是初始化的订单的订单表数据   ---order---表
    $orders = self::find()->where('status >= 0 and user_id = :uid', [':uid' => $user_id])->orderBy('create_time desc')->all();
    //通过遍历以上订单表数据，得到所有订单的订单id，通过订单id遍历详细表，获得订单详细表中的商品
    foreach($orders as $order) {    //----order_detail----表
      $details = OrderDetail::find()->where('order_id = :oid', [':oid' => $order->order_id])->all();
      $products = [];
      //通过当前商品id来遍历出所有商品信息，存入orders中
      foreach($details as $detail) {  //----product----表
        $product = Product::find()->where('product_id = :pid', [':pid' => $detail->product_id])->one();
        if (empty($product)) {
          continue;
        }
        $product->num = $detail->product_num;
        $product->price = $detail->price;   //----category----表
        $product->cate = Category::find()->where('cate_id = :cid', [':cid' => $product['cate_id']])->one()->title;
        $products[] = $product;
      }
      $order->zhstatus = self::$status[$order->status];
      $order->products = $products;
    }
    return $orders;
  }
  //此方法返回的属性中由于products zhstatus(中文订单状态) username address这四个属性是没有的，所以要在上面创建
  public static function getDetail($orders){
    //遍历所有订单 获取数据
    foreach ($orders as $order) {
      //由于获取当前order_id对应的数据是相同的，所以加入下面的getData($order)静态方法直接调用，省略注释内容
      $order = self::getData($order);
//      //先通过订单id获得所有详细订单数据
//      $details = OrderDetail::find()->where('order_id=:oid',[':oid'=>$order->order_id])->all();
//      $products = [];
//      //再次遍历详细订单记录，获得对应的商品信息 通过product_id 获得title及数量
//      foreach ($details as  $detail){
//        //先获得商品对象
//        $product = Product::find()->where('product_id=:pid',[':pid'=>$detail->product_id])->one();
//        $product->num = $detail->product_num;
//        $products[] = $product;//将数据存入预先准备的数组中
//      }
//      //将获得的所有商品信息加入到order中
//      $order->products =$products;
//      $order->user_name = User::find()->where('user_id=:uid',[':uid'=>$order->user_id])->one()->user_name;
//      $order->address = Address::find()->where('address_id=:aid',[':aid'=>$order->address_id])->one();
//      if(empty($order->address)){
//        $order->address = '';
//      }else{
//        $order->address = $order->address->address;
//      }
//      $order->zhstatus = self::$status[$order->status];//←←←看一下此处的调用方法，是正确的
    }
    return $orders;
  }

  public static function getData($order){
    //先通过订单id获得所有详细订单数据
    $details = OrderDetail::find()->where('order_id=:oid',[':oid'=>$order->order_id])->all();
    $products = [];
    //再次遍历详细订单记录，获得对应的商品信息 通过product_id 获得title及数量
    foreach ($details as  $detail){
      //先获得商品对象
      $product = Product::find()->where('product_id=:pid',[':pid'=>$detail->product_id])->one();
      $product->num = $detail->product_num;
      $products[] = $product;//将数据存入预先准备的数组中
    }
    //将获得的所有商品信息加入到order中
    $order->products =$products;
    $order->user_name = User::find()->where('user_id=:uid',[':uid'=>$order->user_id])->one()->user_name;
    $order->address = Address::find()->where('address_id=:aid',[':aid'=>$order->address_id])->one();
    if(empty($order->address)){
      $order->address = '';
    }else{
      $order->address = $order->address->address;
    }
    $order->zhstatus = self::$status[$order->status];//←←←看一下此处的调用方法，是正确的
    return $order;
  }

}