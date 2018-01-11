<?php require_once('php/_stock.php'); ?>
<?php require_once('php/_editreversesplitform.php'); ?>
<?php AcctAuth(); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Stock Reverse Split</title>
<meta name="description" content="This English web page works together with php/_submitreversesplit.php and php/_editreversesplitform.php to do stock reverse split.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Stock Reverse Split</h1>
<?php ReverseSplitEditForm(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
