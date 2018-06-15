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
<p><b><?php EchoShortName(); ?>大致对应跟踪<?php EchoEstSymbol(); ?>, 此处估算结果仅供参考.</b></p>
<?php EchoAll(); ?>
<p><a href="https://xueqiu.com/4206051491/69865145" target=_blank>DBC和GSG的区别</a>
<br />相关软件:
<?php
    EchoCommoditySoftwareLinks();
    EchoOilSoftwareLinks();
    EchoGoldSoftwareLinks();
    EchoCiticPruSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
