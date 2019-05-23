<?php require_once('php/_adr.php'); ?>
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
    <li>2018年9月3日星期一, 00386分红除权, 导致AH和ADRH对比不准. SNP的分红除权在9月5日, 而SH600028的分红除权在9月12日.</li>
</ol>
<p>相关软件:
<?php
    EchoOilSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
