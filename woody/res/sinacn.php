<?php require_once('php/_pairtrading.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutPairTradingTopLeft(true); ?>

<div>
<h1><?php EchoTitle(true); ?></h1>
<p>SINA持有的差不多一半的WB股份, 持有WB市值比它本身市值还大. 同时SINA拥有WB的2/3以上投票权, 可以在未来维持每年每10股SINA特别分红1股WB, 促使均值回归. 
总体来说空WB多SINA也许是个不错的策略, 但是市场无情, 从2017年初到现在做这个的坟头草已经几人高了.</p>
<?php EchoAll(true); ?>
<p>相关软件:
<?php
    EchoSpySoftwareLinks(true);
    EchoASharesSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
