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
}