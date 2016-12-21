<?php
namespace common\models;
include_once '../../vendor/AliPay/AlipayPay.php';
class pay{  //注意此处定义的类写法
  public static function alipay($order_id){
    //准备数据
    //先查找出总价
    $amount = Order::find()->where('order_id=:oid',[':oid'=>$order_id])->one()->amount; //订单总价
    if(!empty($amount)){
      $gift_name = "妞妈烘焙"; //名称
      $data = OrderDetail::find()->where('order_id=:oid',[':oid'=>$order_id])->all();
      $body = '';
      foreach ($data as $pro){
        $body .= Product::find()->where('product_id=:pid',[':pid'=>$pro['product_id']])->one()->title."－";
      }
      $body .= "等商品";  //商品名
      $showUrl = "http://www.niuniuma.com"; //回调地址
      //将准备好的数据传到requestPay()方法中去
      $alipay = new \AlipayPay(); //实例化支付对象
      $html = $alipay->requestPay($order_id,$gift_name,$amount,$body,$showUrl);
      echo $html;
    }
  }
}