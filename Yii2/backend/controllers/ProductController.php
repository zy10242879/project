<?php
namespace backend\controllers;
use Yii;
use common\models\Product;
use yii\data\Pagination; //载入分页类
use common\models\Category;
use crazyfd\qiniu\Qiniu; //载入七牛类
class ProductController extends CommonController {
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
          $this->delCover($pics['cover']);
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
    $qiNiu->delete(basename($pics));
  }
  //如果商品添加失败，如果有图集就将图集删除
  private function delPics($pics){
    $qiNiu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    foreach($pics as $k => $pic){
      $qiNiu->delete(basename($pic));//==$qiNiu->delete($k); basename($pic)=$key
    }
  }
  //商品编辑功能
  public function actionMod()
  {
    $this->layout = "layout_backend";
    $cate = new Category;
    $list = $cate->getOption();
    unset($list[0]);

    $product_id = Yii::$app->request->get("product_id");
    $model = Product::find()->where('product_id = :id', [':id' => $product_id])->one();
    if (Yii::$app->request->isPost) {
      $post = Yii::$app->request->post();
      $qiNiu = new Qiniu(Product::AK, Product::SK, Product::DOMAIN, Product::BUCKET);
      $post['Product']['cover'] = $model->cover;
      if ($_FILES['Product']['error']['cover'] == 0) {
        $key = uniqid();
        $qiNiu->uploadFile($_FILES['Product']['tmp_name']['cover'], $key);
        $post['Product']['cover'] = $qiNiu->getLink($key);
        $qiNiu->delete(basename($model->cover));
      }
      $pics = [];
      foreach($_FILES['Product']['tmp_name']['pics'] as $k => $file) {
        if ($_FILES['Product']['error']['pics'][$k] > 0) {
          continue;

        }
        $key = uniqid();
        $qiNiu->uploadFile($file, $key);
        $pics[$key] = $qiNiu->getLink($key);
      }
      $post['Product']['pics'] = json_encode(array_merge((array)json_decode($model->pics, true), $pics));
      $sale = $this->isSale($post);
      if(!$sale){
        $model->addError('sale_price','确认促销必需填写促销价格');
      }
      if ($sale && $model->load($post) && $model->save()) {
        Yii::$app->session->setFlash('info', '修改成功');
      }else{
        Yii::$app->session->setFlash('info','修改失败，请检查错误');
      }
    }
    return $this->render('mod', ['model' => $model, 'opts' => $list]);
  }
  //针对编辑中图片集删除写入actionRemovePic()
  public function actionRemovePic(){
    //⑴接收get数据
    $key = Yii::$app->request->get('key');
    $product_id = Yii::$app->request->get('product_id');
    //⑵找到该商品
    $model = Product::find()->where('product_id = :pid',[':pid'=>$product_id])->one();
    //⑶实例化七牛类
    $qiNiu = new Qiniu(Product::AK,Product::SK,Product::DOMAIN,Product::BUCKET);
    //⑷删除$key对应的图片
    $qiNiu->delete($key);
    //(5)获得pics的值　并删除对应pics[]的值
    $pics = json_decode($model->pics,true);
    unset($pics[$key]);
    //⑹写入数据库
    Product::updateAll(['pics'=>json_encode($pics)],'product_id = :pid',[':pid'=>$product_id]);
    //⑺跳转到修改页面，传入数据显示
    return $this->redirect(['product/mod','product_id'=>$product_id]);
  }
  //商品删除  //可以通过事务处理来完成删除　以免其中一个删除错误而导致程序无法运行
  public function actionDel(){
    $trans = Yii::$app->db->beginTransaction();
    try{
      $product_id = Yii::$app->request->get('product_id');
      if(empty($product_id)){
        throw new \Exception('参数错误');
      }
      $model = Product::find()->where('product_id = :pid',[':pid'=>$product_id])->one();
      if(!$model){
        throw new \Exception('无法找到对应数据');
      }
      if(!Product::deleteAll('product_id = :pid',[':pid'=>$product_id])){
        throw new \Exception('数据删除失败');
      }
      if($this->delCover($model->cover)){
        throw new \Exception('删除封面图片失败');
      }
      if($this->delPics(json_decode($model->pics,true))){
        throw new \Exception('删除图片集失败');
      }
      $trans->commit();
    }catch (\Exception $e){
      Yii::$app->session->setFlash('info',$e->getMessage());
      return $this->redirect(['product/list']);
    }
    Yii::$app->session->setFlash('info','删除成功');
    return $this->redirect(['product/list']);
  }
  //上架处理
  public function actionOn(){
    $product_id = Yii::$app->request->get('product_id');
    Product::updateAll(['is_on'=>1],'product_id = :pid',[':pid'=>$product_id]);
    return $this->redirect(['product/list']);
  }
  //下架处理
  public function actionOff(){
    $product_id = Yii::$app->request->get('product_id');
    Product::updateAll(['is_on'=>0],'product_id = :pid',[':pid'=>$product_id]);
    return $this->redirect(['product/list']);
  }

}