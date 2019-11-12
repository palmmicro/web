<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - Ping Response Time</title>
<meta name="description" content="Comparing the response time of ping 1472 bytes from PA1688, AR1688 and PA6488, Palmmicro is saying goodbye to 8-bit controller now.">
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
<tr><td class=THead><B>From PA1688 to PA6488 - Ping Response Time</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 8, 2009</td></tr>
<tr><td>All PA1688 devices use <a href="../ar1688/20080615.php">RTL8019AS</a> ethernet chip. When its internal 8051 runs at 22Mhz, it needs 21ms to answer a 1472 bytes ping generated in a Windows PC.
When the internal Z80 of AR1688 runs at 24Mhz, it needs 16ms with RTL8019AS, and 15ms with <a href="../ar1688/20081124.php">KSZ8842</a> ethernet chip.
PA6488 has built-in MAC, just tested it only needs 2ms to answer a 1472 bytes ping.
<br />I am testing it on a 10Mbps hub in order to capture and trace ethernet packets. Considering over 1500 bytes sending and receiving in 2ms means more than 6Mbps bandwidth,
I guess the performance will be even better on a 100Mbps LAN.
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 11, 2009</font>
<br />When testing on a 100Mbps switch, both <a href="../../../pa6488/index.html">PA6488</a> and my Sony VGN-FW235J notebook only take 1ms to reply the 1472 bytes ping packet.
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 30, 2009</font>
<br />PA1688 can not fragment outgoing datagrams and reassemble incoming datagrams at all. At that time,
we just believed that none streaming voice data packet nor H.323 protocol data packet would be as long as over 1500 bytes. 
And although <a href="../../../pa1688/index.html">PA1688</a> devices have 1Mx16 bits external SDRAM, the memory space was not well organized. 
When we found with horror that some SIP signal packets have length exceeded the max ethernet packet size, it was too late for us to change the software structure fundamentally to support it.
<br />AR1688 learned from PA1688's failure to handle large SIP packet. However, as a highly integrated and low cost replacement for PA1688,
<a href="../../../ar1688/index.html">AR1688</a> devices do not have external SDRAM memory. We implemented up to 3000 bytes large ip packet fragmentation and reassembly in the very limited AR1688 internal memory,
just enough for large SIP messages we had to deal with.
<br />Targeting video and voice over IP applications, all PA6488 devices need large external DDR2 SDRAM for video buffers and other program and data usage as well.
It is time for us to support full ip fragmentation and reassembly now.
<br />Using command line <i>ping 192.168.1.122 -t -l 65500</i>, I have just made a 65500 bytes ping test with my 300MHz PA648B board, the response time is 26ms. 
Noticed that my Sony VGN-FW235J only need 12ms in the same test conditions, I began to check how fast PA6488 can be. I changed to 600MHz PA648A, it is 16ms.
<br />So far, when test with ping, the Intel 2G duel core CPU with 800MHz DDR2 is still 33% faster than my 600MHz PA6488 with 200MHz DDR2.
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 31, 2009</font>
<br />Continue with yesterday's test of ping 65500 bytes, with software optimization, now 300MHz PA648B can response in 15ms, and 600MHz PA648A can response in 13ms. 
It is very close to the 12ms result of my notebook already. Obviously CPU speed is not critical in the response time, bandwidth matters instead.
<br />How much <a href="../ar1688/20071031.php">bandwidth</a> is used to response 65500 bytes ping in 13ms? Let us calculate it step by step:
<br />1) 65500 bytes ICMP data equals 65508 bytes IP data.
<br />2) 65508 bytes IP data need to be transmitted in 65508/1480=45 IP packets.
<br />3) Each IP packet needs 20 byte IP head, 14 bytes MAC head, 8 bytes preamble and 4 bytes MAC CRC, totally 46 bytes.
<br />4) The total data transferred in 13ms is 65508+45*46=67578 bytes.
<br />5) Let us suppose both sides use same time to transmit and receive, which is 6.5ms each, 67578 bytes in 6.5ms means 67578*8*1000/6.5=83.2Mbps, rather close to the 100Mbps LAN capacity.
<br />&nbsp;
<br /><font color=magenta>Updated on Feb 15, 2015</font>
<br />As I am merging the TCPIP code of PA3288 and PA6488, I tested ping 65500 bytes again after 5 years and 6 months. Now the response time are both 12ms, no matter PA6488 runs at 300Mhz or 600Mhz.
This means 90.1Mbps data rate.
<br />When using ENC28J60 ethernet chip, No matter CPU runs at 96Mhz or 192Mhz, <a href="../../../pa3288/index.html">PA3288</a> need 4ms to reply the 1472 bytes ping.
The SPI interface is the performance bottleneck, although I have set its working clock to max 20Mhz according to its datasheet.
<br />Same as AR1688, PA3288 does not use external SDRAM memory. I removed as much unrelated code as I could, made room for a big enough heap in the internal SRAM test ping 65500 bytes.
When CPU runs at 96Mhz, the response time is 139ms, when CPU runs at 192Mhz, the response time is 136ms, this means about 7.8Mbps actual data rate, good enough for a 10Mbps ethernent chip.
<br />&nbsp;
<br /><font color=gray>The wasted 1x16 SDRAM in PA1688 software.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/m12l16161a.jpg alt="ESMT 1Mx16-bit SDRAM chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
