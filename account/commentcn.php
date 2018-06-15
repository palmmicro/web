<?php require_once('php/_comment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>用户评论</title>
<meta name="description" content="用户评论集中管理页面. 提供分评论人, 评论链接, IP地址等筛选功能分页显示全部评论, 包括满足条件的编辑和删除链接. 原来仅用于网络日志的评论功能现在扩充到了全部PHP写的网页.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>用户评论</h1>
<?php EchoUserComment(); ?>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
