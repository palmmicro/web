<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>ETF对照表</title>
<meta name="description" content="各个工具中用到的ETF跟指数对照表, 包括杠杆倍数和校准值快照, 同时提供链接查看具体校准情况. 有些指数不容易拿到数据, 就用1倍ETF代替指数给其它杠杆ETF做对照.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>ETF对照表</h1>
<p>有些指数不容易拿到数据, 就用1倍ETF代替指数给其它杠杆ETF做对照.</p>
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
