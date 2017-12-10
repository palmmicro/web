<?php require_once('php/_spidervisitor.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>网络爬虫接口访问数据</title>
<meta name="description" content="网络爬虫接口访问数据页面. 用于观察该接口的使用情况, 这个特殊接口的访问数据不会体现在Google Analytics和Google Adsense中, 需要定期人工来查看.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>网络爬虫接口访问数据</h1>
<p>用于观察<a href="../woody/blog/entertainment/20170309cn.php">网络爬虫</a>接口的使用情况.</p>
<?php EchoSpiderVisitor(true); ?>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
