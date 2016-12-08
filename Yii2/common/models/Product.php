<?php
namespace common\models;
use yii\db\ActiveRecord;
class Product extends ActiveRecord{
  public $is_on = 0;
  public $is_tui = 0;
  public $is_hot = 0;
  public $is_sale = 0;
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
}