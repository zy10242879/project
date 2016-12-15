<?php use yii\bootstrap\ActiveForm;
      use yii\helpers\Html;?>
  <!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= MAIN ========================================= -->
  <main id="authentication" class="inner-bottom-md">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          <section class="section sign-in inner-right-xs">
            <h2 class="bordered">
              <img src="<?=Yii::$app->session['userInfo']['figureurl_qq_1'];?>">
              完善您的信息<span style="font-size: 18px;">--<?=Yii::$app->session['userInfo']['nickname'];?></span>
            </h2>
            <p>请填写用户名和密码</p>


            <?php $form=ActiveForm::begin([
              'options'=>[
                'class'=>'login-form cf-style-1',
                'role'=>'form',
              ],
              'fieldConfig'=>[
                'template'=>'<div class="field-row">{label}{input}</div>{error}'
              ],
            ]);?>
            <?=$form->field($model,'user_name')->textInput(['class'=>'le-input']);?>
            <?=$form->field($model,'user_pass')->passwordInput(['class'=>'le-input']);?>
            <?=$form->field($model,'rePass')->passwordInput(['class'=>'le-input']);?>
            <div class="field-row clearfix">
            </div>

            <div class="buttons-holder">
              <?php echo Html::submitButton('完善信息', ['class' => 'le-button huge']); ?>
            </div><!-- /.buttons-holder -->

            <?php ActiveForm::end(); ?><!-- /.cf-style-1 -->

          </section><!-- /.sign-in -->
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container -->
  </main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->
<script>
  var qqbtn = document.getElementById("login_qq");
  qqbtn.onclick = function(){
    window.location.href="<?php echo yii\helpers\Url::to(['member/qqlogin']) ?>";
  }
</script>