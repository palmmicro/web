<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688 Z80 Performance</title>
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
<tr><td class=THead><B>AR1688 Z80 Performance</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 2, 2008</td></tr>
<tr><td>10 months after writing <a href="20080121.php">Z80 Speed</a>, we now have much more knowledge about the AR1688 Z80 performance and IP phone system limitations.
<br />Slow 2x16 LCD controller is the most common reason to prevent Z80 from running 48MHz or more. It is easy to solve by changing to a faster controller. 
Actually there are many fast controllers, those can not work are simply too old. Dot-matrix LCD controller are all fast enough, none of those caused problem so far.
<br />Slow program flash connecting to Z80 data bus is another reason. Very lucky, we find that usually program flash is only slow for writing. So we can lower Z80 speed to 24MHz when writing, and keep whole system running at high speed most of the time.
<br />Ethernet chip is the last thing to connect to Z80 data bus. With LCD and program flash problem solved, it is deciding how fast AR1688 based IP phone can run.
<br />With mostly common used <a href="20080615.php">RTL8019AS</a>, Z80 can run 60MHz.
<br />Micrel <a href="20081124.php">KSZ8842</a> is not as fast as RTL8019AS, Z80 can only run 45MHz with it.
<br />Davicom DM9003 is the best in terms of speed, Z80 can run 72MHz with it, the max of AR1688 chip design limit.
<br />Where Z80 performance matters?
<br />Even with Z80 running at 24MHz, <a href="../../../ar1688/index.html">AR1688</a> IP phones can handle nearly 1Mbps UDP data. It is ten times more than normal VoIP streams. So Z80 performance actually does not matter with network performance.
<br />When it comes to the voice jitter problem caused by periodic re-register messages (<a href="20071116.php">Rtp First</a>), Z80 performance matters, as we use it for MD5 calculation. 
When doing single loop less than 56 bytes encryption, it takes 4.7 milliseconds on 48MHz, 3.7ms on 60MHz, and 3.0ms on 72MHz.
<br />Due to software interface difference, the "Rtp First" method described on the above link only works with RTL8019AS, we can not do the same to KSZ8842 nor DM9003, so we need to push MD5 calculation as fast as possible. 
Besides running Z80 on higher speed, we also plan to do more assembly optimization for MD5.
<br />Z80 performance also matters with "real" <a href="20070216.php">DSP</a> MIPS. We will put DSP in loop only allow interrupt handling when Z80 exchanges data with DSP. The faster Z80 can read and write DSP data, the more actual DSP MIPS can be used.
<br />Why I am always talking about performance and optimization? Maybe because it is the only thing I know how to do it right.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=grey>"We should forget about small efficiencies, say about 97% of the time:
<br />premature optimization is the root of all evil." - Donald Knuth "Structured
<br />Programming with go to Statements" Computing Surveys, Vol. 6, No. 4,
<br />December, 1974, page 268.
</font></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
