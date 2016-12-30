<?php
namespace frontend\controllers;
use Yii;
use common\models\Product;
class SearchController extends CommonController {
  //关键字搜索
  public function actionSearchKeys(){
    $this->layout = 'layout_frontend';
    if(Yii::$app->request->isPost){
      $post = Yii::$app->request->post();
      if(!empty($post['search'])){
        //载入sphinx
        require '../web/sphinxapi.php';
        //实例化对象
        $sph = new \SphinxClient();
        //连接服务器
        $sph->SetServer('192.168.1.58',9312);
        //查询内容 第一个参数为查询的内容　第二个参数为查询的数据源（可以省略，省略后为全部数据源查询）
        $res = $sph->Query($post['search'],'product');
        //sphinx取出的只是建立主索引的id字段的id值
        if(isset($res['matches'])){
        //先通过array_keys()获得id
          $keys =array_keys($res['matches']);
          $data = [];
          foreach ($keys as $k=>$key){
            $data[$k] = Product::getProduct($key);
          }
          //sphinx查找到结果时载入结果页
          return $this->render('index',['data'=>$data]);
        }else{
          //未搜索到结果时返回未找到
          return $this->render('index',['data'=>'']);
        }
      }
    }
    //未填数据点击提交时跳转到首页
    $this->redirect(['index/index']);
  }
}