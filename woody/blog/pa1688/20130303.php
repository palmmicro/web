<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A New PA168M Board Made in Iran</title>
<meta name="description" content="A hard working engineer in Iran build a PA168M board without checking the discontinued notice on our web site.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>A New PA168M Board Made in Iran</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 3, 2013</td></tr>
<tr><td>I was very surprised at an email I received last week. I was told that a new PA168M board was recently made in Iran, and the hard working engineer was asking how he could boot up the hardware.
<br />I had completely forgotten all about PA168M at that time. After a few more emails, I finally got the whole story.
This man downloaded the <font color=grey>PA168M(PA168S)</font> IP phone related files from our <a href="../../../pa1688/hardware.html">hardware</a> page,
bought all necessary chips from an irresponsible Chinese distributor, made the board and mounted all the chips.
As both PA1688 and <a href="../../../ar1688/index.html">AR1688</a> solution need to program flash before manufacturing, it did not surprise me that it could not boot up.
<br />I suggested the steps to follow:
<br />1. In software <a href="../../../pa1688/software/sw167.html">1.67</a> page, download the file <font color=grey>Nov 13, 2011 PA168S IP phone 1.67.012 Safe Mode English</font>. After upzip, it is in the name of <b>page0.hex</b>.
<br />2. In the hardware <a href="../ar1688/20101202.php">programmer</a>, it should have utility to convert this <b>page0.hex</b> into a 64k bytes .bin file, or the hardware programmer can accept this .hex file directly.
Use the contents of this file to program the first 64k bytes of the MX29LV008TTC <i>top</i> compatible program flash.
<br />3. Mount the flash into board, press and hold * key, boot it into <a href="../pa6488/20090927.php">safe mode</a>.
<br />4. In safe mode (192.168.1.100), use <a href="../../../pa1688/software/palmtool.html">Palmtool</a> to upgrade PA168S <a href="../../../pa1688/software/sw168.html">1.68</a> file <b>pa168s_sip_us_168000.bin</b>.
<br />After the reply, I changed the <i>discontinued</i> notice in PA1688 page from <font color=grey>grey</font> to <font color=red>red</font> at once, and added another red warning in hardware download page as well!
<br />&nbsp;
<br /><font color=grey>This PA1688-PQ chip marked with 0519 was manufactured on the 19th week of 2005, the last year of PA1688.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/pa1688pq.jpg alt="PA1688PQ chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
