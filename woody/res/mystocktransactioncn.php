<?php require_once('php/_mystocktransaction.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php MyStockTransactionEchoTitle(true); ?></title>
<meta name="description" content="<?php MyStockTransactionEchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php MyStockTransactionEchoTitle(true); ?></h1>
<?php MyStockTransactionEchoAll(true); ?>
<p>相关软件:
<?php
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
