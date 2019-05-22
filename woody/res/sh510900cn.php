<?php require_once('php/_lofhk.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>


<div>
<h1><?php EchoTitle(); ?></h1>
<?php EchoAll(); ?>
<p><font color=red>已知问题:</font></p>
<ol>
    <li>2018年6月29日星期五, SH510900成立以来首次分红0.05元, 导致当日估值误差4.38%.</li>
</ol>
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
