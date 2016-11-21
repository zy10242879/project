<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Admin;
use yii\data\Pagination;  //Ⅳ.载入分页类
//⑱⑴创建管理员控制器，来进行邮箱链接的校验及密码修改 以及管理员的CRUL操作
class ManageController extends Controller{
  //⑵创建邮箱密码修改方法
  public function actionMailChangePass(){
    //⑶获取所有get传递过来的参数
    $time = Yii::$app->request->get('timestamp');
    $admin_user = Yii::$app->request->get('admin_user');
    $token = Yii::$app->request->get('token');
    //⑷调用admin模型中的createToken方法，来获得此链接的token值
    $model = new Admin;
    $my_token = $model->createToken($admin_user,$time);
    //⑸判断get传递的token传是否与生成的my_token的值相同
    if($token != $my_token){
      //不等于代表签名是错误的，跳转到登录页面
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
    //⑹限制链接的时间为10分钟内有效，判断当前时间戳减去传递过来的时间戳大于600秒，就跳转到登录页面
    if(time()-$time >600){
      $this->redirect(['public/login']);
      Yii::$app->end();
    }
    //⑻判断是否是post提交，如果是获取post数据，并通过创建一个changePass来进行数据校验及数据库写入
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->changePass($post)){ //在admin.php活动记录中声明一个changePass方法来校验
        Yii::$app->session->setFlash('info','密码修改成功!');//这里同样要在视图中写入判断后载入info
        return $this->renderPartial('mailChangePass',['model'=>$model]);
      }
    }
    //⑺以上校验通过，生成更改用户名和密码的表单　创建mailChangePass，并进行相应修改 由于在视图中声明了rePass　所以在Admin活动记录中同样要像rememberMe一样，声明一个$rePass;
    $model->admin_user = $admin_user; //先给admin_user赋值需要传给隐藏域
    return $this->renderPartial('mailChangePass',['model'=>$model]);
  }

  //Ⅰ.增加管理员列表显示效果
  public function actionManagers(){
    //Ⅱ.载入默认布局，在默认布局中添加管理员管理，修改管理员列表及管理员修改链接
    $this->layout = 'layout_backend';
    //Ⅲ.创建views/manage/managers.php视图文件，加载前端视图
    //查找数据库所有管理员信息，并载入到managers.php视图文件中　遍历标签
    //$managers = Admin::find()->all(); //改造$managers 进行实现分页效果Ⅴ.
    //Ⅳ.载入分页类　　Ⅴ.实现分页效果
    $count = Admin::find()->count();
    //Ⅶ.在backend/config/params.php配置文件中进行pageSize的配置，这样可以不修改控制器而进行页数的设置
    //$pageSize就是调用params中的页数的方法
    $pageSize = Yii::$app->params['pageSize']['manage'];
    $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
    $managers = Admin::find()->offset($pager->offset)->limit($pager->limit)->all();
                    //Ⅵ.将$pager载入模板 并修改managers.php视图　通过yii框架的组件来生成分页图标，注意：写法
    return $this->render('managers',['managers'=>$managers,'pager'=>$pager]);
  }

  //加入新管理员方法实现　注意：views/manage/reg.php表单的写法
  public function actionReg(){
    $this->layout = 'layout_backend';
    $model = new Admin;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->reg($post)){
        Yii::$app->session->setFlash('info','管理员添加成功!');
      }
      $model->admin_pass = "";
      $model->rePass = "";
    }
    //载入新管理员模板
    return $this->render('reg',['model'=>$model]);
  }

  //删除管理员 managers.php视图中加入删除的链接地址
  /*<?=yii\helpers\Url::to(['manage/del','admin_id'=>$manager->admin_id]);?>*/
  public function actionDel(){
    //增加(int)强转为整型以防xss攻击  获得admin_id传过来的id值
    $admin_id = (int)Yii::$app->request->get('admin_id');
    //判断admin_id是否存在，不存在跳转到显示页
    if(empty($admin_id)){
      $this->redirect(['manage/managers']);
    }
    //删除管理员，如果删除成功返回删除成功信息 同时在managers.php视图中要加入getFlash('info')等信息
    if(Admin::deleteAll('admin_id=:id',[':id'=>$admin_id])){
      Yii::$app->session->setFlash('info','管理员删除成功!');
      $this->redirect(['manage/managers']);
    }
  }

  //邮箱修改　点击共公布局中的账户管理中的个人信息管理来进行邮箱的修改
  public function actionChangeEmail(){
    $this->layout = 'layout_backend';
    //session中存有当前登录的用户名，可以方便取用
    $model = Admin::find()->where('admin_user=:user',[':user'=>Yii::$app->session['admin']['admin_user']])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      //changeEmail()方法在phpstorm中报错，实际情况可以正常运行，因为以上Admin:find()->one();获得的是对象
      if($model->changeEmail($post)){
        Yii::$app->session->setFlash('info','电子邮箱修改成功');
      }
    }
    $model->admin_pass = '';
    return $this->render('changeEmail',['model'=>$model]);
  }

  //修改管理员密码
  public function actionChangePass(){
    $this->layout = 'layout_backend';
    $model = Admin::find()->where('admin_user=:user',[':user'=>Yii::$app->session['admin']['admin_user']])->one();
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->updatePass($post)){
        Yii::$app->session->setFlash('info','密码修改成功');
      }
    }
    $model->admin_pass= '';
    $model->newPass = '';
    $model->rePass = '';
    return $this->render('changePass',['model'=>$model]);
  }
}