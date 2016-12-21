<?php
namespace frontend\controllers;
use Yii;
use common\models\Pay;

//---------由于通知接口回调到notify.php 所以要在web/创建一个notify.php 见web/notify.php---------------
//-----------curl用法-------------
//1.创建支付后结果同步和异步回调方法
class PayController extends CommonController{
  //2.通知接口基本是post提交，yii集成了csrf验证，需要先关闭csrf
  public $enableCsrfValidation = false;
  //3.异步回调  需要通过curl来获取数据
  public function actionNotify(){
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      //(1)调用pay中的notify()方法来验证操作
      if(Pay::notify($post)){ //在Pay中写notify()方法(2)
        echo "success";
        exit;
      }
      echo "fail";
      exit;
    }

  }
  //4.同步回调  加载一个模板，显示支付成功还是支付失败
  public function actionReturn(){
    //接收跳转回来的参数
    $status = Yii::$app->request->get('trade_status');
    //判断支付情况
    if($status == 'TRADE_SUCCESS'){
      $s = 'ok';
    }else{
      $s = 'no';
    }
    //加载到模板中显示
    $this->layout = 'layout_frontend';
    return $this->render('status',['status'=>$s]);
  }
}