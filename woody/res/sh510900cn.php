<?php require_once('php/_lofhk.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofHkTopLeft(true); ?>


<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoAll(true); ?>
<p><a href="https://www.hkex.com.hk/eng/etfrc/ETFTA/ETFTradingArrangement.htm" target=_blank>港股ETF</a>汇总
<br />相关软件:
<?php
    EchoHSharesSoftwareLinks(true);
    EchoASharesSoftwareLinks(true);
    EchoHangSengSoftwareLinks(true);
    EchoSpySoftwareLinks(true);
    EchoQqqSoftwareLinks(true);
    EchoEFundSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
