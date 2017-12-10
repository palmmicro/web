<?php require_once('php/_editcomment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoEditCommentTitle(true); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_submitcomment.php和/account/php/_editcommentform.php一起配合完成修改网络日志评论的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1><?php EchoEditCommentTitle(true); ?></h1>
<?php EchoEditComment(true); ?>
</div>

<?php LayoutTail(true); ?>

</body>
</html>
