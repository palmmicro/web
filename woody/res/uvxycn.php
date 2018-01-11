<?php require_once('php/_pairtrading.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutPairTradingTopLeft(true); ?>

<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoAll(true); ?>
<p><a href="https://xueqiu.com/3160146151/55934994" target=_blank>VXX和UVXY常识</a>
<a href="http://vixandmore.blogspot.com/2009/05/vxx-calculations-vix-futures-and-time.html" target=_blank>VXX计算</a>
<br />相关软件:
<?php
    EchoSpySoftwareLinks(true);
    EchoQqqSoftwareLinks(true);
    EchoASharesSoftwareLinks(true);
    EchoHSharesSoftwareLinks(true);
    EchoHangSengSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
