<!--⑰样板的基本设置样式，注意需要什么参数，要通过compose()函数来相应传入-->
<p>尊敬的<?=$admin_user?>,您好：</p> <!--显示要找回的管理员名称-->

<p>您的找回密码链接如下：</p>

<!--以下输出内容为：创建绝对路径的访问地址&timestamp=当前时间戳（传参）&admin_user=用户名(传参)&token=签名(传参);实际效果为以下样式：　　　
样式：http://project.com/Yii2/backend/web/index.php?r=manage%2Fmail-change-pass
&timestamp=1478619768&admin_user=admin&token=d456b89cefa0cbb2e4cf11148023d772-->
<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['manage/mail-change-pass','timestamp'=>$time,'admin_user'=>$admin_user,'token'=>$token])?>
<p><a href="<?=$url;?>"><?=$url;?></a></p>

<p>该链接5分钟内有效，请勿传递给别人!</p>

<p>该邮件为系统自动发送，请勿回复!</p>