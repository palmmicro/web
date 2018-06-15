<?php require_once('php/_reminder.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoPasswordReminderTitle(); ?></title>
<meta name="description" content="本中文页面文件跟/account/php/_reminder.php和/account/php/_editemailform.php一起配合完成生成新密码的功能.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1><?php EchoPasswordReminderTitle(); ?></h1>
<p>新的密码会通过电子邮件发送给你.</p>
<?php EchoPasswordReminder(); ?>
</div>

<?php LayoutTail(); ?>

</body>
</html>
