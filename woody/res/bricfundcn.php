<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>金砖四国基金净值计算工具</title>
<meta name="description" content="计算金砖四国基金的净值, 目前包括信诚四国(SZ165510)和招商金砖(SZ161714). 招商金砖跟标普金砖四国40指数(^SPBRICNTR)比较一致.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>金砖四国基金净值计算工具</h1>
<?php MyStockGroupEchoAll(); ?>
<p>相关软件:
<?php 
    EchoStockCategoryLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
