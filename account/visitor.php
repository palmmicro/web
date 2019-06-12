<?php require_once('php/_visitor.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Visitor Data</title>
<meta name="description" content="Visitor data page used to view IP attacks. The detailed user information is still using Google Analytics and Google Adsense.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Visitor Data</h1>
<p>Used to view unusual web crawler IP attacks. The detailed user information is still using Google Analytics and <a href="../woody/blog/entertainment/20110509.php">Google</a> Adsense.</p>
<?php EchoBlogVisitor(false); ?>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
