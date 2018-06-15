<?php require_once('php/_ip.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>IP地址数据</title>
<meta name="description" content="IP地址数据查询页面. 从新浪, 淘宝和ipinfo.io等网站查询IP地址对应的国家, 城市和公司等信息. 同时也从palmmicro.com的用户登录和评论中提取对应记录.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>IP地址数据</h1>
<?php EchoCheckIp(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
