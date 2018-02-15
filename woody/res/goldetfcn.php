<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A股黄金ETF净值计算工具</title>
<meta name="description" content="中国A股的交易者普遍不理性, 当A股大跌的时候, 完全不相关的黄金ETF也经常会跟着跌, 这样会产生套利机会. 这个工具箱计算各种黄金ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>A股黄金ETF净值计算工具</h1>
<p>中国A股的交易者普遍不理性, 当A股大跌的时候, 完全不相关的黄金ETF也经常会跟着跌, 这样会产生套利机会. 这个工具箱计算各种黄金ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议.  
<br />类似软件: 集思录<a href="https://www.jisilu.cn/data/etf/#tlink_1" target=_blank>黄金ETF</a>实时投资数据.
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
