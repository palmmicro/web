<?php require_once('php/_thanouslaw.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="测试<?php EchoUrlSymbol(); ?>的小心愿定律. 仅用于华宝油气(SZ162411)等LOF基金. 看白天A股华宝油气的溢价或者折价交易是否可以预测晚上美股XOP的涨跌.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoTitle(); ?></h1>
<?php EchoThanousLawTest(); ?>
<p>相关软件:
<?php
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
