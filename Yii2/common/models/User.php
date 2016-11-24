<?php
namespace common\models;
use Yii;
use yii\db\ActiveRecord;

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
      ['user_email','required','message'=>'电子邮箱不能为空','on'=>['reg','regByEmail']],
      ['user_email','unique','message'=>'电子邮箱已被注册','on'=>['reg','regByEmail']],
      ['user_email','email','message'=>'电子邮箱格式不正确','on'=>['reg','regByEmail']],
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

  //通过email创建用户
  public function regByEmail($data){
    $this->scenario = 'regByEmail';
    if($this->load($data) && $this->validate()){
      $data['User']['user_name'] = 'shop_'.uniqid();
      $data['User']['user_pass'] = uniqid();
      $data['User']['create_time']= time();
      $token = $this->createToken($data['User']['user_name'],$data['User']['create_time']);
      $mailer = Yii::$app->mailer->compose('createUser', ['user' => $data['User'],'token'=>$token]);
      $mailer->setFrom('10242879@163.com'); //设置发件人
      $mailer->setTo($data['User']['user_email']); //特别注意：Admin中A大写   //收件人-表单传过来的邮箱
      $mailer->setSubject('商城—创建用户');  //设置主题
      if ($mailer->send()) {  //如果发送成功，就返回真

        return true;
      }
    }
    return false;
  }

  public function createToken($user_name, $time)
  {
    //将用户名md5加密后连上用户IP64位加密连上时间戳md5加密　然后对整体进行md5加密后所获得的32位字符串
    return md5(md5($user_name) . base64_encode(Yii::$app->request->userIP) . md5($time));
  }

}