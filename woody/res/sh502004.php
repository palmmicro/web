<?php require_once('php/_gradedfund.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php GradedFundEchoTitle(false); ?></title>
<meta name="description" content="<?php GradedFundEchoMetaDescription(false); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutGradedFundTopLeft(false); ?>

<div>
<h1><?php GradedFundEchoTitle(false); ?></h1>
<?php EchoAll(false); ?>
<p>Related software:
<?php
    EchoMilitarySoftwareLinks(false);
    EchoEFundSoftwareLinks(false);
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
