<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Commodity Fund Net Value Tools</title>
<meta name="description" content="Estimate the net value of commodity fund in Chinese market, including DBC related SZ161815 and GSG related SZ165513.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Commodity Fund Net Value Tools</h1>
<p>
<?php EchoCommodityToolTable(false); ?>
</p>
<?php EchoPromotionHead('', false); ?>
<p>Related software:
<?php 
    EchoStockCategoryLinks(false);
    EchoStockGroupLinks(false);
?>
<?php EchoStockGroupLinks(false); ?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
