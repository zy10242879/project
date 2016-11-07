<?php use yii\helpers\Html;
      use yii\helpers\HtmlPurifier;
?>
<!--<h1>--><?php //echo $name;?><!--</h1> 普通载入-->
<!--<h1>--><?//=$info['age'];?><!--</h1> 普通载入-->
<!--<h1>--><?php //echo $sex;?><!--</h1> 普通载入-->

<h1><?php echo Html::encode($sex);?></h1>   <!--将内容转意后载入-->
<h1><?=HtmlPurifier::process($sex);?></h1>  <!--将标签截取掉后载入-->
<?=$this->render('a');?>