<?php
namespace frontend\models;
use yii\db\ActiveRecord;
class Customer extends ActiveRecord{
  //帮助顾客获取订单信息 一对多关系
  public function getOrders(){ //不能声明static $this会报错
    //以下的$this是指实例化customer类的对象->去调用对象的方法，hasMany是activeRecord中的方法
    // 一对多关联查询使用hasMany()  结果会自动返回 all()  所有asArray()->all()可加可不加
    return $this->hasMany(Order::className(),['customer_id'=>'id'])->asArray();
  }
}