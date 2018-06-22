<?php require_once('php/_navclosehistory.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoUrlSymbol(); ?>净值和收盘价历史比较页面. 观察每天净值和收盘价偏离的情况. 同时判断偏离是否跟当天涨跌相关, 总结规律以便提供可能的套利操作建议.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoTitle(); ?></h1>
<?php EchoAll(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
