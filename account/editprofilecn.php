<?php require_once('php/_editprofile.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEditProfileTitle(); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_submitprofile.php和/account/php/_editprofileform.php一起配合完成修改帐号资料的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoEditProfileTitle(); ?></h1>
<?php EchoEditProfile(); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
