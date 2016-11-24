<?php
namespace backend\controllers;
use common\models\Profile;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use common\models\User;

class UserController extends Controller{

  //显示用户信息　关联查询-->分页-->载入
  public function actionUsers(){
    $this->layout = 'layout_backend';
    //生成关联查询的模型对象  调用models/user.php 中的getProfile方法
    $model = User::find()->joinWith('profile');
    //获得分页的总记录数；
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['user'];
    $pager = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
    $users = User::find()->offset($pager->offset)->limit($pager->limit)->all();
    return $this->render('users',['users'=>$users,'pager'=>$pager]);
  }

  //添加新用户
  public function actionReg(){
    $this->layout = 'layout_backend';
    $model = new User;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if($model->reg($post)){
        Yii::$app->session->setFlash('info','用户添加成功');
      }
    }
    $model->user_pass = '';
    $model->rePass = '';
    return $this->render('reg',['model'=>$model]);
  }

  //删除用户 同时删除对应id的user表中的记录及profile表中的记录
  //需要用到事务处理 try{}catch(\Exception){} 事务写法，详见yii官方文档
  public function actionDel(){
    try{
      $user_id = (int)Yii::$app->request->get('user_id');
      if(empty($user_id)){  //如果user_id是空的
        throw new \Exception(); //抛出异常
      }
      $trans = Yii::$app->db->beginTransaction();
      if ($obj = Profile::find()->where('user_id = :id', [':id' => $user_id])->one()) {
        $res = Profile::deleteAll('user_id = :id', [':id' => $user_id]);
        if (empty($res)) {
          throw new \Exception();
        }
      }
      if (!User::deleteAll('user_id = :id', [':id' => $user_id])) {
        throw new \Exception();
      }
      $trans->commit();
    }catch (\Exception $e){
      if ($trans = Yii::$app->db->getTransaction()) {
        $trans->rollBack();
      }
    }
    Yii::$app->session->setFlash('info','删除成功');
    $this->redirect(['user/users']);
  }
}






















