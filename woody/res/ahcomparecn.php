<?php require_once('php/_ahcompare.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AH股价格比较工具</title>
<meta name="description" content="中国A股和香港H股全面价格比较工具, 按A股股票代码排序. 主要显示H股交易情况, 同时计算AH价格比和HA价格比. H股是指获中国证监会批核到香港上市的国有企业, 也称国企股.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>AH股价格比较工具</h1>
<p>类似软件:
集思录<a href="https://www.jisilu.cn/data/ha/" target=_blank>A/H比价</a>
同花顺<a href="http://data.10jqka.com.cn/market/ahgbj/" target=_blank>AH股比价</a>
</p>
<?php _EchoCompareAH(true); ?>
<p>相关软件:
<?php
    EchoSmaLink(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
