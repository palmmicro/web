<?php require_once('php/_login.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailLoginTitle(); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_login.php和/account/php/_editemailform.php一起配合完成现有输入帐号登录的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoEmailLoginTitle(); ?></h1>
<p>欢迎回来! 在过去12个月中没有登录过的账户会被自动清除. 你可以<a href="registercn.php">注册</a>新帐号. 忘记密码了? 点击<a href="remindercn.php">这里</a>.</p>
<?php EchoEmailLogin(); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
