<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR168M VoIP Module Function Test</title>
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
<tr><td class=THead><B>AR168M VoIP Module Function Test</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 5, 2011</td></tr>
<tr><td>It is 18 months since <a href="../../../ar1688/module.html">AR168M</a> VoIP module got <a href="20100625.php">out of stock</a>. During this time we got a steady inquiry for it from all over the world.
But we always answer "you can build your own board for the test. You see, everything can be downloaded from our <a href="../../../ar1688/hardware.html">hardware</a> web page".
<br />Last month a Bulgaria developer showed us a new way, he bought a GP2266 IP phone to do the VoIP module test by modifying the <a href="20071119.php">UART</a> pins himself.
The software also need a little change to support the test, and this is the result of 0.55.015 API on the AR1688 <a href="../../../ar1688/software/sw055.html">0.55</a> test software page.
Starting from this version, <a href="../../../ar1688/user/gp1266.html">AR168G/GP1266/GP2266</a> IP phone users can use command line like "mk gp2266 sip us uart" to build the UART test software.
<br />Just as building the "real" AR168M/AR168MS/AR168MK module software, in sdcc\include\version.h SERIAL_UI and LCD_HY1602 can not be defined at the same time. For AR168G/GP1266/GP2266, SERIAL_UI and LCD_ST7565 can not be defined as the same time neither.
<br />When SERIAL_UI is defined, the software will run the demo <a href="20080329.php">High Level UI Protocols</a>, all display are outputted to external <a href="20080330.php">controller</a> and the LCD will not work normally.
<br />When LCD_XXXX is defined, LCD will work normally and user need to develop his own UART communication protocols in sdcc\src\serial.c.
<br />&nbsp;
<br /><font color=magenta>Updated on May 3, 2012</font>
<br />SERIAL_UI and LCD_XXXX can be used together since <a href="../../../ar1688/software/sw057.html">0.57</a>.046.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
