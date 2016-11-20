<!-- main container -->
<div class="content">

  <div class="container-fluid">
    <div id="pad-wrapper" class="users-list">
      <div class="row-fluid header">
        <h3>管理员列表</h3>
        <div class="span10 pull-right">

          <a href="<?php echo yii\helpers\Url::to(['manage/reg']); ?>" class="btn-flat success pull-right">
            <span>&#43;</span>
            添加新管理员
          </a>
        </div>
      </div>

      <!-- Users table -->
      <div class="row-fluid table">
        <table class="table table-hover">
          <thead>
          <tr>
            <th class="span2">
              管理员ID
            </th>
            <th class="span2">
              <span class="line"></span>管理员账号
            </th>
            <th class="span2">
              <span class="line"></span>管理员邮箱
            </th>
            <th class="span3">
              <span class="line"></span>最后登录时间
            </th>
            <th class="span3">
              <span class="line"></span>最后登录IP
            </th>
            <th class="span2">
              <span class="line"></span>添加时间
            </th>
            <th class="span2">
              <span class="line"></span>操作
            </th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($managers as $manager): ?>
            <!-- row -->
            <tr>
              <td>
                <?php echo $manager->admin_id; ?>
              </td>
              <td>
                <?php echo $manager->admin_user; ?>
              </td>
              <td>
                <?php echo $manager->admin_email; ?>
              </td>
              <td>
                <?php echo date('Y-m-d H:i:s', $manager->login_time); ?>
              </td>
              <td>
                <?php echo long2ip($manager->login_ip); ?>
              </td>
              <td>
                <?php echo date("Y-m-d H:i:s", $manager->create_time); ?>
              </td>
              <td class="align-right">

                  <a href="<?=yii\helpers\Url::to(['manage/del','admin_id'=>$manager->admin_id]);?>">删除</a>

              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <span style="color:red;">
        <?php
        if (Yii::$app->session->hasFlash('info')) {
          echo Yii::$app->session->getFlash('info');
        }
        ?>
          </span>
      </div>
      <div class="pagination pull-right">
<!--        Ⅵ.通过yii框架组件生成分页标识-->
        <?=yii\widgets\LinkPager::widget(['pagination' => $pager, 'prevPageLabel' => '&#8249;', 'nextPageLabel' => '&#8250;']); ?>
      </div>
      <!-- end users table -->
    </div>
  </div>
</div>
<!-- end main container -->

