<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>原油基金净值计算工具</title>
<meta name="description" content="计算原油基金的净值, 目前包括南方原油(SH501018), 国泰商品(SZ160216), 嘉实原油(SZ160723)和原油基金(SZ161129). 跟踪原油期货的基金都有因为期货升水带来的损耗, 不能长期持有.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>原油基金净值计算工具</h1>
<p>跟踪原油期货的基金都有因为期货升水带来的损耗, 不能长期持有. 用油气公司行业ETF做长期投资是更好的选择.
</p>
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
