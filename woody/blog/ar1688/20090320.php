<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Pound Key as Call Key</title>
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
<tr><td class=THead><B>Pound Key as Call Key</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 20, 2009</td></tr>
<tr><td>Early IP phone and ATA users were "forced" to use '#' key to call out. Unlike PSTN, the devices usually didn't know when was the end of dialing. In old <a href="20060929.php">H.323</a> days lots of IP to IP calls were made, especially when testing with NetMeeting which came free with Windows system. Since '*' key was used in internet address as '.', the only choice was to use '#' as key to call out.
<br />PSTN service providers did not like H.323 at all. But when their backbone network were changing into IP, they guess they need something at the terminal side too. MGCP protocol was the answer, but it is really a bad one. The only good thing for MGCP is that it has "digit maps", so devices know when the numbers are completed.
<br />SIP and <a href="20071110.php">IAX2</a> protocol did not consider the dialing difficulty at first. But later they added things like "Overlapped Sending" and "Server's Dial Plan" to solve this problem.
<br />Inspired by MGCP "digit maps", AR1688 and PA1688 devices can set private "<a href="20070321.php">digit maps</a>" to enable call out without special call key or '#'.
<br />PSTN service providers actually used a lot of '#' in special services. So when we were testing <a href="../../../pa1688/index.html">PA1688</a> devices with Huawei and UTStarcom systems, we added special "service type" as "huawei" and "utstarcom" to disable '#' key to call out.
<br />When we started <a href="../../../ar1688/index.html">AR1688</a> software, we decided to discard '#' key as call key from the beginning. However, many old customers still like to use '#' key, we had to add an option "Use '#' To Call" later.
<br />In United States, people call '#' as pound key. For a long time I had been wondering: what is the relationship between '#' and a pond?
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
