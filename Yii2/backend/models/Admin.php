<?php
namespace backend\models;
use yii\db\ActiveRecord;
class Admin extends ActiveRecord{
  //定义一个属性rememberMe 由于在form表单中有记住我这个复选框，而数据库中没有这个属性，所以要在这里声明一个
  public $rememberMe = true;
  //定义静态方法来表示该类操作的数据表
  public static function tableName()
  {
    return '{{%admin}}'; //{{%}}表前缀
  }

}