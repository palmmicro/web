<?php require_once('php/_weixinvisitor.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>微信接口访问数据</title>
<meta name="description" content="微信接口访问数据页面. 用于观察该接口的使用情况, 这个特殊接口的访问数据不会体现在Google Analytics和Google Adsense中, 需要定期人工来查看.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>微信接口访问数据</h1>
<p>用于观察<a href="../woody/blog/palmmicro/20161014cn.php">微信公众号</a>接口的使用情况.</p>
<?php EchoWeixinVisitor(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
