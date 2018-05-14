<?php require_once('php/_palmmicro.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Forgot Password?</title>
<meta name="description" content="Palmmicro AR1688 and PA1688 password related information, summarized together with Palmmicro web site password." />
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>Forgot Password?</h1>
<p>Sep 9, 2010
<br />There is a login password on <a href="../../../ar1688/index.html">AR1688</a> web interface. We did not pay much attention on the security of AR1688 devices,
and the password was either set as 12345678 or simply left it completely blank. And it is also very easy to hack it in case user forgot, just following the steps below:
</p>
<ol>
  <li><a href="../../../ar1688/software.html">Download</a> an AR1688 software API.</li>
  <li>Extract the compressed file to c:\sdcc.</li>
  <li>Enter command line c:\sdcc\bin.</li>
  <li>Run cmd: "getopt xxx.xxx.xxx.xxx".</li>
  <li>Modify "admin_pin" field (where password is stored) in the options.txt file.</li>
  <li>Run cmd: "setopt xxx.xxx.xxx.xxx".</li>
</ol>
<p>Both getopt.bat and setopt.bat use tftp.exe, make sure your Windows system had it installed.
<br />There are 2 passwords used on <a href="../../../pa1688/index.html">PA1688</a> web interface.
Settings on service provider information is not available if entered with normal password, users need use "super" password to access all web settings.
However, both password can be hacked by <a href="../../../pa1688/software/palmtool.html">PalmTool</a>.exe:
</p>
<ol>
  <li>Set the "IP Address in Chip" and use PalmTool "Phone Settings" to access the device directly. If it can connect, users can simply change those password in the settings dialog.</li>
  <li>When "debug" option is disabled. PalmTool can not be used to access the device. Users will get error information like "Can not connect to Palm1".</li>
  <li>However, debug is always enabled in <a href="../pa6488/20090927.php">safe mode</a>. Users can enter safe mode by press and hold * key and power on twice, 
      then the device will have default IP address 192.168.1.100 (with default MAC as 00-09-45-00-00-00). PalmTool can be used to change both passwords now.</li>
</ol>
<p>What happens if our web site <a href="../../../account/login.php">login</a> password is forgotten? Just visit password <a href="../../../account/reminder.php">reminder</a> page,
a new password will be generated and sent to the registered email address. 
<br />Why generate a new password instead of send the old password back? Because we do not have the password in the database.
What we actually store in database password field is a string encrypted by MD5 based on the password. In theory MD5 cannot be decrypted, this means we can not get original password from the encrypted one.
<br />Finally I have to admit that although this blog is partly enlightened by an AR1688 user who wish to hack the password,
the major purpose is to suggest people <a href="../entertainment/20100905.php">register</a> account on our web site and publish blog comments. This is why it is put in "Palmmicro" category.
</p>
</div>

<?php _LayoutBottom(false); ?>

</body>
</html>
