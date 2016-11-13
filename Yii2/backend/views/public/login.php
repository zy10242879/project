<?php use yii\bootstrap\ActiveForm; //使用form表单组件要先载入该类?>
<?php use yii\helpers\Html; //在视图中要使用submitButton要先载入该类?>
<!DOCTYPE html>
<html class="login-bg">
<head>
  <title>慕课商城 - 后台管理</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- bootstrap -->
  <link href="statics/css/bootstrap/bootstrap.css" rel="stylesheet" />
  <link href="statics/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
  <link href="statics/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

  <!-- global styles -->
  <link rel="stylesheet" type="text/css" href="statics/css/layout.css" />
  <link rel="stylesheet" type="text/css" href="statics/css/elements.css" />
  <link rel="stylesheet" type="text/css" href="statics/css/icons.css" />

  <!-- libraries -->
  <link rel="stylesheet" type="text/css" href="statics/css/lib/font-awesome.css" />

  <!-- this page specific styles -->
  <link rel="stylesheet" href="statics/css/compiled/signin.css" type="text/css" media="screen" />

  <!-- open sans font -->


  <!--[if lt IE 9]>
  <script src=""></script>
  <![endif]-->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


<div class="row-fluid login-wrapper">
  <a class="brand" href="index.html"></a>
  <?php $form =ActiveForm::begin([  //begin中加入的参数是个数组
    //此处加入fieldConfig是字段的配置　为的是去掉label标签中的admin user 和 admin pass
    'fieldConfig' => [    //-----14.在此处{input}前或后加入{error}-----
      'template' => '{input}{error}', //此处为针对每一个input属性不加label标签
    ],
  ]);?>
  <div class="span4 box">
    <div class="content-wrap">
      <h6>商城 - 后台管理</h6>
      <?=$form->field($model,'admin_user')->textInput(['class'=>'span12','placeholder'=>'管理员账号']);?>   <!--此处为Yii 中ActiveForm组件的textInput写法-->
<!--      <input class="span12" type="text" placeholder="管理员账号" />-->
      <?=$form->field($model,'admin_pass')->passwordInput(['class'=>'span12','placeholder'=>'管理员密码']);?><!--此处为Yii 中ActiveForm组件的passwordInput写法-->
<!--      <input class="span12" type="password" placeholder="管理员密码" />-->
      <a href="#" class="forgot">忘记密码?</a>
      <?=$form->field($model,'rememberMe')->checkbox([
        'id' => 'remember-me',
        //template是Yii框架带的属性，叫做模板，可以将标签直接写入
        'template'=> '<div class="remember">{input}<label for="remember-me">记住我</label></div>'
      ]);?>
<!--      <div class="remember">-->
<!--        <input id="remember-me" type="checkbox" />-->
<!--        <label for="remember-me">记住我</label>-->
<!--      </div>-->
      <?=Html::submitButton('登录',['class'=>'btn-glow primary login']);?> <!--这里需要载入helps\Html-->
<!--      <a class="btn-glow primary login" href="#">登录</a>-->
    </div>
  </div>
  <?php ActiveForm::end();?>
</div>

<!-- scripts -->
<script src="statics/js/jquery-latest.js"></script>
<script src="statics/js/bootstrap.min.js"></script>
<script src="statics/js/theme.js"></script>

<!-- pre load bg imgs -->
<script type="text/javascript">
  $(function () {
    // bg switcher
    var $btns = $(".bg-switch .bg");
    $btns.click(function (e) {
      e.preventDefault();
      $btns.removeClass("active");
      $(this).addClass("active");
      var bg = $(this).data("img");

      $("html").css("background-image", "url('img/bgs/" + bg + "')");
    });

  });
</script>

</body>
</html>