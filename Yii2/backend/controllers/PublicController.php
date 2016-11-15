<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Admin; //定义命名空间，为载入活动记录
class PublicController extends Controller{
  //登录页面
  public function actionLogin(){
    $model = new Admin;//载入活动记录（模型）
    //1.判断是否有post数据提交
    if(Yii::$app->request->isPost){
      //2.有数据的话就接收post数据，(执行验证，执行登录操作)
      $post = Yii::$app->request->post();
      //3.将post数据传递给model在model中做数据验证(验证完毕后执行登录)
      //--$model->login($post);--
      //13.调用login()时增加判断，如果有错显示错误信息，如果正确进行跳转
      if($model->login($post)){
        $this->redirect(['index/index']);//跳转到后台首页注意"/"　需要先写入session　保存登录数据　见15步
        Yii::$app->end(); //结束程序不执行以下载入内容
      }  //如果返回false　将跳过上面，将错误加载到页面上
    } //14.将错误信息显示到页面中 login.php中修改
    return $this->renderPartial('login',['model'=>$model]);//将model载入为方便创建form表单
  }     //18.至此login登录效果已经完成，可以在login中判断如果已经登录了就默认跳转到后台首页而不显示登录框
  //其实不用以上判断，由于后台管理员登录时直接登录到后台首页页面，而登录时先判断登录状态，如果不是有效登录状态，就自动跳转到登录页面，后面实现效果为，要判断登录效果的页面的controller 不继承Controller 而是让CommonController来继承Controller 让需要判断的页面来继承CommonController 在CommonController中写入session的判断方法即可

  /*点击后台首页右上角的登出效果的实现
    1.在公共视图　backend\views\layouts\layout_backend.php
    <li class="settings hidden-phone"> 下面更改标签跳转的路径
    <?=yii\helpers\Url::to(['public/login']);?> 是yii提供的跳转路径，便于后期URL美化效果 */
  //登出效果
  //2.定义actionLogout　登出方法
  public function actionLogout(){
    //3.先清除session信息
    Yii::$app->session->removeAll();
    //4.判断session['admin']中的is_login是否存在
    if(!isset(Yii::$app->session['admin']['is_login'])){
      //5.不存在，跳转到登录页面
      $this->redirect(['public/login']);
      Yii::$app->end(); //跳转后必需要加结束程序
    }
    //6.否则，就跳回到原来的页面
    $this->goBack();
  }

  //电子邮箱找回密码的实现--发送邮件并生成对应链接 seekPassword
  /*①设置login.php视图文件的找回密码的url地址：<?=yii\helpers\Url::to(['public/seek-password'])?>
  ②定义SeekPassword 方法　在login.php中写入链接地址：由于S P大写，所以，以上中要在两个单词间加上- */
  public function actionSeekPassword(){
    //④实例化Admin创建$model对象
    $model = new Admin;
    //⑥判断是否有post数据传递，有就将$post数据传递到Admin模型的seekPass方法中去 $model->seekPass($post)
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->seekPass($post)){ //$model->seekPass($post)返回真或假　所以此处做个if判断，假显示错误
        //⑬验证通过后进行session中存入临时的数据，到以下视图seekPassword中去显示效果出来
        //setFlash()设置  getFlash()访问　hasFlash()判断是否存在　只可访问一次的session信息，访问后自动删除
        Yii::$app->session->setFlash('info','电子邮件已经发送成功，请查收');
        //⑭以上内容完成后，在seekPassword.php视图文件中 加入判断存在'info'信息则输出设置的返回结果
      }
    }
    //③载入模板seekPassword 创建seekPassword 样子同login 复一下修改一下模板样式即可
                                              //⑤将model发送给视图
    return $this->renderPartial('seekPassword',['model'=>$model]);
  }
}