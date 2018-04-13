<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Standard First</title>
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
<tr><td class=THead><B>Standard First</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 11, 2008</td></tr>
<tr><td>Finally we have RFC 3164 syslog replaced <a href="../../../pa1688/software/palmtool.html">PalmTool</a> UDP debug completely. It takes many years to understand the importance of open standard. Starting from <a href="../../../ar1688/index.html">AR1688</a> 0.37 software, <a href="20070609.php">UDP debug</a> implementation and options are removed completely. Syslog IP option can be set as "0.0.0.0" for disable syslog, "255.255.255.255" for broadcast debug messages, or a normal IP address.
<br />In <a href="20080624.php">safe mode</a> recovery, syslog IP address is forced to 255.255.255.255, to make debug messages easy to be caught.
<br />The functions like UdpDebugString() still exist in software <a href="20061211.php">API</a>, only that they call Syslog() function from now on.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
