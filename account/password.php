<?php require_once('php/_password.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEmailPasswordTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_password.php and php/_editemailform.php to change account password.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoEmailPasswordTitle(false); ?></h1>
<?php EchoEmailPassword(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
