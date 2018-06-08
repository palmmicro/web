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
<p><b>注意<?php EchoEstSymbol(); ?>和<?php EchoShortName(); ?>跟踪的指数可能不同, 此处估算结果仅供参考.</b></p>
<?php EchoAll(true); ?>
<p><a href="https://xueqiu.com/6827215131/80361226" target=_blank>中国互联VS中国互联50</a>
<br />相关软件: 
<?php
    EchoChinaInternetSoftwareLinks(true);
    EchoSpySoftwareLinks(true);
    EchoASharesSoftwareLinks(true);
    EchoEFundSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
