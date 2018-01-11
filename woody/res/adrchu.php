<?php require_once('php/_adr.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php AdrEchoTitle(false); ?></title>
<meta name="description" content="<?php AdrEchoMetaDescription(false); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutAdrTopLeft(false); ?>

<div>
<h1><?php AdrEchoTitle(false); ?></h1>
<?php AdrEchoAll(false); ?>
<p>Related software:
<?php 
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
