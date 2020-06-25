<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - TFTP Performance</title>
<meta name="description" content="Comparing the TFTP performance of AR1688, PA6488 and PA3288. We are merging common TCPIP code of PA3288 and PA6488.">
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
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
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>From PA1688 to PA6488 - TFTP Performance</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Sep 1, 2009</td></tr>
<tr><td>Actually PA1688 does not support TFTP protocol. Besides common HTTP upgrade, it uses special <a href="../../../pa1688/software/palmtool.html">PalmTool</a> as its <b>native</b> upgrade method. 
Although we spent more than 3 years on a none successful replacement of PA1688, we really learned a lot with AR1688 development.
One of the most important thing we learned is to do work in the existed <a href="../ar1688/20080811.php">standard</a> way.
<br />We use TFTP upgrade as <b>native</b> upgrade method with <a href="../../../ar1688/index.html">AR1688</a>,
we call it <a href="../ar1688/20060929.php">native</a> because it is the only upgrade method in safe mode recovery. 
Of course it can work in normal operation as HTTP upgrade too. Working as a TFTP server, AR1688 can receive TFTP data at <a href="../ar1688/20080615.php">1.5-2.2</a>Mbps.
<br />On 600MHz PA648A board, using my Sony notebook as TFTP client, I can put a 18034784 bytes file into <a href="../../../pa6488/index.html">PA6488</a> DDR2 memory in 7 seconds!
<br />18034784/512=35225 TFTP blocks.
<br />Each TFTP block need extra 4(TFTP head)+8(UDP head)+20(IP head)+14(MAC head)+8(MAC preamble)+4(MAC CRC)=58 bytes to be received.
<br />The total data received in 7 seconds is 18034784+35225*58=20077834 bytes.
<br />The bandwidth is 20077834*8*/7=22.9Mbps.
<br />TFTP protocol needs ACK for each data received, and peer will not send new data until old data ACKed, this is why the bandwidth we get is not as much as 100Mbps on a 100Mbps LAN.
<br />&nbsp;
<br /><font color=magenta>Updated on Mar 4, 2015</font>
<br />As I am merging the common TCPIP software of PA6488 and PA3288, I tested the TFTP performance of PA3288. With ENC28J60 ethernet chip,
<a href="../../../pa3288/index.html">PA3288</a> runs at 192Mhz can put a 8.5M bytes file in 27 seconds. This is about 2.8Mbps data rate, just as we learned from <a href="20090808.php">ping</a> 65500 test,
The bottleneck is the SPI interface 10Mbps ethernet chip. 
<br />Both AR1688 and PA6488 TFTP code has 32M bytes file limit, and it is the same with PA3288, can not test file more than 32M bytes neither. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
