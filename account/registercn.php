<?php require_once('php/_register.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailRegisterTitle(); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_register.php和/account/php/_editemailform.php一起配合完成新帐号注册的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoEmailRegisterTitle(); ?></h1>
<p>欢迎注册! 除非你主动要求, 否则我们不会给你发任何邮件.</p>
<?php EchoEmailRegister(); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
