<?php require_once('php/_closeaccount.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoCloseAccountTitle(); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_closeaccount.php和/account/php/_editemailform.php一起配合完成关闭帐号的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoCloseAccountTitle(); ?></h1>
<p>关闭帐号后, 所有跟此帐号相关的数据都会被删除, 并且不可恢复.</p>
<?php EchoCloseAccount(); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
