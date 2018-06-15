<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>中国互联网指数基金净值计算工具</title>
<meta name="description" content="计算中国互联网指数基金的净值, 目前包括跟踪中证海外中国互联网指数的中国互联(SZ164906)和跟踪中证海外中国互联网50指数的中概互联(SH513050).">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>中国互联网指数基金净值计算工具</h1>
<?php MyStockGroupEchoAll(); ?>
<p>相关软件:
<?php 
    EchoStockCategoryLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
