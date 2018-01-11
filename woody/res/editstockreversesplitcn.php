<?php require_once('php/_stock.php'); ?>
<?php require_once('php/_editreversesplitform.php'); ?>
<?php AcctAuth(); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>股票合股</title>
<meta name="description" content="本中文页面文件跟/woody/res/php/_submitreversesplit.php和/woody/res/php/_editreversesplitform.php一起配合完成股票合股的功能.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>股票合股</h1>
<?php ReverseSplitEditForm(true); ?>
</div>

<?php LayoutTail(true); ?>

</body>
</html>
