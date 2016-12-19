<?php
namespace common\models;
use yii\db\ActiveRecord;
class Address extends ActiveRecord{
  public static function tableName()
  {
    return '{{%address}}';
  }
  public function rules()
  {
    return [
      [['user_id', 'first_name', 'last_name', 'address', 'email', 'telephone'], 'required'],
      [['create_time', 'postcode'],'safe'],
    ];
  }
}