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
<p><font color=red>已知问题:</font></p>
<ol>
    <li>2018年6月22日星期五, SZ159920成立以来首次分红0.076元, 导致当日估值误差超过5%.</li>
</ol>
<p>相关软件:
<?php
    EchoHangSengSoftwareLinks();
    EchoHSharesSoftwareLinks();
    EchoASharesSoftwareLinks();
    EchoSpySoftwareLinks();
    EchoQqqSoftwareLinks();
    EchoChinaAmcSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
