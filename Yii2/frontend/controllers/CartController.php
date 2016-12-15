<?php
namespace frontend\controllers;
use common\models\Product;
use common\models\User;
use frontend\models\Cart;
use Yii;
class CartController extends CommonController {
  //购物车首页
  public function actionIndex(){
    //先判断是否登录
    if(Yii::$app->session['is_login'] !=1){
      return $this->redirect(['member/auth']);
    }
    //获得用户id
    $user_id = User::find()->where('user_name = :user_name',[':user_name'=>Yii::$app->session['loginName']])->one()->user_id;
    //通过用户id查找出购物车中的商品数组
    $products = Cart::find()->where('user_id=:uid',[':uid'=>$user_id])->asArray()->all();
    $data = [];
    foreach ($products as $k => $pro) {
      //遍历数组获得商品id
      $product_id = $pro['product_id'];
      //通过商品id来查找出商品信息
      $product = Product::find()->where('product_id = :pid',[':pid'=>$product_id])->one();
      //将数据存入$data数组中，以便载入模板
      $data[$k]['cover'] = $product->cover;
      $data[$k]['title'] = $product->title;
      $data[$k]['product_num'] = $pro['product_num'];
      $data[$k]['price'] = $pro['price'];
      $data[$k]['product_id'] = $product_id;
      $data[$k]['cart_id'] = $pro['cart_id'];
    }
    $this->layout = 'layout_frontend_nav';
    return $this->render('index',['data'=>$data]);
  }
  //加入购物车
  public function actionAdd(){
    //1.获取session　没有登录就弹出登录页
    if(Yii::$app->session['is_login'] !=1){
      return $this->redirect(['member/auth']);
    }
    //2.由于user_id是要存储在cart表中的 通过session中的user_name在user表中查找到user_id
    $user_id = User::find()->where('user_name = :user_name',[':user_name'=>Yii::$app->session['loginName']])->one()->user_id;
    //3.如果是详情页的post提交
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      $num = Yii::$app->request->post()['product_num'];
      $data['Cart'] = $post;
      $data['Cart']['user_id'] = $user_id;
    }
    //4.如果其它页面的单个get提交
    if(Yii::$app->request->isGet){
      $product_id = Yii::$app->request->get('product_id');
      $model = Product::find()->where('product_id=:pid',[':pid'=>$product_id])->one();
      $price = $model->is_sale ? $model->sale_price : $model->price;
      $num = 1;
      $data['Cart'] = ['product_id'=>$product_id,'product_num'=>$num,'user_id'=>$user_id,'price'=>$price];
    }
    //5.然后查询Cart购物车中是否有此商品，如果有就更新数量，如果没有就创建一条购物车记录
    if(!$model = Cart::find()->where('user_id = :user_id and product_id = :pid',[':user_id'=>$user_id,':pid'=>$data['Cart']['product_id']])->one()){
      $model = new Cart;  //如果没有数据就创建一个新的记录
    }else{  //有数据则更新数量
      $data['Cart']['product_num'] = $model->product_num + $num;
    }
    $data['Cart']['create_time'] = time();
    $model->load($data);
    $model->save();  //可以创建和更新两种操作 new
    return $this->redirect(['cart/index']);
  }
}