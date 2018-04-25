<?php require_once('php/_calibration.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(false); ?></title>
<meta name="description" content="<?php EchoUrlSymbol(); ?> calibration history page. View, compare and debug the details between stock price calibration.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoTitle(false); ?></h1>
<?php EchoCalibration(false); ?>
<p>Related software:
<?php EchoStockGroupLinks(false); ?>
</p>

</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>

