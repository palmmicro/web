<?php require_once('php/_lof.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofTopLeft(true); ?>

<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoAll(true); ?>
<p>
<font color=red>已知问题:
    <ol>
        <li>2016年12月21日星期三, CL期货换月, 因为CL和USO要等当晚美股开盘才会自动校准, 白天按照CL估算的实时净值不准.
        <li>2016年12月17日星期五, XOP季度分红除权, 这里显示的涨跌幅跟Yahoo不一致, Yahoo好像已经把昨天的收盘价减掉分红的0.08美元了. 新浪跟Yahoo显示一致, 雪球比较离谱, 显示的涨跌是减掉了0.15美元的.
    </ol>
</font>
<br /><a href="https://xueqiu.com/2244868365/60702370" target=_blank>华宝油气和XOP套利交易Q&A</a>
<a href="https://xueqiu.com/2244868365/81340659" target=_blank>一种根据XOP均线进行华宝油气和XOP联动交易的方法</a>
<br />相关软件: 
<?php
    EchoOilSoftwareLinks(true);
    EchoCommoditySoftwareLinks(true);
    EchoFortuneSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
