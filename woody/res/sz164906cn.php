<?php require_once('php/_lof.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofTopLeft(); ?>

<div>
<h1><?php EchoTitle(); ?></h1>
<p><b>注意<?php EchoEstSymbol(); ?>和<?php EchoShortName(); ?>跟踪的指数可能不同, 此处估算结果仅供参考.</b></p>
<?php EchoAll(); ?>
<p><a href="https://xueqiu.com/6827215131/68185067" target=_blank>中证海外中国互联网指数</a> <a href="https://xueqiu.com/6827215131/80361226" target=_blank>中国互联VS中国互联50</a>
<br />相关软件: 
<?php
    EchoChinaInternetSoftwareLinks();
    EchoSpySoftwareLinks();
    EchoASharesSoftwareLinks();
    EchoBocomSchroderSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
