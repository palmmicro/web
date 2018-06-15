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
<?php EchoAll(); ?>
<p>相关软件:
<?php
    EchoGoldSoftwareLinks();
    EchoCommoditySoftwareLinks();
    EchoHarvestSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
