<?php require_once('php/_sma.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Simple Moving Average Tool</title>
<meta name="description" content="Simple Moving Average (SMA) tool. To estimate today's SMA value of different stocks.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Simple Moving Average Tool</h1>
<?php _EchoSmaParagraphs(false); ?>
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
