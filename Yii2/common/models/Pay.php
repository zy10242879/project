<?php
namespace common\models;
include_once '../../vendor/AliPay/AlipayPay.php';
class Pay{  //注意此处定义的类写法
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
  //(2)通知验证方式
  public static function notify($data){
    //(3)实例化AlipayPay()
    $alipay = new \AlipayPay();
    //(4)调用verifyNotify()方法来验证
    $verify_result = $alipay->verifyNotify();
    //(5)判断验证是否成功
    if($verify_result){
      //所有返回的参数可以查看alipayPay()中的参数返回
      //(6)验证成功　接收订单id 订单状态
      $out_trade_no = $data['extra_common_param'];
      $trade_status = $data['trade_status'];
      //(7)定义状态　默认定义为支付失败
      $status = Order::PAY_FAILED;
      //(8)判断$trade_status返回的支付状态，如果成功，将$status改为成功
      if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS'){
        $status = Order::PAY_SUCCESS;
        //(9)获取订单的信息
        $order_info = Order::find()->where('order_id=:oid',[':oid'=>$out_trade_no])->one();
        //(10)判断如果$order_info为空
        if(!$order_info){
          return false;
        }
        //(11)更新订单状态
        if($order_info->status == Order::CHECK_ORDER){
          Order::updateAll(['status'=>$status],'order_id=:oid',[':oid'=>$order_info->order_id]);
        }else{
          return false;
        }
      }
      return true;
    }else{
      return false;
    }
  }


























}