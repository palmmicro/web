<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A股香港LOF基金净值计算工具</title>
<meta name="description" content="这个工具箱计算A股市场中各种香港LOF的净值. 直接导致把香港LOF从其它LOF页面分出来的原因是新基金华宝兴业香港中国中小盘QDII-LOF(SH501021)居然只有指数而没有对应的港股ETF, 只好用指数给所有港股LOF估值了.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>A股香港LOF基金净值计算工具</h1>
<p>计算中国A股市场中各种香港LOF的净值.
<br />类似软件: 集思录<a href="https://www.jisilu.cn/data/lof/#index" target=_blank>指数LOF</a>基金实时投资数据.
</p>
<?php EchoAll(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
