<?php require_once('php/_password.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailPasswordTitle(true); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_password.php和/account/php/_editemailform.php一起配合完成修改新帐号密码的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php EchoEmailPasswordTitle(true); ?></h1>
<?php EchoEmailPassword(true); ?>
</div>

<?php LayoutTail(true); ?>

</body>
</html>
