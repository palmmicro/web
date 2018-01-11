<?php require_once('php/_sma.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>算术移动平均线工具</title>
<meta name="description" content="算术移动平均线(SMA)估算和分析工具. 估算常用股票今天的常用均线值, 分析过去100个交易日中预估的均价落在当天成交范围内的天数. 常用股票可以在登录后定制.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>算术移动平均线(SMA)估算和分析工具</h1>
<?php _EchoSmaParagraphs(true); ?>
<p>相关软件:
<?php
    EchoAHCompareLink(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
