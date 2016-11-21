<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<link rel="stylesheet" href="assets/admin/css/compiled/new-user.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">

  <div class="container-fluid">
    <div id="pad-wrapper" class="new-user">
      <div class="row-fluid header">
        <h3>修改管理员邮箱</h3>
      </div>

      <div class="row-fluid form-wrapper">
        <!-- left column -->
        <div class="span9 with-sidebar">
          <div class="container">
            <?php if(Yii::$app->session->hasFlash('info')){
              echo '<span style="color:red;font-size:16px">'.Yii::$app->session->getFlash('info').'</span>';
            }; ?>
            <?php $form = ActiveForm::begin([
              'options'=>['class'=>'new_user_form inline-input'],
              'fieldConfig'=>[
                'template' => '<div class="span12 field-box">{label}{error}{input}</div>',
                'errorOptions' => ['style'=>'color:red'],
              ]
            ]);?>
            <?=$form->field($model,'admin_user')->textInput(['class'=>'span9','disabled'=>true]);?>
            <?=$form->field($model,'admin_pass')->passwordInput(['class'=>'span9'])->label('请输入登录密码')->error(['admin_pass'=>123]);?>
            <?=$form->field($model,'admin_email')->textInput(['class'=>'span9'])->label('修改电子邮箱地址');?>
            <div class="span11 field-box actions">
              <?=Html::submitButton('创建',['class'=>'btn-glow primary'])?>
              <span>或者</span>
              <?=Html::resetButton('重置',['class'=>'reset'])?>
            </div>
            <?php $form=ActiveForm::end();?>
          </div>
        </div>

        <!-- side right column -->
        <div class="span3 form-sidebar pull-right">

          <div class="alert alert-info hidden-tablet">
            <i class="icon-lightbulb pull-left"></i>
            请在左侧填写管理员相关信息，包括管理员电子邮箱，以及密码
          </div>
          <h6>重要提示：</h6>
          <p>管理员输入正确密码才可以修改电子邮箱地址</p>
          <p>请谨慎修改</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- end main container -->
