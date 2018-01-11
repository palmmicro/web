<?php require_once('php/_mystock.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoMyStockTitle(false); ?></title>
<meta name="description" content="Display the stock reference data, AH compare, SMA, Bollinger Bands and net value estimation.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoMyStockTitle(false); ?></h1>
<?php EchoMyStock(false); ?>
<p>Related software:
<?php
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
