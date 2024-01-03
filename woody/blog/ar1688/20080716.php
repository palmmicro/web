<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Default Settings</title>
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="ar1688.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateAr1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>Default Settings</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>July 16, 2008</td></tr>
<tr><td><a href="../../../ar1688/index.html">AR1688</a> device settings are stored in program flash address space 0x10000-0x13fff. And factory default settings are stored in address 0x14000-0x17fff. Software API file SDCC\include\ar168.h is a good start point to know more detail mapping of those settings. The .txt files in SDCC\src\settings are used to build different factory settings for different manufacturers and OEMs, change of those files will not affect upgrade binary files. Actually, it should be always to avoid change settings or default settings by upgrade software.
<br />Many Asterisk system builders like to have their own default settings in those IP phones. The best way is to give a sample .txt settings file to IP phone manufacturers, we can help to put those setting values into the proper space before manufacture process. For existing IP phones, there are 3 ways to change default settings:
<br />1. In <a href="20080624.php">safe mode</a>, use #5*1 to store current settings as default settings. Check SDCC\doc\key_test.txt for details
<br />2. In normal mode, use Menu->Phone Settings->Store Defaults to save current settings as default settings
<br />3. For programmers, use <a href="20061211.php">API</a> functions UI_StoreDefaults() and UI_LoadDefaults() to save current settings as default settings
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
