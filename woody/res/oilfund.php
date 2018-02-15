<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Oil Fund Net Value Tools</title>
<meta name="description" content="Estimate the net value of oil fund in Chinese market, including SH501018, SZ160216, SZ160723 and SZ161129.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Oil Fund Net Value Tools</h1>
<p>Investors should avoid to hold oil future related fund for a long period. Oil company ETF is a better way for long term investment.
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
