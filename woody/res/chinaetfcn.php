<?php require_once('php/_mystockgroup.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A股指数ETF净值计算工具</title>
<meta name="description" content="这个工具箱计算各种中国A股指数ETF的净值, 同时分析比较各种套利对冲方案, 提供交易建议. 包括美股ASHR和多家国内基金公司的A股沪深300指数ETF的配对交易等.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>A股指数ETF净值计算工具</h1>
<p>这个工具箱计算各种中国A股指数ETF的净值, 同时分析比较各种套利对冲方案.  
</p>
<?php EchoAll(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
