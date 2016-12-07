<link rel="stylesheet" href="static/css/compiled/user-list.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">

  <div class="container-fluid">
    <div id="pad-wrapper" class="users-list">
      <div class="row-fluid header">
        <h3>分类列表</h3>
        <div class="span10 pull-right">
          <a href="<?php echo yii\helpers\Url::to(['category/add']) ?>" class="btn-flat success pull-right">
            <span>&#43;</span>
            添加新分类
          </a>
        </div>
      </div>

      <?php
      if (Yii::$app->session->hasFlash('info')) {
        echo Yii::$app->session->getFlash('info');
      }
      ?>
      <!-- Users table -->
      <div class="row-fluid table">
        <table class="table table-hover">
          <thead>
          <tr>
            <th class="span3 sortable">
              <span class="line"></span>分类ID
            </th>
            <th class="span3 sortable">
              <span class="line"></span>分类名称
            </th>
            <th class="span3 sortable align-right">
              <span class="line"></span>操作
            </th>
          </tr>
          </thead>
          <tbody>
          <!-- row -->
          <?php foreach($cates as $cate): ?>
            <?php if($cate['parent_id']==0):?>
            <tr>
              <td>
                <?php echo $cate['cate_id'] ?>
              </td>
              <td onclick="return Collapse(<?=$cate['cate_id'];?>)">
                <span><?php echo $cate['title'] ; ?></span>
                <i class="icon-chevron-down"></i>
              </td>
              <td class="align-right">
                <a href="<?php echo yii\helpers\Url::to(['category/mod', 'cate_id' => $cate['cate_id']]); ?>">编辑</a>
                <a onclick="return confirm('确定要删除吗?')" href="<?php echo yii\helpers\Url::to(['category/del', 'cate_id' => $cate['cate_id']]); ?>">删除</a>
              </td>
            </tr>
            <?php $subcates =$model->getSubTree($cate['cate_id']);?>
              <?php foreach ($subcates as $subcate):?>
                <tr class="<?=$cate['cate_id'];?>" style="display:none">
                  <td><?=$subcate['cate_id'];?></td>
                  <td><?=$subcate['title'];?></td>
                  <td class="align-right">
                  <a href="<?php echo yii\helpers\Url::to(['category/mod', 'cate_id' => $subcate['cate_id']]); ?>">编辑</a>
                  <a onclick="return confirm('确定要删除吗?')" href="<?php echo yii\helpers\Url::to(['category/del', 'cate_id' => $subcate['cate_id']]); ?>">删除</a>
                  </td>
                  </tr>
              <?php endforeach;?>
            <?php endif;?>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="pagination pull-right">
        <?php /*echo yii\widgets\LinkPager::widget([
                        'pagination' => $pager,
                        'prevPageLabel' => '&#8249;',
                        'nextPageLabel' => '&#8250;',
                        ]);*/ ?>
      </div>
      <!-- end users table -->
    </div>
  </div>
</div>
<!-- end main container -->
<script>
  function Collapse(cate_id){
    if($('.'+cate_id).css('display')=='none'){
      $('.'+cate_id).css('display','');
    }else{
      $('.'+cate_id).css('display','none');
    }


  }
</script>