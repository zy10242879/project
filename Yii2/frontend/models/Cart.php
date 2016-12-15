<?php
namespace frontend\models;
use yii\db\ActiveRecord;
class Cart extends ActiveRecord{
  public static function tableName()
  {
    return '{{%cart}}';
  }
  public function rules()
  {
    return [
      [['product_id','product_num','price','user_id'],'required'],
      ['create_time','safe']
    ];
  }
}