<?php require_once('php/_editprofile.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEditProfileTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_submitprofile.php and php/_editprofileform.php to update a profile.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoEditProfileTitle(false); ?></h1>
<?php EchoEditProfile(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>

