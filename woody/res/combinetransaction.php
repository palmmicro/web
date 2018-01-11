<?php require_once('php/_combinetransaction.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php CombineTransactionEchoTitle(false); ?></title>
<meta name="description" content="<?php CombineTransactionEchoMetaDescription(false); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php CombineTransactionEchoTitle(false); ?></h1>
<?php CombineTransactionEchoAll(false); ?>
<p>Related software:
<?php 
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
