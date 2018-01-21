<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>纳斯达克100基金净值计算工具</title>
<meta name="description" content="计算纳斯达克100基金的净值, 目前包括纳指ETF(SH513100)和纳指100(SZ159941). 使用纳斯达克100指数(^NDX)估值, QQQ仅用于参考.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>纳斯达克100基金净值计算工具</h1>
<p>使用纳斯达克100指数(^NDX)估值, QQQ仅用于参考.</p>
<?php MyStockGroupEchoAll(true); ?>
<p>相关软件:
<?php 
    EchoStockCategoryLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
