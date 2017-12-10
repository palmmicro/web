<?php require_once('php/_login.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailLoginTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_login.php and php/_editemailform.php to login an existing account.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoEmailLoginTitle(false); ?></h1>
<p>Welcome back! Account not login during the past 12 months is automatically removed. You can <a href="register.php">register</a> here. Forgot password? Click <a href="reminder.php">here</a>.</p>
<?php EchoEmailLogin(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
