<?php require_once('php/_combinetransaction.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php CombineTransactionEchoTitle(); ?></title>
<meta name="description" content="<?php CombineTransactionEchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php CombineTransactionEchoTitle(); ?></h1>
<?php CombineTransactionEchoAll(); ?>
<p>相关软件:
<?php
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
