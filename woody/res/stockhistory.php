<?php require_once('php/_stockhistory.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(false); ?></title>
<meta name="description" content="<?php EchoUrlSymbol(); ?> stock history page. View the data to calculate SMA here, with functions to get Yahoo stock history data.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoTitle(false); ?></h1>
<?php EchoStockHistory(false); ?>
<p>Related software:
<?php EchoStockGroupLinks(false); ?>
</p>

</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>

