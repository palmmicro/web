<?php require_once('php/_editcomment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEditCommentTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_submitcomment.php and php/_editcommentform.php to update a blog comment.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoEditCommentTitle(false); ?></h1>
<?php EchoEditComment(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>

