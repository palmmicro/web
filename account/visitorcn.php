<?php require_once('php/_visitor.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>用户访问数据</title>
<meta name="description" content="用户访问数据页面. 用于观察IP攻击的异常状况, 用户登录后会自动清除该IP之前的记录. 具体的用户统计工作还是由Google Analytics和Google Adsense完成.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>用户访问数据</h1>
<p>用于观察<a href="../woody/blog/entertainment/20170309cn.php">网络爬虫</a>IP攻击的异常状况, 会定期在满足一定条件如用户登录后自动清除该IP之前的记录.
具体的用户统计工作还是由Google Analytics和<a href="../woody/blog/entertainment/20110509cn.php">Google Adsense</a>完成.</p>
<?php EchoBlogVisitor(true); ?>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
