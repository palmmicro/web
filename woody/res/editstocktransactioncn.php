<?php require_once('php/_stock.php'); ?>
<?php require_once('php/_edittransactionform.php'); ?>
<?php AcctAuth(); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>修改股票交易</title>
<meta name="description" content="本中文页面文件跟/woody/res/php/_submittransaction.php和_edittransactionform.php一起配合完成修改股票交易的功能.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(); ?>

<div>
<h1>修改股票交易</h1>
<?php StockEditTransactionForm(true); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
