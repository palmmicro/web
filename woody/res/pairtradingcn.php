<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>配对交易分析工具</title>
<meta name="description" content="华宝油气持续溢价, 跟XOP的对冲没法做了. 开始琢磨用USO或者USL两个原油ETF跟XOP做配对交易, 导致了这个工具系列的产生. 主要是用来精确记录成本, 保证配对交易能够持续赚钱而不是稀里糊涂的亏掉了.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>配对交易分析工具</h1>
<p><a href="sz162411cn.php">华宝油气</a>持续溢价, 跟XOP的对冲没法做了. 开始琢磨用USO或者USL两个原油ETF跟XOP做配对交易, 导致了这个工具系列的产生. 主要是用来精确记录成本, 保证配对交易能够持续赚钱而不是稀里糊涂的亏掉了.  
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
