<?php require_once('php/_thanouslaw.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(false); ?></title>
<meta name="description" content="Test Thanous Law for <?php EchoUrlSymbol(); ?>. For LOF like SZ162411 only, check if SZ162411 trading in day time can predict XOP trading in the night.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoTitle(false); ?></h1>
<?php EchoThanousLawTest(false); ?>
<p>Related software:
<?php 
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
