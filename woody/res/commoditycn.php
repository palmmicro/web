<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>商品基金净值计算工具</title>
<meta name="description" content="计算商品基金的净值, 目前包括大致对应跟踪GSG的信诚商品(SZ165513)和大致对应跟踪DBC的银华通胀(SZ161815). 跟踪商品期货的基金都有因为期货升水带来的损耗, 不能长期持有.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>商品基金净值计算工具</h1>
<p>跟踪商品期货的基金都有因为期货升水带来的损耗, 不能长期持有.</p>
<?php EchoAll(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
