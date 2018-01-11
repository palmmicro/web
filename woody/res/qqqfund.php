<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>NASDAQ-100 Fund Net Value Tools</title>
<meta name="description" content="Estimate the net value of NASDAQ-100 fund in Chinese market, including SH513100 and SZ159941.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>NASDAQ-100 Fund Net Value Tools</h1>
<p>
<?php EchoQqqFundToolTable(false); ?>
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
