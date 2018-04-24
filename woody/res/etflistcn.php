<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>ETF对照表</title>
<meta name="description" content="配对交易和期货ETF等工具中用到的ETF跟指数对照表, 包括杠杆倍数和校准值快照, 同时提供链接查看具体校准情况.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>ETF对照表</h1>
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
