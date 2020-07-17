<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Firmware Upgrade Size</title>
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
<tr><td class=THead><B>Firmware Upgrade Size</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Sep 30, 2006</td></tr>
<tr><td>Smaller firmware upgrade size is obviously good for fast <a href="20060929.php">upgrade</a> and auto provisioning. The upgrade file size for a typical PA1688 based phone like <a href="../../../pa1688/user/pa168s.html">PA168S</a>/T is 960k bytes. With AR1688, we have reduced it to 640k bytes. The size reduce comes mostly from 3 parts:
<br />1. SDCC do not actually support code bank switching, to write code larger than 64k bytes, we have to do bank switching by hand, writing detail function call for each function in another bank. With Keil C51 for <a href="../../../pa1688/index.html">PA1688</a>, the automatically code bank switching cost us 50% code space as common code. With SDCC for AR1688, only 25% code space is used as common code.
<br />2. DSP firmware storage structure is improved. We no longer compress DSP code any more, so the boot up time on <a href="../../../ar1688/index.html">AR1688</a> is also instantly, much more fast than PA1688. Actually it is a very bad idea to compress DSP code on PA1688 because of the slow booting time. With AR1688, we have put all common DSP routines like LPC calculation together in one copy of code, this is much more effective than compress!
<br />3. Because there are none LCD IP phones and 1-port FXS gateways design based on PA1688, we have used IVR to prompt end user necessary device informations. With AR1688, we assume that 2x16 LCD is the lowest display requirement, and we will not design gateways based on AR1688, so the IVR function is no longer there, and the corresponding file size is reduced.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
