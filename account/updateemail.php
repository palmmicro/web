<?php require_once('php/_updateemail.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailUpdateTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_updateemail.php and php/_editemailform.php to change a login account email.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoEmailUpdateTitle(false); ?></h1>
<p>Login email is used to contact you, make sure you can receive email from it.</p>
<?php EchoEmailUpdate(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
