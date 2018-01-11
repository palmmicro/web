<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>美股期货类ETF价格计算工具</title>
<meta name="description" content="根据期货价格计算美股市场上对应做多, 2倍做多, 3倍做多, 做空, 2倍做空, 3倍做空等ETF在关键点位上的价格, 分析摩擦损耗和期货的升水贴水, 提供交易建议.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>美股期货类ETF价格计算工具</h1>
<p>根据期货价格计算美股市场上对应做多, 2倍做多, 3倍做多, 做空, 2倍做空, 3倍做空等ETF在关键点位上的价格, 分析摩擦损耗和期货的升水贴水, 提供交易建议.
<?php EchoFutureToolTable(true); ?>
</p>
<?php EchoPromotionHead('future', true); ?>
<p>相关软件:
<?php EchoStockGroupLinks(true); ?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
