<?php require_once('php/_calibration.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoUrlSymbol(); ?>校准历史记录页面. 用于查看, 比较和调试估算的股票价格或者基金净值之间的校准情况. 最新的校准时间一般会直接显示在该股票或者基金的页面.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoCalibration(true); ?>
<p>相关软件:
<?php EchoStockGroupLinks(true); ?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
