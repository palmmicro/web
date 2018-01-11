<?php require_once('php/_stock.php'); ?>
<?php require_once('php/_editgroupform.php'); ?>
<?php AcctAuth(); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Update Stock Group</title>
<meta name="description" content="This English web page works together with php/_submitgroup.php and php/_editgroupform.php to update a stock group.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Update Stock Group</h1>
<?php StockEditGroupForm(STOCK_GROUP_EDIT, false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
