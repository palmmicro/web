<?php require_once('php/_lof.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofTopLeft(); ?>

<div>
<h1><?php EchoTitle(); ?></h1>
<p><b>注意<?php EchoEstSymbol(); ?>其实只是<?php EchoShortName(); ?>可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
<?php EchoAll(); ?>
<p>2016年6月28日上市, 根据一个小心愿的观察, 到今天(7月5日)依然是空仓.
<br />相关软件:
<?php
    EchoOilSoftwareLinks();
    EchoCommoditySoftwareLinks();
    EchoSouthernSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
