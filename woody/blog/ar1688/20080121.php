<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Z80 Speed</title>
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
<tr><td class=THead><B>Z80 Speed</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Jan 21, 2008</td></tr>
<tr><td>Two years passed quickly since we started working on AR1688. It looks like a good job so far, with better voice quality and lower BOM cost than previous <a href="../../../pa1688/index.html">PA1688</a> chip. 
However there are haunted problems all the time. The running speed of Z80 is one of them.
<br />I wrote 48MHz running speed in the first <a href="../../../ar1688/index.html">AR1688</a> article, but this speed is never used in mass production software because we found a certain percentage of IP phones can not actually run correctly in 48MHz clock. 
Every software release so far is using 24MHz Z80 running speed to ensure 100% working of the IP phones. We call it low speed software all those months.
<br />Detail check of the reason for low speed is very complicated, seems related with almost every part of the phone, including AR1688 chip difference, program flash chip difference, LCD difference and even the PCB layout difference.
<br />In current 0.27 test software, SetHighSpeed() function call is added in software <a href="20061211.php">API</a>. It can only be called once in function.c UI_Init() function, or never be called. 
If it is never called, the software will keep running on 24MHz, after it is called, the software will run on 48MHz. End users can try this function call for their own hardware, most IP phones can run on 48MHz. 
If one is unlucky to have a slow hardware, the IP phone can be upgraded with standard low speed software in safe mode. Safe mode always runs with low speed at 24MHz.
<br />After upgrading the high speed software, using Windows command line "ping xxx.xxx.xxx.xxx -l 2952" to confirm the high speed is actually working. It takes about 19ms for the ping in high speed, and about 33ms for the ping in low speed. 
Watch carefully for those signs of high speed problem:
<br />1. LCD display error
<br />2. New upgrade operation failed with very fast speed, like 9 seconds
<br />3. Strangely changed or corrupted IP phone settings after change of settings or upgrade
<br />Safe mode will always work, users can use #5*5 and #5*0 to restore factory settings and upgrade low speed working software in safe mode when anything is wrong.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
