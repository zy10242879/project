<?php
namespace frontend\models;

use yii\db\ActiveRecord;
class Test1 extends ActiveRecord{
  public static function tableName(){
    return "{{%user}}";
  }
}
