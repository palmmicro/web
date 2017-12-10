<?php require_once('php/_ip.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>IP Address Data</title>
<meta name="description" content="IP address data page, using country, city and company information from Sina, Taobao and ipinfo.io.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>IP Address Data</h1>
<?php EchoCheckIp(false); ?>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
