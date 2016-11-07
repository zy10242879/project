<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Test;
use frontend\models\Customer;
use frontend\models\Order;
class TestController extends Controller
{
  public function actionIndex()
  {
//  $data['name'] = 'tom';
//  $data['age'] = 20;
//  $data['sex'] ='男<script>alert("哈哈")</script>';
//  $data['info'] = array('name'=>'mary','age'=>18,'sex'=>'女');
//    return $this->renderPartial('index',$data);
    //print_r(Test::find()->where(['id'=> '1 or 1=1'])->asArray()->all());
//    print_r(Test::find()->select('id as b')->addSelect('title')->where(['id'=>[1,2]])->groupBy('title')->orderBy('id ASC')->limit(3)->offset(0)->asArray()->all());
    //Test::find()->where(['id'=>1])->one()->delete();
    //Test::deleteAll(['>','id',2]);
    //Test::deleteAll();
    //Yii::$app->db->createCommand()->insert('{{%test}}',['id'=>3,'title'=>'title3'])->execute();
//    $test = Test::find()->where(['id'=>3])->one();
//    $test->title='title4';
//    $test->save();
  //$result = Test::updateAll(['title'=>'title3'],['id'=>3]);
    //关联查询实例分析
    //根据顾客查询他的订单信息
    $customer = Customer::find()->where(['name'=>'zhangsan'])->one();
    $orders = $customer->hasMany(Order::className(),['customer_id'=>'id'])->asArray()->all();
    print_r($orders);
  }
}