<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>标准第一</title>
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
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
<td width=780 height=105 align=left valign=top><a href="/woody/"><img src=../../image/image.jpg alt="Woody Home Page" /></a></td>
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
<tr><td class=THead><B>标准第一</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年8月11日</td></tr>
<tr><td>我们终于用RFC 3164 syslog代替了<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a> UDP调试. 我们用了很多年才理解开放标准的重要性. 从现在<a href="../../../ar1688/indexcn.html">AR1688</a>的0.37版软件开始, <a href="20070609cn.php">UDP调试功能</a>及其选项被完全放弃. Syslog IP选项设置成"0.0.0.0"时可以关闭syslog功能, 设置成"255.255.255.255"采用广播包发送调试信息, 它也可以设置成一个标准的IP地址. 
<br />在<a href="20080624cn.php">安全模式</a>下, syslog IP地址被强制为255.255.255.255, 以便容易捕获调试信息. 
<br />类似UdpDebugString()的函数仍然在<a href="20061211cn.php">API</a>中, 只是从现在开始它们改为调用Syslog()函数. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
