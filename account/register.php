<?php require_once('php/_register.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailRegisterTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_register.php and php/_editemailform.php to register a new account.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoEmailRegisterTitle(false); ?></h1>
<p>Welcome! We will NOT send you any email unless it is required by yourself.</p>
<?php EchoEmailRegister(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
