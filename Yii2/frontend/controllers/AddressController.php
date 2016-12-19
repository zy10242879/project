<?php
namespace frontend\controllers;
use common\models\Address;
use Yii;
use common\models\User;
class AddressController extends CommonController {
  //添加地址的方法 //此处该做ajax验证
  public function actionAdd(){
    $this->isLogin();
    $user_id = User::find()->where('user_name=:name',[':name'=>Yii::$app->session['loginName']])->one()->user_id;
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      $post['address'] = $post['address1'].$post['address2'];
      $post['user_id'] = $user_id;
      $post['create_time'] = time();
      $data['Address'] = $post;
      $model = new Address();
      $model->load($data);
      $model->save();
    }
    return $this->redirect(Yii::$app->request->referrer);
  }
  //删除地址
  public function actionDel(){
    $this->isLogin();
    $user_id = User::find()->where('user_name=:name',[':name'=>Yii::$app->session['loginName']])->one()->user_id;
    $address_id = Yii::$app->request->get('address_id');
    if(!Address::find()->where('user_id = :uid and address_id = :aid',[':uid'=>$user_id,':aid'=>$address_id])->one()){
      return $this->redirect($_SERVER['HTTP_REFERER']); //效果同下 referrer
    }
      Address::deleteAll('address_id = :aid',[':aid'=>$address_id]);
    return $this->redirect(Yii::$app->request->referrer);
  }
}