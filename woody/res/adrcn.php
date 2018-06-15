<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>美股ADR价格比较工具</title>
<meta name="description" content="通过比较中国企业在美国发行的American Depositary Receipt(ADR)的中国A股价格, 港股价格和美股价格, 分析各种套利对冲方案, 提供交易建议.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>美股ADR价格比较工具</h1>
<p>通过比较中国企业在美国发行的American Depositary Receipt(ADR)的中国A股价格, 港股价格和美股价格, 分析各种套利对冲方案, 提供交易建议.  
</p>
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
