<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\User;
class MemberController extends Controller
{
  //填邮箱注册会员
  public function actionReg()
  {
    $this->layout = 'layout_frontend';
    $model = new User;
    if (Yii::$app->request->isPost) {
      $post = Yii::$app->request->post();
      if ($model->regByEmail($post)) {
        Yii::$app->session->setFlash('info_reg', '电子邮件发送成功，请查收');
      }
    }
    return $this->render('auth', ['model' => $model]);
  }

  //通过用户邮箱点击链接后校验用户数据，进行用户数据写入数据库，并进入登录状态
  public function actionMailLogin()
  {
    $user_name = Yii::$app->request->get('user_name');
    $user_pass = Yii::$app->request->get('user_pass');
    $user_email = Yii::$app->request->get('user_email');
    $create_time = Yii::$app->request->get('create_time');
    $token = Yii::$app->request->get('token');
    $model = new User;
    //这里可以加强一下token 就是生成createToken将以上name,pass,email,time全部传入生成token
    // 这样如果get的数据被修过了,那就不可能通过以下的判断$my_token == $token的判断
    $my_token = $model->createToken($user_name,$user_pass,$user_email,$create_time);
    if ($my_token !== $token) {
      $this->redirect(['member/auth']);
      Yii::$app->end();
    }
    if (time() - $create_time > 600) {
      $this->redirect(['member/auth']);
      Yii::$app->end();
    }
    if (empty(User::find()->where('user_name=:user', [':user' => $user_name])->count())) {
      //将用户信息写入数据库中
      $model->user_name = $user_name;
      $model->user_pass = $user_pass;
      $model->user_email = $user_email;
      $model->create_time = $create_time;
      //此处不做验证了 前面token需要强化
      if ($model->save()) {
        $session = Yii::$app->session;
        $session['loginName'] = $user_name;
        $session['is_login'] = 1;
      }
      $this->redirect(['index/index']);
      Yii::$app->end();
    }
    $this->redirect(['member/auth']);
    Yii::$app->end();
  }

  //清空session，并登出
  public function actionLogout(){
    Yii::$app->session->removeAll();
    if(!isset(Yii::$app->session['is_login'])){
      $this->redirect(['index/index']);
      Yii::$app->end();
    }
    $this->goBack();
  }

