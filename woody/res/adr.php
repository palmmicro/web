<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Price Compare Tools for ADR</title>
<meta name="description" content="Each of these tools compares the China/Hongkong/US market price of one American Depositary Receipt (ADR) and makes arbitrage analysis.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Price Compare Tools for ADR</h1>
<p>Each of these tools compares the China/Hongkong/US market price of one American Depositary Receipt (ADR) and makes arbitrage analysis.
<?php EchoAdrToolTable(false); ?>
</p>
<?php EchoPromotionHead('adr', false); ?>
<p>Related software:
<?php 
    EchoAHCompareLink(false);
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
