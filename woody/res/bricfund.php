<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>BRIC Fund Net Value Tools</title>
<meta name="description" content="Estimate the net value of BRIC fund in Chinese market, including SZ165510 and SZ161714.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>BRIC Fund Net Value Tools</h1>
<p>
<?php EchoBricFundToolTable(false); ?>
</p>
<?php EchoPromotionHead('', false); ?>
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
