<?php require_once('php/_reminder.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoPasswordReminderTitle(false); ?></title>
<meta name="description" content="This English web page works together with php/_reminder.php and php/_editemailform.php to reset password.">
<link href="/common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1><?php EchoPasswordReminderTitle(false); ?></h1>
<p>New password will be sent by email.</p>
<?php EchoPasswordReminder(false); ?>
</div>

<?php LayoutTail(false); ?>

</body>
</html>
