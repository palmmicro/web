<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php MyStockGroupEchoTitle(); ?></title>
<meta name="description" content="<?php MyStockGroupEchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php MyStockGroupEchoTitle(); ?></h1>
<?php MyStockGroupEchoAll(); ?>
<p>相关软件:
<?php
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
