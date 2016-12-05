<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
class Category extends ActiveRecord{
  public static function tableName()
  {
    return '{{%category}}';
  }
  //指定标签名称
  public function attributeLabels()
  {
    return [
      'parent_id' => '上级分类',
      'title' => '分类名称'
    ];
  }

  public function rules()
  {
    return [
      ['parent_id','required','message'=>'上级分类不能为空','on'=>['add']],
      ['title','required','message'=>'分类名不能为空','on'=>['add']],
      ['title','unique','message'=>'分类名已存在','on'=>['add']],
      //safe 为安全添加验证(说明create_time是安全的)　如果create_time不做验证，就无法写入数据库
      ['create_time','safe']

    ];
  }
  //添加分类的校验
  public function add($data){
    $this->scenario = 'add';
    $data['Category']['create_time']= time();
    if($this->load($data) && $this->save()){
      return true;
    }
    return false;
  }

  //将所有分类信息查询出来  此方法可以通过//$cates = self::find()->asArray()->all();直接获得数据
//  public function getData(){
//    $cates = self::find()->all();
//    $cates = \yii\helpers\ArrayHelper::toArray($cates);
//    return $cates;
//  }

  //将分类信息级别显示 (递归)--通过递归将传入的数据通过pid重组新的数组
  public function getTree($cates,$pid=0){
    //定义一个要返回的数组$tree
    $tree = [];
    //编历数组$cates中的元素
    foreach($cates as $cate){
      //判断$cate中的parent_id的值是不是等于0
      if($cate['parent_id']==$pid){
        //如果是顶级分类则将$cate的数据放入$tree[]中
        $tree[] = $cate;
        //通过递归将当前分类的下级分类查询出来 并与$tree进行合并操作 array_merge(合并数组名，合并的数据)
        $tree = array_merge($tree,$this->getTree($cates,$cate['cate_id']));
        //array_merge()　会重编数组下标
      }
    }
    //通过以上递归完成后组成新的二维数组
    return $tree;
  }

  //定义getPrefix($data)进行添加前缀
  public function setPrefix($data,$p='|---'){
    $tree = [];//设置拼接好后返回的数组
    $num = 0;  //设置分类的层级
    $prefix = [0=>0]; //$prefix如果设置为1则顶级分类会有前缀，如果设置0则顶级分类无前缀
    foreach($data as $key =>$value){ //编历数组　获得$key 和 $value
      if($key > 0){ //从第２次遍历开始判断层级，因为下标为０的层级一定是顶级分类（从前面getTree()可了解）
        if($data[$key-1]['parent_id'] != $value['parent_id'] ){
          $num++; //如果前一个数组的父id不等于当前的父id说明层级改变，需要在层级上增加１级
        }
      }
      if(array_key_exists($value['parent_id'],$prefix)){ //判断当前层级的父级是否有前缀
        $num = $prefix[$value['parent_id']];  //这个层级所拥有的前缀个数
      }
      $value['title'] = str_repeat($p,$num).$value['title'];//将前缀重复层级后进行拼接生成带前缀的标题
      $prefix[$value['parent_id']]= $num; //注：把parent_id对应的级别放入$prefix[]中，重点在此
      $tree[] = $value;                      //意义：为当前层级设定级别，以在array_key_exists中进行判断用
    }
    return $tree;
  }

  //定义getOptions($tree)来返回下拉列表中的分类数据
  public function getOptions($tree){
    $options = ['添加顶级分类'];
    foreach($tree as $cate){
      $options[$cate['cate_id']] = $cate['title'];
    }
    return $options;
  }

}