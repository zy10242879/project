<?php
namespace common\models;
use yii\db\ActiveRecord;
use common\models\Profile;
class User extends ActiveRecord{
  public $rePass;
  public static function tableName()
  {
    return '{{%user}}';
  }

  public function attributeLabels()
  {
    return [
      'user_name'=>'用户名',
      'user_email'=>'电子邮箱',
      'user_pass'=>'用户密码',
      'rePass'=>'确认密码'
    ];
  }

  public function rules(){
    return [
      ['user_name','required','message'=>'用户名不能为空','on'=>['reg']],
      ['user_name','unique','message'=>'用户名已存在','on'=>['reg']],
      ['user_email','required','message'=>'电子邮箱不能为空','on'=>['reg']],
      ['user_email','unique','message'=>'电子邮箱已被注册','on'=>['reg']],
      ['user_email','email','message'=>'电子邮箱格式不正确','on'=>['reg']],
      ['user_pass','required','message'=>'密码不能为空','on'=>['reg']],
      ['rePass','required','message'=>'确认密码不能为空','on'=>['reg']],
      ['rePass','compare','compareAttribute'=>'user_pass','message'=>'两次密码不一致','on'=>['reg']]
    ];
  }

  public function reg($data,$scenario='reg'){
    $this->scenario = $scenario;
    if($this->load($data) && $this->validate()) {
      $this->user_pass = md5($this->user_pass);
      $this->create_time = time();
      return (bool)$this->save(false);
    }
    return false;
  }

  public function getProfile(){
    //返回关联查询条件的对象　同时要新建一个models/Profile　活动记录并创建 tableName()方法即可
    return self::hasOne(Profile::className(),['user_id'=>'user_id']);
  }

}