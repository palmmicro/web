<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>H股基金净值计算工具</title>
<meta name="description" content="计算H股基金的净值, 目前包括H股ETF(SH510900)和恒生H股(SZ160717).使用恒生中国企业指数(^HSCE)估值, 恒生H股ETF(02828)仅用于参考.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>H股基金净值计算工具</h1>
<p>使用恒生中国企业指数(^HSCE)估值, 恒生H股ETF(02828)仅用于参考.
</p>
<?php EchoAll(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
