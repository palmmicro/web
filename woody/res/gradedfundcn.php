<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A股分级基金分析工具</title>
<meta name="description" content="中国A股的分级基金是个奇葩设计, 简直就是故意给出套利机会, 让大家来交易增加流动性. 这个工具箱计算各种分级基金的净值, 同时分析比较各种套利对冲方案, 提供交易建议.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>A股分级基金分析工具</h1>
<p>中国A股的分级基金是个奇葩设计, 简直就是故意给出套利机会, 让大家来交易增加流动性. 这个工具箱计算各种分级基金的净值, 同时分析比较各种套利对冲方案, 提供交易建议.  
<br />类似软件: 集思录<a href="http://www.jisilu.cn/data/sfnew/#tlink_3" target=_blank>股票分级</a>和<a href="http://www.jisilu.cn/data/bfjf/#tlink_3" target=_blank>债券分级</a>基金实时投资数据.
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
