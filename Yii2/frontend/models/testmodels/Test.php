<?php
namespace frontend\models;
use yii\db\ActiveRecord;
class Test extends ActiveRecord{
  public static function tableName()
  {
    return '{{%test}}'; // TODO: Change the autogenerated stub
  }

  public function scenarios()
  {
    return [
      'scenario1'=>['id','title'],
      'scenario2'=>['id'],
    ];
  }

}