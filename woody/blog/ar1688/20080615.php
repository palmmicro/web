<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A Farewell to RTL8019AS</title>
<meta name="keywords" content="RTL8019AS, DM9003, RTL8305">
<meta name="description" content="We tried to use DM9003 to replace RTL8019AS and RTL8305 in AR1688 solution. At first it looks promising, but eventually failed after months of tests.">
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
<tr><td class=THead><B>A Farewell to RTL8019AS</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>June 15, 2008</td></tr>
<tr><td>Back in year 2000, we were one of those first to put Realtek RTL8019AS 10Base-T ethernet chip into embedded systems.
The first RTL8019AS driver software on <a href="../../../pa1688/index.html">PA1688</a> was modified from the NE2000 driver in Windows DDK source code. 
Over the years, we have become so familiar with all those RTL8019AS registers and memory buffers. With lots of optimizations and almost none extra memory copy,
the TCPIP stack and RTL8019AS driver running on AR1688 is the fastest in the world among 8-bit controllers, while using the smallest memory needed. 
When <a href="20080121.php">Z80</a> working at 48MHz, the UDP throughput can get to 1.5Mbps under simple TFTP test. 
What is more, based on the fully control of RTL8019AS internal buffers, we have done IP fragment support without any memory copy,
and a <a href="20071116.php">Mini Run</a> method to handle RTP data first when the main program thread is held up by long time activities like MD5 calculation.
<br />RTL8019AS was not the only player in the PC ISA bus network card market in the 1990s. Davicom DM9008 was also a major player at that time.
However, DM9008 seems to be slow in internal processing and need PC_READY signal to work. We can not manage that with PA1688 nor <a href="../../../ar1688/index.html">AR1688</a>.
<br />In 2005, when PA1688 business at its peak time, a Davicom marketing people visited our Beijing office to promote the new DM9000 100Base-T chip. 
I told him that we did not need another same price chip to replace RTL8019AS, even it has better performance,
but we need a chip to have MAC and 2-port ethernet switch together because we had to use another RTL8305 for those customers who need 2 RJ45 ports on their phones. 
The possibility talk was good, but when he was going to left, he told me very seriously: I did not promise you such a chip.
<br />In 2007, DM9003 is ready with MAC and 2-port switch. But it was too late for PA1688. And we were very busy with the new AR1688 chip and did not have time to test it.
<br />Finally we have made DM9003 work with AR1688 now. The result is very positive.
With faster bus and hardware calculation of IP/UDP check sum, the UDP throughput reached 2.2Mbps, a 50% gain compared with RTL8019AS under the same test condition. 
It is time to say goodbye to the ancient RTL8019AS now.
<br />&nbsp;
<br /><font color=magenta>Updated on Nov 11, 2008</font>
<br />A Davicom distributor agent was asking me what was the production status of DM9003 in AR1688 solution. He seemed to be shocked when I told him it was not ready yet. 
He even showed me this article I wrote 5 months ago to express his doubt.
<br />DM9003 is hot. I mean, it is really too hot in temperature, should be careful with your finger when you touch it.
This chip will make the whole IP phone board in a warm state. Among the 3 of our customers who made the sample phone board, none of them is thinking it is acceptable.
<br />Another hardware problem with DM9003 is that it will generate extra noise to our voice communication.
Although the noise is not as widely complained as the hot problem among our customers, our hardware engineering think it is not acceptable.
<br />Also we still have a software problem, the receiving software will sometimes stop to work, personally I guess it is because of receive buffer overflow, but I can not find a good way to solve it yet.
<br />All the above problems do not exist in our RTL8019AS design, so it is still too early to say farewell to RTL8019AS.
<br />&nbsp;
<br /><font color=magenta>Updated on Nov 12, 2008</font>
<br />We are planning to release AR1688 software 0.40 next week. In this version, both RTL8019AS and DM9003 driver source code are included under GPL license, same as other part of the software API.
<br />The DM9003 driver source code request is coming from Davicom distributor who hopes to help us to solve the software receiving data problem.
The support people told me that they had helped many other DM9000/DM9003 related customers in their designs just for this special problem!
It sounds actually like a bad news for me, because I understand it as a common problem among all DM9000/DM9003 users. Anyway, what can you do with a dead horse?
<br />&nbsp;
<br /><font color=magenta>Updated on March 15, 2011</font>
<br />Both AR1688 and PA1688 are not dedicated IP phone chips. They all need external ethernet chips. All PA1688 devices used RTL8019AS.
Although we supported <a href="20081124.php">Micrel KSZ8842</a> to work with AR1688 since late 2008, in fact most AR1688 devices still used RTL8019AS in the same way as PA1688.
We had not done much new work during the past 5 years.
<br />To make BOM simple and save total cost, we ignored the <a href="20080729.php">93C46 EEPROM</a> hardware part from the very beginning since 2000.
This is why all our RTL8019AS can only work in 10Mbps half duplex mode, and can not detect ethernet cable unplugged.
This is not something can be changed by software, I am sorry to disappoint so many professional careful users who asked frequently. 
<br />While it is possible to add 93C46 with new AR1688 design, we strongly discourage it.
As our 3rd generation <a href="../../../pa6488/index.html">PA6488</a> solution is planning to market this year, we need to focus our development resources and we are now stopping all AR1688 based new designs.
All unfinished AR1688 based ATA, USB and WiFi designs are discarded too. We will only continue to ship existing mature designs based on AR1688.
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/rtl8019as.jpg alt="RTL8019AS chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
<tr><td>&nbsp;
<br /><font color=magenta>Updated on Sep 10, 2012</font>
<br />After 12 years of working with RTL8019AS, we now have a serious quality problem with it for the first time.
<br />An old customer reported many bad RTL8019AS chips found in their lastest production a few months ago. At first it sounded ridiculous for us because we had never heard of this kind of problem before.
As we could not give any useful advice on the problem, they continued to make a testing board with RTL8019AS socket on it, specially to test those unused parts.
The testing result shocked me, from a whole package of 660 pcs, the testing board picked out 116 pcs of bad ones!
<br />The customer is not located in China, as usual we shipped those bad RTL8019AS to them together with AR1688 chips from Shenzhen, China. 
To compare the result, they got 264 pcs of RTL8019AS from a local Realtek distributor and repeated the test, all 264 pcs ok.
<br />After we received those returned bad chips, we started to test on various kind of AR1688 boards. So far we have tested 15 pcs of them, and confirmed at least 6 pcs not working.
<br />Just like this customer, now we have to do an AR1688 board with RTL8019AS socket on it, and test every RTL8019AS before we ship them out!
</td></tr>
<tr><td><img src=../photo/20120910.jpg alt="RTL8019AS as the Prince and the Pauper." /></td></tr>
<tr><td>&nbsp;
<br /><font color=magenta>Updated on Dec 15, 2012</font>
<br />Removed unsteady hardware type VER_AR168O/VER_AR168KD and related DM9003 code in software API.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
