<?php require_once('php/_comment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>User Comment</title>
<meta name="description" content="Display all blog comments by user, page link and IP address, with related edit and delete links.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>User Comment</h1>
<?php EchoUserComment(false); ?>
</div>

<?php LayoutTailLogin(false); ?>

</body>
</html>
