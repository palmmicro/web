<?php require_once('php/_myportfolio.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>My Portfolio</title>
<meta name="description" content="My portfolio management, providing overall cost information of single stock, stock group and the whole investment.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>My Portfolio</h1>
<?php EchoMyFortfolio(false); ?>
<p>Related software:
<?php 
    EchoStockGroupLinks(false);
?>
</p>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
