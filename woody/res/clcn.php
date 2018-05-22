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
<p><font color=red>已知问题:</font>
</p>
<ol>
    <li>2016年3月14日星期一, UWTI合股, 导致全天无法计算CL对应的UWTI价格.</li>
    <li>2016年2月22日星期一, USO和UWTI换仓4月期货后新浪的CL数据没有换, 一直到第二天才正常. 看来是月月如此.</li>
</ol>
<p><a href="http://quote.eastmoney.com/centerv2/qhsc/gjqh/UF_NYMEX_CL" target=_blank>原油期货汇总</a>
<a href="https://www.hedgewise.com/blog/investmentstrategy/the-right-way-to-invest-in-oil.php" target=_blank>原油投资比较</a>
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
