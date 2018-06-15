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
<p><b>注意这是个主动基金, 选择<?php EchoEstSymbol(); ?>给它估值是实验性质的, 此处估算结果仅供参考. 大家可以根据历史净值比较观察估值的偏离程度.</b></p>
<?php EchoAll(); ?>
<p>相关软件:
<?php
    EchoHangSengSoftwareLinks();
    EchoSouthernSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
