<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
class Admin extends ActiveRecord{
  //定义一个属性rememberMe 由于在form表单中有记住我这个复选框，而数据库中没有这个属性，所以要在这里声明一个
  public $rememberMe = true;
  public $rePass;
  //定义静态方法来表示该类操作的数据表
  public static function tableName()
  {
    return '{{%admin}}'; //{{%}}表前缀
  }
  //设置labels的属性名(在表单view/manage/reg.php中使用到，它处同样使用)
  public function attributeLabels()
  {
    return [
      'admin_user'=>'管理员账号',
      'admin_email'=>'管理员邮箱',
      'admin_pass'=>'管理员密码',
      'rePass'=>'确认密码',
    ];
  }

  //5.使用rules()执行验证
  public function rules()
  {
    return [
      ['admin_user','required','message'=>'管理员账号不能为空','on'=>['login','seekPass','adminAdd']],
      ['admin_pass','required','message'=>'管理员密码不能为空','on'=>['login','changePass','adminAdd']],
      ['rememberMe','boolean','on'=>['login']],
      ['admin_email','required','message'=>'电子邮箱不能为空','on'=>['seekPass','adminAdd']],
      ['admin_email','email','message'=>'请输入正确的电子邮箱格式','on'=>['seekPass','adminAdd']],
      ['admin_email','validateEmail','on'=>['seekPass']],
      //6.验证密码是否正确，需添加自定义回调方法
      ['admin_pass','validatePass','on'=>['login']],
      ['rePass','compare','compareAttribute'=>'admin_pass','message'=>'两次密码输入不一致','on'=>['changePass','adminAdd']],
      ['rePass','required','message'=>'确认密码不能为空','on'=>['changePass','adminAdd']],
      ['admin_email','unique','message'=>'电子邮箱已被注册','on'=>['adminAdd']],
      ['admin_user','unique','message'=>'管理员账号已被注册','on'=>['adminAdd']],
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
        $this->addError('admin_pass','管理员账号或密码错误');
      }
    }
  }

  //4.声明login方法(执行验证，如果验证成功，将数据写入session并执行跳转)
  public function login($data){
    $this->scenario = 'login';
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
  //⑨定义validateEmail来进行验证，及数据查询
  public function validateEmail(){
    if(!$this->hasErrors()){
      $data = self::find()->where('admin_user=:user and admin_email=:email',[':user'=>$this->admin_user,':email'=>$this->admin_email])->one();
      if(is_null($data)){
        $this->addError('admin_email','管理员账号或电子邮箱不匹配');
      }
    }
  }
  //⑦创建seekPass来判断传入的数据
  public function seekPass($data){
    //⑧在rules中加入验证规则，此处要定义验证场景，由于login和seekPass同样者使用了rules方法
    //同样在login中也要定义验证场景　　$this->scenario = 'login' 然后通过'on'=>['login','seePass']来定义场景
    //⑨同样在rules中要自定义验证方法validateEmail()方法进行验证
    $this->scenario = 'seekPass';
    if($this->load($data) && $this->validate()){
      //⑮ 设置seekPass模板要传入的参数　$time(时间戳) $token(签名——是一个生成签名的方法)以及admin_user 3个参数
      $time =time(); //以下compose()中需要传入的参数 时间戳
      $token = $this->createToken($data['Admin']['admin_user'],$time); //以下compose()中需要传入的参数⑯
      /*⑪发送邮件的配置项
       * 配置电子邮件发送　common->config->main-local.php文件中更换以下内容
            'useFileTransport' => false,  //此处要改为false　才能够发送邮件
            'transport' => [
              'class' => 'Swift_SmtpTransport',  //需要开启邮箱 设置->POP3/SMTP/IMAP 以及客户端授权密码
              'host' => 'smtp.163.com',  //此处用的是163的邮箱
              'username' => '10242879@163.com',　　//为发件人的邮箱
              'password' => 'zy10242879',　　//授权码
              'port' => '465',   //此处用'25'的话，以下改为'tls'
              'encryption' => 'ssl',  // '465' 'ssl' 较为安全*/
      //⑫以下为发送邮件的方法：在vendor->yiisoft->yii2-swiftmailer->Mailer.php中可以找到注释使用方法
      //   composer('使用的模板',[传入的参数1],[参数2]....) 以下seekPass要定义在common->mail下
                                                                //特别注意下：Admin A大写
      $mailer = Yii::$app->mailer->compose('seekPass',['admin_user'=>$data['Admin']['admin_user'],'time'=>$time,'token'=>$token]);
      $mailer->setFrom('10242879@163.com'); //设置发件人
      $mailer->setTo($data['Admin']['admin_email']); //特别注意：Admin中A大写   //收件人-表单传过来的邮箱
      $mailer->setSubject('商城—找回密码');  //设置主题
      if($mailer->send()){  //如果发送成功，就返回真
        return true;       //然后回到PublicController 中调用此seekPass的地方 进行返回信息⑬
      }
    }
    //⑩如果验证失败，则返回false　将错误返回到页面上
    return false;
  }
  //⑯以下方法为自定义的签名生成方法，可以根据自己需要随意更改
  public function createToken($admin_user,$time){
    //将用户名md5加密后连上用户IP64位加密连上时间戳md5加密　然后对整体进行md5加密后所获得的32位字符串
    return md5(md5($admin_user).base64_encode(Yii::$app->request->userIP).md5($time));
    //⑰查看common->mail->seekPass.php的样式写法 由于本身mailer就有layouts默认布局，所以写入内容即可
  } //⑱邮箱链接创建完成，点击链接后进行访问manager控制器，然后调用mailChangePass方法来进行传入的参数的校验，校验确认后进行页面载入，并通过提交新密码来修改数据密码的操作，创建新的步骤⑱⑴

  //⑼声明changePass进行校验及数据库修改管理员密码
  public function changePass($data){
    //将数据载入并进行校验　同之前的操作类似
    $this->scenario ='changePass'; //声明场景，进行校验见rules()
    if($this->load($data) && $this->validate()){
      //载入成功并校验成功，进行数据库修改操作 修改成功强转为boolean类型
      Yii::$app->session->setFlash('info','设置密码是当前可用密码!');
      return (bool)$this->updateAll(['admin_pass'=>md5($this->admin_pass)],'admin_user=:user',[':user'=>$data['Admin']['admin_user']]);
    }
    return false;
  }
  //加入新管理员的reg方法
  public function reg($data){
    $this->scenario = 'adminAdd';
    if($this->load($data) && $this->validate()){
      $this->admin_pass = md5($this->admin_pass);
      $this->create_time = time();
      return (bool)$this->save(false);
    }
  }
}

