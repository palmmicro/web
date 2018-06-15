<?php require_once('php/_profile.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>资料</title>
<meta name="description" content="用户资料管理页面. 提供Palmmicro网站用户的资料显示和更新等链接, 以及用户在网站上的其它活动汇总. 例如物联网(IoT)设备管理, 用户评论, 股票设置等.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>资料</h1>
<?php EchoAccountProfile(); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
