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
      $new =1;
    }else{  //有数据则更新数量
      $data['Cart']['product_num'] = $model->product_num + $num;
      $new = 0;
    }
    $data['Cart']['create_time'] = time();
    $model->load($data);
    $model->save();  //可以创建和更新两种操作 new
    //return $this->redirect(['cart/index']);//使用ajax后此处需要返回json信息
    return $new; //此处应用json_encode()来时行回传　此处简化
  }
  //ajax异步更新商品数量
  public function actionMod(){
    $cart_id = Yii::$app->request->get('cart_id');
    $product_num = Yii::$app->request->get('product_num');
    Cart::updateAll(['product_num'=>$product_num],'cart_id = :cid',[':cid'=>$cart_id]);
  }
  //删除购物车商品
  public function actionDel(){
    $cart_id = Yii::$app->request->get('cart_id');
    try{
      if(Cart::deleteAll('cart_id = :cid',[':cid'=>$cart_id])){
        throw new \Exception(1);
      }else{
        throw new \Exception(0);
      }
    }catch (\Exception $e){
       return $e->getMessage();
    }
    //返回跳转到点击过来的页面
    //return $this->redirect(Yii::$app->request->referrer);
  }
  //ajax异步购物车导航
  public function actionAjaxCartList(){
    //通过session找到用户id
    $user_id = User::find()->where('user_name=:name',[':name'=>Yii::$app->session['loginName']])->one()->user_id;
    //通过用户id找到购物车所有商品
    $carts = Cart::find()->where('user_id=:uid',[':uid'=>$user_id])->asArray()->all();
    $data = [];
    //遍历购物车所有商品　通过商品id需要获得商品的标题，图片
    foreach($carts as $k=>$pro){
      $product = Product::find()->where('product_id=:pid',[':pid'=>$pro['product_id']])->asArray()->one();
      $data[$k]['cover'] = $product['cover'];
      $data[$k]['title'] = $product['title'];
      $data[$k]['price'] = $pro['price'];
      $data[$k]['num'] = $pro['product_num'];
      $data[$k]['cart_id'] = $pro['cart_id'];
      $data[$k]['product_id'] = $pro['product_id'];
    }
    echo json_encode($data);
  }
}