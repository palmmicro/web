<?php require_once('php/_weixinvisitor.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Wechat Interface Visitor Data</title>
<meta name="description" content="Wechat interface visitor data page, this is not included in Google Analytics and Google Adsense.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Wechat Interface Visitor Data</h1>
<p>Used to view special <a href="../woody/blog/entertainment/20161020.php">Wechat</a> interface visitor data.</p>
<?php EchoWeixinVisitor(false); ?>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
