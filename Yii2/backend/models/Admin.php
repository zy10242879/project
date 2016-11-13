<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
class Admin extends ActiveRecord{
  //定义一个属性rememberMe 由于在form表单中有记住我这个复选框，而数据库中没有这个属性，所以要在这里声明一个
  public $rememberMe = true;
  //定义静态方法来表示该类操作的数据表
  public static function tableName()
  {
    return '{{%admin}}'; //{{%}}表前缀
  }
  //5.使用rules()执行验证
  public function rules()
  {
    return [
      ['admin_user','required','message'=>'管理员账号不能为空'],
      ['admin_pass','required','message'=>'管理员密码不能为空'],
      ['rememberMe','boolean'],
      //6.验证密码是否正确，需添加自定义回调方法
      ['admin_pass','validatePass'],
    ];
  }
  //7.创建validatePass方法来进行验证
  public function validatePass(){
    //8.先判断前面数据是否有错误，如果有错误就不查询数据库，直接报错，没有错再查询数据库，减少数据库压力
    if(!$this->hasErrors()){  //其中self等同于Admin 因为是在自己的活动记录中查询数据
      $data = self::find()->where('admin_user = :user and admin_pass = :pass',[':user'=>$this->admin_user,':pass'=>md5($this->admin_pass)])->one();
      //9.根据$data返回的类型进行判断，能够查询出来是一个对象，不能查询出来是null
      if(is_null($data)){
        //10.空的话直接报错 给admin_pass报错
        $this->addError('admin_pass','用户名或者密码错误');
      }
    }
  }

  //4.声明login方法(执行验证，如果验证成功，将数据写入session并执行跳转)
  public function login($data){
    //11.在login方法中执行验证 load载入数据，有数据载入返回真 无则假
    //------通过调用validate方法来进行rules验证------
    if($this->load($data) && $this->validate()){
      //15.将用户登录的信息写入session中
      //$lifetime作用　为了页面下方的记住我，将session设置保存时间，有点击记住我保存1天，没有就关闭浏览器失效
      $lifetime = $this->rememberMe ? 24*3600 : 0;
      $session = Yii::$app->session;
      session_set_cookie_params($lifetime);//设置保存session的cookie的有效期
      //session中存入数据
      $session['admin']=[
        'admin_user' => $this->admin_user,
        'is_login' => 1,
      ];
      //16.更新数据库中用户登录的时间和ip地址 通过条件为用户名=输入的用户名
      $this->updateAll(['login_time'=>time(),'login_ip'=>ip2long(Yii::$app->request->userIP)],'admin_user=:user',[':user'=>$this->admin_user]);
      //17.如果保存成功了，将is_login强转为布尔型，来返回true;
      return (boolean)$session['admin']['is_login'];
    }
    //12.验证不通过则返回假
    return false;
  }
}