<?php
namespace common\models;
use yii\db\ActiveRecord;
class OrderDetail extends ActiveRecord{
  public static function tableName()
  {
    return '{{%order_detail}}';
  }
  public function rules()
  {
    return [
      [['product_id','product_num','price','order_id','create_time'],'required'],
    ];
  }
  public function add($data){
    if($this->load($data) && $this->save()){
      return true;
    }
    return false;
  }
}