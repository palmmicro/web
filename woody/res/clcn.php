<?php require_once('php/_future.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutFutureTopLeft(true); ?>

<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoAll(true); ?>
<p><a href="https://www.hedgewise.com/blog/data/current-cost-oil-contango-uso-usl-dbo.php" target=_blank>原油期货汇总</a>
<br />2016年3月14日星期一, UWTI合股, 导致全天无法计算CL对应的UWTI价格.
<br />2016年2月22日星期一, USO和UWTI换仓4月期货后新浪的CL数据没有换, 一直到第二天才正常. 看来是月月如此.
<br />相关软件:
<?php
    EchoOilSoftwareLinks(true);
    EchoCommoditySoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
