<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Future ETF Price Tools</title>
<meta name="description" content="Each of these tools calculates the 1x, 2x, 3x, -1x, -2x and -3x future related ETF prices.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Future ETF Price Tools</h1>
<p>Each of these tools calculates the 1x, 2x, 3x, -1x, -2x and -3x future related ETF prices.
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
