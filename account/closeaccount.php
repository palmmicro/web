<?php require_once('php/_closeaccount.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoCloseAccountTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_closeaccount.php and php/_editemailform.php to close an account.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoCloseAccountTitle(false); ?></h1>
<p>After account is closed, all related data is deleted and can not be recovered.</p>
<?php EchoCloseAccount(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
