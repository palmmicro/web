<?php require_once('php/_stock.php'); ?>
<?php require_once('php/_edittransactionform.php'); ?>
<?php AcctAuth(); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Update Stock Transaction</title>
<meta name="description" content="This page works together with php/_submittransaction.php and php/_edittransactionform.php to update a stock transaction.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>Update Stock Transaction</h1>
<?php StockEditTransactionForm(); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
