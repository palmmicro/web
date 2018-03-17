<?php require_once('php/_stockhistory.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoUrlSymbol(); ?>历史价格记录页面. 用于查看计算SMA的原始数据, 提供跟Yahoo历史数据同步的功能, 方便人工处理合股和拆股, 分红除权等价格处理问题.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoStockHistory(true); ?>
<p>相关软件:
<?php EchoStockGroupLinks(true); ?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
