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

  public static function tableName()
  {
    return '{{%order}}';
  }
  public function attributeLabels()
  {
    return [

    ];
  }

  public function rules()
  {
    return [
      [['user_id','status'],'required','on'=>['add']],
      ['create_time','safe','on'=>['add']],
    ];
  }
  //遍历订单表index中的orders数据  -----对4个数据表进行操作
  public static function getProducts($user_id){
    //通过user_id找到所有状态不是初始化的订单的订单表数据   ---order---表
    $orders = self::find()->where('status > 0 and user_id = :uid', [':uid' => $user_id])->orderBy('create_time desc')->all();
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
      //$order->zhstatus = self::$status[$order->status];
      $order->products = $products;
    }
    return $orders;
  }

}