<?php require_once('php/_pairtrading.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(false); ?></title>
<meta name="description" content="<?php EchoMetaDescription(false); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutPairTradingTopLeft(false); ?>

<div>
<h1><?php EchoTitle(false); ?></h1>
<?php EchoAll(false); ?>
<p><a href="http://vixandmore.blogspot.com/2009/05/vxx-calculations-vix-futures-and-time.html" target=_blank>VXX Calculations</a>
<br />Related software:
<?php
    EchoSpySoftwareLinks(false);
    EchoQqqSoftwareLinks(false);
    EchoASharesSoftwareLinks(false);
    EchoHSharesSoftwareLinks(false);
    EchoHangSengSoftwareLinks(false);
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
