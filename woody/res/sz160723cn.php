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
<p><b>注意<?php EchoEstSymbol(); ?>其实只是<?php EchoShortName(); ?>可能跟踪的标的之一, 此处估算结果仅供参考.</b></p>
<?php EchoAll(true); ?>
<p>相关软件:
<?php
    EchoOilSoftwareLinks(true);
    EchoCommoditySoftwareLinks(true);
    EchoHarvestSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
