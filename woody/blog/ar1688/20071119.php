<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Simple UART</title>
<meta name="description" content="With more and more request from customers, we are beginning to provide simple UART support in AR1688 software API.">
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
<tr><td class=THead><B>Simple UART</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 19, 2007</td></tr>
<tr><td>Because of increasing interest to use <a href="../../../ar1688/index.html">AR1688</a> UART pins for non-standard VoIP applications, we added UART software support in current 0.25 test software.
<br />The UART in AR1688 is the simplest, only a RX pin and a TX pin, no hardware flow control nor status pins. Hardware 8 level by 8 bits FIFO are used to buffer receiving and sending data. There is 0.16% hardware clock error with all baudrate because of PLL limitation.
<br />UART software can be compiled using OEM_UART option. 
The 2 UART pins are already used in ADC keys (<a href="20061213.php">AR168F</a>/<a href="../../../ar1688/user/gp1266.html">AR168G</a>/<a href="../../../ar1688/user/gf302.html">GF302</a>/<a href="../../../ar1688/user/ywh201.html">YWH201</a>), 5x5 keys (<a href="../../../ar1688/user/gp1266.html">GP1266</a>) and 5x6 keys (AR168K), we need to disable all those keys when using UART.
<br />The UART is currently configured as 19200bps baudrate, 8 bits data, 1 bit stop and none-parity. Can be configured up to 115200bps if necessary.
<br />When receiving data, Z80 will be interrupted when receiving FIFO is half full, we will read all available data in a 255 bytes circle buffer and wait for main loop to handle the data. We avoid to be in UART interrupt routine as much as we can to prevent it slowing done DSP by blocking Z80 DSP interrupt.
<br />When sending, no interrupt is used, we will put all sending data into another 255 bytes circle buffer and try to write TX FIFO until full whenever we can, both in sending data function and in main loop. We use 255 bytes sending buffer because we do not hope to poll until all data sent out, to avoid blocking main loop to handle other more critical tasks like RTP traffic.
<br />There is no receiving or sending data error report to upper lever software, application software must handle data check and necessary re-transmission for reliable data exchange.
<br />We implemented a "string" based UART communication example in uart.c, without any error check, using '\0' as separator for data groups over UART. To ensure data can be received as soon as sent, we actually added 4 extra '\0' in each sent string because the Z80 interrupt will only come when FIFO half full.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
