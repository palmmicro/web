<?php require_once('php/_ahhistory.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoUrlSymbol(); ?>中国A股和香港H股历史价格比较页面. 按A股交易日期排序显示. 同时显示港币人民币中间价历史, 提供跟Yahoo历史数据同步的功能.">
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
