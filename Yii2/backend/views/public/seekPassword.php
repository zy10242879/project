<?php use yii\bootstrap\ActiveForm; //使用form表单组件要先载入该类?>
<?php use yii\helpers\Html; //在视图中要使用submitButton要先载入该类?>
<!DOCTYPE html>
<html class="login-bg">
<head>
  <title>商城 - 后台管理</title>

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
      <h6>商城 - 找回密码</h6>
<!--  ⑭加入判断是否存在'info'信息 有则输出设置的返回结果-->
      <?php if(Yii::$app->session->hasFlash('info')) {
        echo Yii::$app->session->getFlash('info');
      }?>
      <?=$form->field($model,'admin_user')->textInput(['class'=>'span12','placeholder'=>'管理员账号']);?>   <!--此处为Yii 中ActiveForm组件的textInput写法-->
<!--      <input class="span12" type="text" placeholder="管理员账号" />-->
      <?=$form->field($model,'admin_email')->textInput(['class'=>'span12','placeholder'=>'管理员电子邮箱']);?>
      <a href="<?=yii\helpers\Url::to(['public/login'])?>" class="forgot">返回登录</a>

      <?=Html::submitButton('找回密码',['class'=>'btn-glow primary login']);?> <!--这里需要载入helps\Html-->
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