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
  }
}     //18.至此login登录效果已经完成，可以在login中判断如果已经登录了就默认跳转到后台首页而不显示登录框
      //其实不用以上判断，由于后台管理员登录时直接登录到后台首页页面，而登录时先判断登录状态，如果不是有效登录状态，就自动跳转到登录页面，后面实现效果为，要判断登录效果的页面的controller 不继承Controller 而是让CommonController来继承Controller 让需要判断的页面来继承CommonController 在CommonController中写入session的判断方法即可