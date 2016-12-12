<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use common\models\Product;
use yii\data\Pagination; //载入分页类
use common\models\Category;
use crazyfd\qiniu\Qiniu; //载入七牛类
class ProductController extends Controller{
  //显示商品及分页
  public function actionList(){
    $model = Product::find();
    $count = $model->count();
    $pageSize = Yii::$app->params['pageSize']['product'];
    $pager = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
    $products = $model->orderBy('product_id desc')->offset($pager->offset)->limit($pager->limit)->all();
    $this->layout = "layout_backend";
    return $this->render("products", ['pager' => $pager, 'products' => $products]);
  }

  //添加商品
  public function actionAdd(){
    $this->layout = "layout_backend";
    $model = new Product;
    $cate = new Category;
    $list = $cate->getOption();
    $list[0] = '请选择分类';//去掉　$list[0]＝〉添加顶级分类
    //七牛上传步骤
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      //判断促销与否
      $sale = $this->isSale($post);
      if(!$sale){
        $model->addError('sale_price','确认促销必需填写促销价格');
      }
      //1.为上传图片单独写一个私有upload()方法
      $pics = $this->upload();
      //2.判断是否有图片，如果没有上传图片就报错
      if(!$pics){
        //----报错方法----
        $model->addError('cover','封面不能为空');
      }else{   //10.将upload上传好所获得的外链地址写入到post()中去
        $post['Product']['cover'] = $pics['cover'];
        $post['Product']['pics'] = $pics['pics'];
      }
      $post['Product']['create_time']=time();
      //11.判断封面图片及载入add()方法进行验证及写入数据库中
      if($pics && $sale && $model->add($post)){
        Yii::$app->session->setFlash('info','添加成功');
        return $this->redirect(['product/list']);
      }else{
        //12.如果添加失败查看$key对应的图片，如果有图片将图片删除
        if($pics['cover']){
          $this->delCover($pics);
        }
        if($pics['pics']){
          $this->delPics(json_decode($pics['pics']));
        }
        Yii::$app->session->setFlash('info','添加失败');
      }
    }
    return $this->render("add", ['opts' => $list, 'model' => $model]);
  }

  //3.upload()方法写入
  private function upload(){
    //4.先判断文件是否上传了，判断错误号 大于0说明文件上传有问题
    if($_FILES['Product']['error']['cover']>0){
      return false;
    }
    //5.载入七牛上传类　use crazyfd\qiniu\Qiniu;
    //7.实例化七牛类要传递4个参数，先将AK SK DOMAIN BUCKET 写入product.php活动记录中 6.
    $qiNiu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    //8.进行图片的上传
    //①生成一个key 在七牛上是用key来定位图片的
    $key = uniqid(); //每次生成一个不同的字符串
    //②调用uploadFile()方法来进行上传//查看文件上传情况：var_dump($_FILES);die;
    $qiNiu->uploadFile($_FILES['Product']['tmp_name']['cover'],$key);
    //③获得上传以后封面图片的外链 封面图片上传成功，要在七牛中将图片做相应的处理---新建样式---
    $cover = $qiNiu->getLink($key);
    //④上传图片集　先定义一个$pics=[]来存放以后文件获得的地址数据
    $pics = [];
    //⑤遍历pics的tmp_name 获得对应的图片地址
    foreach ($_FILES['Product']['tmp_name']['pics'] as $k=>$file){
      //⑥判断图片如果错误就跳到下一次遍历去
      if($_FILES['Product']['error']['pics'][$k]>0){
        continue; //跳过本次遍历进入下一次遍历
      }
      //⑦如果没问题同'cover'进行文件上传并获得相应的外链写入$pics[]中去
      $key = uniqid();
      $qiNiu->uploadFile($file,$key);
      $pics[$key] = $qiNiu->getLink($key);
    }
    //9.返回封面图片地址：$cover及图片集地址数组：$pics[]
    //              ------注：返回的$pics　需要将数组格式化为json　可以直接写入到数据表中--------
    return ['cover'=>$cover,'pics'=>json_encode($pics)];
  }
  //判断如果是促销需要输入促销价
  private function isSale($post)
  {
    if ($post['Product']['is_sale']) {
      if ($post['Product']['sale_price'] == '') {
        return false;
      }
    }
    return true;
  }
  //如果商品添加失败，就将上传的图片删除
  private function delCover($pics){
    $qiNiu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    $qiNiu->delete(basename($pics['cover']));
  }
  //如果商品添加失败，如果有图集就将图集删除
  private function delPics($pics){
    $qiNiu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    foreach($pics as $k => $pic){
      $qiNiu->delete(basename($pic));
    }
  }
}