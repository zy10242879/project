<?php
namespace common\models;
use yii\db\ActiveRecord;
class Product extends ActiveRecord{
  //6.写入七牛类要传递的4个参数，参数获得方法见注册后的七牛网即可
  const AK = 'iT7ov6aykII8uFp0YyAHBgG8LbkUIW2xafO2UrSq';
  const SK = 'gOqjqeKRmOTK36u1ejYmw6NRwuWG3fQI2UyMNYJ9';
  const DOMAIN = 'ohuosrbr4.bkt.clouddn.com';//此处为测试域名　可以绑定自己的域名
  const BUCKET = 'yii2-shop';

  public function attributeLabels()
  {
    return [
      'cate_id'=>'分类名称',
      'title'=>'商品标题',
      'description'=>'商品详细描述',
      'price'=>'商品价格',
      'is_hot'=>'是否热卖',
      'is_sale'=>'是否促销',
      'sale_price'=>'促销价',
      'num'=>'库存量',
      'is_on'=>'是否上架',
      'is_tui'=>'是否推荐',
      'cover'=>'商品封面图片',
      'pics'=>'商品图片集'
    ];
  }
  public static function tableName()
  {
    return '{{%product}}';
  }
  public function rules()
  {
    return [
      ['title', 'required', 'message' => '标题不能为空'],
      ['description', 'required', 'message' => '描述不能为空'],
      ['cate_id', 'required', 'message' => '分类不能为空'],
      ['price', 'required', 'message' => '单价不能为空'],
      [['price','sale_price'], 'number', 'min' => 0.01, 'message' => '价格必须是数字'],
      ['num', 'integer', 'min' => 0, 'message' => '库存必须是数字'],
      ['num', 'required', 'message' => '库存量不能为空'],
      [['is_sale','is_hot','is_on', 'pics', 'is_tui','create_time'],'safe'],
      ['cover', 'required'],
      ['cate_id','validateCateId'],
      ['sale_price','validateSalePrice'],
    ];
  }
  public function validateSalePrice(){
    if(is_null($this->sale_price)){
      $this->addError('sale_price','不能为空');
    }
  }
  public function validateCateId()
  {
    if ($this->cate_id == 0) {
      $this->addError('cate_id', '必需选择分类名称');
    }
  }
  //add()方法进行验证
  public function add($data){
    if($this->load($data) && $this->save()){
      return true;
    }
    return false;
  }
}