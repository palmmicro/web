<?php require_once('php/_adr.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php AdrEchoTitle(); ?></title>
<meta name="description" content="<?php AdrEchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php AdrEchoTitle(); ?></h1>
<?php AdrEchoAll(); ?>
<p>相关软件:
<?php
    EchoOilSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
