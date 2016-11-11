<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Customer;
use frontend\models\Order;
//use vendor\test\Test;
use frontend\models\Test;
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
    //关联查询实例分析（关联两个表的查询）
    //根据顾客查询他的订单信息  一对多关系  一个客户对应多个订单
    //以下一行代码不指获得的是name==zhangsan的一条记录，而且还获得customer实例化的对象$customer
    $customer = Customer::find()->where(['name'=>'zhangsan'])->one();
    //将以下关联查询语句封装到customer活动记录中（活动记录是指customer这个模型类）
    //$orders = $customer->hasMany(Order::className(),['customer_id'=>'id'])->asArray()->all();
    $orders = $customer->orders; //此处注意使用魔术方法 __get 在$customer对象获取不存在属性的方式来获取getOrders
    print_r($orders);             //orders要特别注意全小写，不然会报错
    //根据订单查询客户的信息 一对一关系  方法同上
    $order = Order::find()->where(['id'=>1])->one();
    $customer = $order->customer;  //此处通过魔术方法__get 在$order对象中获取不在存在的属性 通过getCustomer实现
    //print_r($customer);            //由于一对一关系，在getCustomer()方法中使用了hasOne()方法，返回为->one()
    //缓存
    $cache = Yii::$app->cache;
    $cache->set('key',$customer,20);
    var_dump($cache->get('key'));
  }

  public function actionTest(){
    if(Yii::$app->request->isPost){
      echo Yii::$app->request->post('title');
    }else{
      $csrfToken = Yii::$app->request->csrfToken;
    return $this->renderPartial('test',['csrfToken'=>$csrfToken]);
    }
  }
  //构建sql语句 使用占位符 防sql注入
  public function actionTest1(){
    $info = (new \yii\db\Query())
      ->select('*')
      ->from('{{%customer}}')
      ->where('name=:name',[':name'=>'zhangsan'])
      ->one();
    print_r($info);
    echo "<hr/>";
    $info1 =Customer::find()->where('name=:name',[':name'=>'lisi'])->asArray()->one();
    print_r($info1);
  }

  public function actionTest2(){
    Yii::$app->session->set('name','tom');//debug测试
    //事件设置
    $test = new Test;
    Yii::$app->on(Yii\base\Application::EVENT_AFTER_REQUEST,[$test,'test']);
    echo "one";
  }
  //数据库场景的应用
  public function actionTest3(){
    $test = new Test;
    $test->scenario = 'scenario1';
    $testData = [
      'data'=>['id'=>3,'title'=>'hello']
    ];
    $test->load($testData,'data');
    echo $test->id;
    echo $test->title;
  }
}