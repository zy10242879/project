<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Category;
use common\models\User;
use common\models\Product;
class CommonController extends Controller{
  public function init()    //当调用继承了CommonController的方法时，会自动先调用init()方法
  {                         //所有前台页面基本及公用数据从此init()方法中获得
    $menu = Category::getMenu();//获得分类信息 此处用了递归，可以用只获得1-2级的非递归getMenu()，看情况使用
    //将数据传递给模板对像的params参数
    $this->view->params['menu'] = $menu;
    $data = [];
    $data['products'] = [];
    $total = 0;
    if (Yii::$app->session['isLogin']) {
      $user_model = User::find()->where('username = :name', [":name" => Yii::$app->session['loginName']])->one();
      if (!empty($user_model) && !empty($user_model->user_id)) {
        $user_id = $user_model->userid;
        $carts = Cart::find()->where('user_id = :uid', [':uid' => $user_id])->asArray()->all();
        foreach($carts as $k=>$pro) {
          $product = Product::find()->where('product_id = :pid', [':pid' => $pro['product_id']])->one();
          $data['products'][$k]['cover'] = $product->cover;
          $data['products'][$k]['title'] = $product->title;
          $data['products'][$k]['product_num'] = $pro['product_num'];
          $data['products'][$k]['price'] = $pro['price'];
          $data['products'][$k]['product_id'] = $pro['product_id'];
          $data['products'][$k]['cart_id'] = $pro['cart_id'];
          $total += $data['products'][$k]['price'] * $data['products'][$k]['product_num'];
        }
      }
    }
    $data['total'] = $total;
    $this->view->params['cart'] = $data;
    $tui = Product::find()->where('is_tui = "1" and is_on = "1"')->orderBy('create_time desc')->limit(4)->all();
    $new = Product::find()->where('is_on = "1"')->orderBy('create_time desc')->limit(4)->all();
    $hot = Product::find()->where('is_on = "1" and is_hot = "1"')->orderBy('create_time desc')->limit(4)->all();
    $sale = Product::find()->where('is_on = "1" and is_sale = "1"')->orderBy('create_time desc')->limit(4)->all();
    $all = Product::find()->where('is_on = "1"')->orderBy('create_time desc')->all();
    $this->view->params['tui'] = (array)$tui;
    $this->view->params['new'] = (array)$new;
    $this->view->params['hot'] = (array)$hot;
    $this->view->params['sale'] = (array)$sale;
    $this->view->params['all'] = (array)$all;
  }
}