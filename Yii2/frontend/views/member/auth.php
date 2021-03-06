<?php use yii\bootstrap\ActiveForm;
      use yii\helpers\Html;?>
  <!-- ============================================================= HEADER : END ============================================================= -->		<!-- ========================================= MAIN ========================================= -->
  <main id="authentication" class="inner-bottom-md">
    <div class="container">
      <div class="row">

        <div class="col-md-6">
          <section class="section sign-in inner-right-xs">
            <h2 class="bordered">登录</h2>
            <p>欢迎您回来，请您输入您的账户名密码</p>

            <div class="social-auth-buttons">
              <div class="row">
                <div class="col-md-6">
                  <button id='login_qq' class="btn-block btn-lg btn btn-facebook"><i class="fa fa-qq"></i> 使用QQ账号登录</button>
                </div>
                <div class="col-md-6">
                  <button id='login_weibo' class="btn-block btn-lg btn btn-twitter"><i class="fa fa-weibo"></i> 使用新浪微博账号登录</button>
                </div>
              </div>
            </div>
            <?php $form=ActiveForm::begin([
              'options'=>[
                'class'=>'login-form cf-style-1',
                'role'=>'form',
              ],
              'fieldConfig'=>[
                'template'=>'<div class="field-row">{label}{input}</div>{error}'
              ],
            ]);?>
            <?=$form->field($model,'loginName')->textInput(['class'=>'le-input']);?>
            <?=$form->field($model,'user_pass')->passwordInput(['class'=>'le-input']);?>
            <?=$form->field($model,'verifyCode')->widget(\yii\captcha\Captcha::className());?>
<!--            <form role="form" class="login-form cf-style-1">-->
            <!--              <div class="field-row">-->
            <!--                <label>用户名/电子邮箱</label>-->
            <!--                <input type="text" class="le-input">-->
            <!--              </div><!-- /.field-row -->
            <!---->
            <!--              <div class="field-row">-->
            <!--                <label>登录密码</label>-->
            <!--                <input type="text" class="le-input">-->
            <!--              </div><!-- /.field-row -->
            <div class="field-row clearfix">
              <span class="pull-left">
            <?=$form->field($model,'rememberMe')->checkbox([
              'class'=>'le-checbox auto-width inline',
              'template'=>'<label class="content-color">{input}<span class="bold"> 记住我</span></label>',
            ]);?>
              </span>
                <span class="pull-right">
                        		<a href="#" class="content-color bold">忘记密码?</a>

              </div>

              <div class="buttons-holder">
                <?=Html::submitButton('安全登录',['class'=>'le-button huge']);?>
<!--                <button type="submit" class="le-button huge">安全登录</button>-->
              </div><!-- /.buttons-holder -->
<!--            </form><!-- /.cf-style-1 -->
            <?php ActiveForm::end();?>
          </section><!-- /.sign-in -->
        </div><!-- /.col -->

        <div class="col-md-6">
          <section class="section register inner-left-xs">
            <h2 class="bordered">新建账户</h2>
            <p>创建一个属于你自己的账户</p>
            <?=Yii::$app->session->hasFlash('info_reg') ? Yii::$app->session->getFlash('info_reg') : '';?>
            <?php $form = ActiveForm::begin([
              'action'=>['member/reg'],
              'fieldConfig'=>[
                'template'=>'<div class="field-row">{label}{input}</div>{error}'
              ],
              'options'=>[
                'class' => 'register-form cf-style-1',
                'role' => 'form',
              ]
            ])?>
            <?=$form->field($model,'user_email')->textInput(['class'=>'le-input','placeholder'=>'输入邮箱－〉接收邮件－〉点击登录']);?>
<!--            <form role="form" class="register-form cf-style-1">-->
<!--              <div class="field-row">-->
<!--                <label>电子邮箱</label>-->
<!--                <input type="text" class="le-input">-->
<!--              </div><!-- /.field-row -->

              <div class="buttons-holder">
                <?=Html::submitButton('注册',['class'=>'le-button huge']);?>
<!--                <button type="submit" class="le-button huge">注册</button>-->
              </div><!-- /.buttons-holder -->
<!--            </form>-->
            <?php ActiveForm::end();?>
            <h2 class="semi-bold">加入我们您将会享受到前所未有的购物体验 :</h2>

            <ul class="list-unstyled list-benefits">
              <li><i class="fa fa-check primary-color"></i> 快捷的购物体验</li>
              <li><i class="fa fa-check primary-color"></i> 便捷的下单方式</li>
              <li><i class="fa fa-check primary-color"></i> 更加低廉的商品</li>
            </ul>

          </section><!-- /.register -->

        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container -->
  </main><!-- /.authentication -->
  <!-- ========================================= MAIN : END ========================================= -->		<!-- ============================================================= FOOTER ============================================================= -->



<!-- For demo purposes – can be removed on production : End -->
<script>
  var qqbtn =document.getElementById('login_qq');
  qqbtn.onclick = function(){
    window.location.href="<?=yii\helpers\Url::to(['member/qq-login']);?>"
  }
</script>