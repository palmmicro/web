<?php require_once('php/_lof.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofTopLeft(); ?>

<div>
<h1><?php EchoTitle(); ?></h1>
<p><b>注意<?php EchoEstSymbol(); ?>和<?php EchoShortName(); ?>跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p>
<?php EchoAll(); ?>
<p><font color=red>已知问题:</font>
</p>
<ol>
    <li>2016-12-22, IXC股息除权, 导致23日全天估值不正常. 这个问题会涉及到所有没有参考指数数据, 而只能使用ETF估值的LOF.</li>
</ol>
<p>
<a href="https://us.spindices.com/indices/equity/sp-global-oil-index" target=_blank>SPGOGUP官网</a>
<br />相关软件:
<?php
    EchoOilSoftwareLinks();
    EchoCommoditySoftwareLinks();
    EchoHuaAnSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
