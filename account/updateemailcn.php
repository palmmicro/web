<?php require_once('php/_updateemail.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailUpdateTitle(true); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_updateemail.php和/account/php/_editemailform.php一起配合完成修改帐号的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php EchoEmailUpdateTitle(true); ?></h1>
<p>我们通过登录电子邮件联系你, 务必确认你能收到这个地址的电子邮件.</p>
<?php EchoEmailUpdate(true); ?>
</div>

<?php LayoutTail(true); ?>

</body>
</html>
