<?php require_once('php/_lofhk.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofHkTopLeft(); ?>


<div>
<h1><?php EchoTitle(); ?></h1>
<?php EchoAll(); ?>
<p><a href="https://www.hkex.com.hk/eng/etfrc/ETFTA/ETFTradingArrangement.htm" target=_blank>港股ETF</a>汇总
<br />相关软件:
<?php
    EchoHSharesSoftwareLinks();
    EchoASharesSoftwareLinks();
    EchoHangSengSoftwareLinks();
    EchoSpySoftwareLinks();
    EchoQqqSoftwareLinks();
    EchoEFundSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
