<?php require_once('php/_editstockoption.php'); ?>
<?php SetStockOptionType(STOCK_OPTION_EDIT_CN); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php EchoHeadLine(); ?></h1>
<?php EchoAll(); ?>
</div>

<?php LayoutTail(true); ?>

</body>
</html>
