<!-- main container -->
<div class="content">

  <div class="container-fluid">
    <div id="pad-wrapper" class="users-list">
      <div class="row-fluid header">
        <h3>用户列表</h3>
        <div class="span10 pull-right">

          <a href="<?php echo yii\helpers\Url::to(['user/reg']); ?>" class="btn-flat success pull-right">
            <span>&#43;</span>
            添加新用户
          </a>
        </div>
      </div>
           <!-- Users table -->
      <div class="row-fluid table">
        <table class="table table-hover">
          <thead>
          <tr>
            <th class="span3">
              <span class="line"></span>用户名
            </th>
            <th class="span2">
              <span class="line"></span>真实姓名
            </th>
            <th class="span2">
              <span class="line"></span>昵称
            </th>
            <th class="span2">
              <span class="line"></span>性别
            </th>
            <th class="span2">
              <span class="line"></span>年龄
            </th>
            <th class="span2">
              <span class="line"></span>生日
            </th>
            <th class="span3">
              <span class="line"></span>操作
            </th>
          </tr>
          </thead>
          <tbody>
            <!-- row -->
            <?php foreach($users as $user): ?>
              <tr class="first">
                <td>
                  <?php if (empty($user->profile->avatar)): ?>
                    <img src="<?php echo Yii::$app->params['defaultValues']['avatar']; ?>" class="img-circle avatar hidden-phone" />
                  <?php else: ?>
                    <img src="statics/uploads/avatar/<?php echo $user->profile->avatar; ?>" class="img-circle avatar hidden-phone" />
                  <?php endif; ?>
                  <a href="#" class="name"><?php echo $user->user_name;?></a><br />
                  <span class="subtext"><?php echo $user->user_email; ?></span>
                </td>
              <td>
                <?=isset($user->profile->true_name) ? $user->profile->true_name : '未填写'; ?>
              </td>
              <td>
                <?=isset($user->profile->nick_name) ? $user->profile->nick_name : '未填写'; ?>
              </td>
              <td>
                <?=isset($user->profile->sex) ? $user->profile->sex : '未填写'; ?>
              </td>
              <td>
                <?=isset($user->profile->age) ? $user->profile->age : '未填写'; ?>
              </td>
              <td>
                <?=isset($user->profile->birthday) ? $user->profile->birthday : '未填写'; ?>
              </td>
              <td class="align-right">

                  <a href="<?=yii\helpers\Url::to(['user/del','user_id'=>$user->user_id]);?>" onclick="return confirm('确定要删除吗?')">删除</a>

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

