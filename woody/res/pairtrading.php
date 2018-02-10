<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Pair Trading Analysis Tools</title>
<meta name="description" content="When the arbitrage between SZ162411 and XOP can not continue, I begin to test the pair trading of XOP and USO/USL, and begin this new analysis tools.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Pair Trading Analysis Tools</h1>
<p>When the arbitrage between <a href="sz162411.php">SZ162411</a> and XOP can not continue, I begin to test the pair trading of XOP and USO/USL, and begin this new analysis tools.
</p>
<?php MyStockGroupEchoAll(false); ?>
<p>Related software:
<?php 
    EchoStockCategoryLinks(false);
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
