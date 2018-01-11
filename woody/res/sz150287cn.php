<?php require_once('php/_gradedfund.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php GradedFundEchoTitle(true); ?></title>
<meta name="description" content="<?php GradedFundEchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutGradedFundTopLeft(true); ?>

<div>
<h1><?php GradedFundEchoTitle(true); ?></h1>
<?php EchoAll(true); ?>
<p>类似软件: <?php EchoJisiluGradedFund(); ?>
<br />相关软件:
<?php
    EchoASharesSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
