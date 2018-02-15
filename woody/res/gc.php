<?php require_once('php/_future.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(false); ?></title>
<meta name="description" content="<?php EchoMetaDescription(false); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutFutureTopLeft(false); ?>

<div>
<h1><?php EchoTitle(false); ?></h1>
<?php EchoAll(false); ?>
<p><a href="https://www.hedgewise.com/blog/data/optimal-gold-investment-gld-dgl.php" target=_blank>All Gold Futures</a>
<br />Related software:
<?php
    EchoGoldSoftwareLinks(false);
    EchoCommoditySoftwareLinks(false);
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
