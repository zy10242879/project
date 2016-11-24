<!--⑰样板的基本设置样式，注意需要什么参数，要通过compose()函数来相应传入-->
<p>尊敬的用户,您好：</p> <!--显示要找回的管理员名称-->

<p>请牢记您的用户名和密码：</p>

用户名：<?=$user['user_name'];?><br/>

密　码：<?=$user['user_pass'];?><br /><br /><br />

点击链接直接进入到首页登录状态：  ----仅首次登录可用----登录后链接失效----请使用邮箱或用户名登录----
<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['member/mail-login','user_name'=>$user['user_name'],'user_pass'=>md5($user['user_pass']),'create_time'=>$user['create_time'],'user_email'=>$user['user_email'],'token'=>$token])?>
<p><a href="<?=$url;?>"><?=$url;?></a></p>

<p>点击该链接在10分钟内登录生效，并生成用户基本信息，否则用户将失效!</p>

<p>请勿传递给别人，该邮件为系统自动发送，请勿回复!</p>