  //用户登录
  public function actionAuth(){
    $this->layout = 'layout_frontend_nav';
    $model = new User;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->login($post)){
        $this->redirect(['index/index']);
        //此方法为，跳回到来源页
        //return $this->goBack(Yii::$app->request->referrer);
      }
    }
    return $this->render('auth',['model'=>$model]);
  }

  //qq登录
  //1.申请及配置相关
  //①申请QQ互联APP帐号　connect.qq.com
  //②下载SDK，配置APP账号　首次运行install/install.html 写入APPID,APPkey等
  //③将SDK中的API复制到vendor目录下，可改名为qqlogin
  //④所有QQ登录需要通过申请的域名来进行访问，此处为www.sxlzrc.com
  //⑤配置windows下的hosts:192.168.1.58 www.sxlzrc.com（此处为虚拟机mac同样配置DNS）
  //⑥配置nginx:vi /etc/nginx/conf.d/project.conf 此为服务器的站点配置

  //⑦----此处需特别注意，由于后面qq_login跳转到的是www.sxlzrc.com/index.php?r=member/qqcallback----
  // ----所以如果前面不是指向index.php的话，要重新建立配置文件将站点指向frontend/web/　后面才可以找到qqcallback---

  //  server name project.com www.sxlzrc.com; 以上情况要重新建立一个站点配置
  //  vi /etc/hosts  127.0.0.1 www.sxlzrc.com
  // systemctl restart nginx  && systemctl restart php-fpm (windows清下缓存)
  //2.先修改views/auth.php视图文件　让qq登录的图标跳转到 member/qq-login下(QqLogin在视图中写成qq-login)
  /*可以将button写成  <a href="<?=yii\helpers\Url::to(['member/qq-login']);?>"><button id='login_qq' class="btn-block btn-lg btn btn-facebook"><i class="fa fa-qq"></i> 使用QQ账号登录</button></a>
  来进行跳转操作，也可以在最下方通过js来进行跳转 通过button 的 id  'login_qq'

  */
  //3.创建QqLogin方法来进行登录操作
  public function actionQqLogin(){
    //4.载入API文件
    require_once("../../vendor/qqLogin/qqConnectAPI.php");
    //5.实例化qqAPI中集成的QC类生成$qc对象
    $qc = new \QC();  //由于QC继承Oauth类，所有拥有Oauth类中的qqlogin方法
    //6.调用qq_login方法
    $qc->qq_login();  //自动执行跳转操作 跳转到member/qqcallback方法
  }

  //7.建站跳转到qqcallback的方法
  public function actionQqcallback(){
    //8.获取QQ登录帐号信息
    //⑴载入API文件类  用来实例化OAuth类 及QC类
    require_once("../../vendor/qqLogin/qqConnectAPI.php");
    //⑵实例化OAuth类生成$auth对象
    $auth = new \OAuth();
    //⑶获得accessToken数据
    $accessToken = $auth->qq_callback();
    //⑷获取openid数据
    $openid = $auth->get_openid();  //openid为腾迅内部用户的唯一id号，
    //⑸实例化QC类生成$qc对象　并传入$accessToken $openid
    $qc = new \QC($accessToken,$openid);
    //⑹要调用get_user-info()方法，需要在上面传递$accessToken $openid
    $userInfo = $qc->get_user_info();
    //9-①.将获得的用户信息写入到session中 如果在数据库中查找到openid就只要把loginName和is_login写入session
    $session = Yii::$app->session;
    //10.判断用户是否绑定过自己网站的用户，如果绑定过就做登录操作并跳转到首页，如果没有绑定就先绑定该用户
    //   通过唯一标识openid来进行账号的判断 没有绑定的话　将openid插入到user数据库表中 然后输入用户基本信息
    //判断在数据库中查找openid是否有这条记录
    if(User::find()->where('openid=:openid',[':openid'=>$openid])->one()){
      //11.有就将数据写入session中　包括loginName is_login
      $session['loginName'] = $userInfo['nickname'];
      $session['is_login'] = 1;
      //-----更改frontend/config/main.php session保存名称为PHPSESSID-------才能使session正确存储
      //12.并跳转到登录首页面
      return $this->redirect(['index/index']);
    }
    //13.否则就跳转到完善信息页面　　qq-reg 写法 对应下方QqReg
    //9-②.如果数据库中查找不到用户信息，则要将从qqAPI中获得的用户数据写入session以便后面写入数据库
    $session['userInfo']=$userInfo;
    $session['openid'] = $openid;
    return $this->redirect(['member/qq-reg']);
  }

  //14.创建QqReg方法
  public function actionQqReg(){
    //14-①载入公共布局
    $this->layout = 'layout_frontend';
    //14-②实例化User类生成$model对象
    $model = new User;
    //15.如果有提交，则进行数据校验，并完成注册操作
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      //16.要将openid写入到$post中去，不然后面验证会出现openid不能为空
      $post['User']['openid'] = Yii::$app->session['openid'];
      //17.添加验证场景，及传入数据，注：写入数据库的数据要全部进行验证，不然会出错
      if($model->reg($post,'qqReg')){
        //18.成功写入数据库后将登录信息写入session中
        $session = Yii::$app->session;
        $session['loginName'] = Yii::$app->session['userInfo']['nickname'];
        $session['is_login'] = 1;
        return $this->redirect(['index/index']);
      }
        var_dump($model->getErrors());die; //如果有问题可以通以此方法来查看错误
    }
    //14-③加载qqReg页面，并载入$model类  在views/member/下创建qqReg.php视图文件复制auth.php进行修改
    return  $this->render('qqReg',['model'=>$model]);
  }
}