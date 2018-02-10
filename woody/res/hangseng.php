<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Hang Seng Index Fund Net Value Tools</title>
<meta name="description" content="Using ^HSI to estimate the net value of Hang Seng index fund in Chinese market, including SZ159920, SZ160924 and SH513660, 02800 as reference as well."> 
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Hang Seng Index Fund Net Value Tools</h1>
<p>Using ^HSI to estimate and 02800 as reference.
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
