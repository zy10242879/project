<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\User;
class MemberController extends Controller
{
  //会员登录
  public function actionAuth()
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
    if (time() - $create_time > 6000) {
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
        $session['user'] = [
          'user_name' => $user_name,
          'is_login' => 1,
        ];
      }
      $this->redirect(['index/index']);
      Yii::$app->end();
    }
    $this->redirect(['member/auth']);
    Yii::$app->end();
  }

  public function actionLogout(){
    Yii::$app->session->removeAll();
    if(!isset(Yii::$app->session['user']['is_login'])){
      $this->redirect(['index/index']);
      Yii::$app->end();
    }
    $this->goBack();
  }

  //用户登录
  public function actionLogin(){
    $this->layout = 'layout_frontend';
    $model = new User;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->login($post)){
        $this->redirect(['index/index']);
        Yii::$app->end();
      }
    }
    return $this->render('auth',['model'=>$model]);
  }
}