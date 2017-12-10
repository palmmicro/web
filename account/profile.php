<?php require_once('php/_profile.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Profile</title>
<meta name="description" content="User profile web page. Provide Palmmicro users profile and update links. Together with other activities such as IoT device management.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Profile</h1>
<?php EchoAccountProfile(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
