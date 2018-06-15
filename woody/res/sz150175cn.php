<?php require_once('php/_gradedfund.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php GradedFundEchoTitle(); ?></title>
<meta name="description" content="<?php GradedFundEchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutGradedFundTopLeft(); ?>

<div>
<h1><?php GradedFundEchoTitle(); ?></h1>
<?php EchoAll(); ?>
<p>类似软件: <?php EchoJisiluGradedFund(); ?>
<br />相关软件:
<?php
    EchoHSharesSoftwareLinks();
    EchoHangSengSoftwareLinks();
    EchoASharesSoftwareLinks();
    EchoSpySoftwareLinks();
    EchoYinHuaSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
