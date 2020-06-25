<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Micrel KSZ8842</title>
<meta name="description" content="We tried to use KSZ8842 to replace RTL8019AS and RTL8305 in AR1688 solution. It looks promising with better performance and lower power consumption.">
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
<tr><td class=THead><B>Micrel KSZ8842</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 24, 2008</td></tr>
<tr><td>Besides RTL8019AS and DM9003 source code, users can also find part of developing Micrel KSZ8842 source code in the upcoming 0.40 API, under GPL license too. But it is not finished yet.
We hope this chip can replace RTL8019AS+<a href="20061213.php">RTL8305</a> in our reference design in the near future.
Test boards are promising so far, especially that the chip is even cooler than RTL8305, not to mention the huge temperature difference compared with DM9003.
<br />Kendin was the most VoIP active switch company, its KS8993 was the first 3-port switch for VoIP applications. We still have a few of its sample chips got from their Santa Clara office many years ago.
However, saving chip cost is not the only way to win, 5-port switch chip RTL8305 wins the market with huge quantity outside of VoIP world.
Kendin merged into Micrel during our period of focus on Taiwan made cheaper switch chips. 
<br />We eyed on Kendin/Micrel again after DM9003 became a dead horse. Then we found KSZ8842, 2-port switch with 8-bit CPU bus, specially designed for voice and video over IP applications.
Actually it was the first of those VoIP aware chip again, much earlier in market before DM9003. And it is really cool! I guess it is made of .13 process, while others like DM9003 are still .18.
<br />I know it sounds strange when I am boasting our 8-bit <a href="20080121.php">Z80</a> controller network performance in a world 32-bit ARM or MIPS is widely available. But I just can not help it.
<br />The network performance of initial KSZ8842 software is poor, because it is not assembly optimized, and unlike DM9003, KSZ8842 itself does not have hardware checksum generation.
I am recording 3 major performance data here, so we can come back and compare the results after software optimization. All test are made when the Z80 of AR1688 runs at 48Mhz.
<br />AR168P is our new <a href="../../../ar1688/index.html">AR1688</a> hardware reference design based on KSZ8842.
<br />Digitmat GP2266 is based on <a href="20080615.php">RTL8019AS</a>+RTL8305 design,
it is still not in production because first they are waiting for AR168O/DM9003 design and now they are waiting for AR168P/KSZ8842 design.
<br />1) Ping 2952 bytes, GP2266 takes 21 milliseconds, AR168P takes 35ms.
<br />2) Upgrade software, GP2266 takes 16 seconds, about 41kbytes/second, AR168P 19 seconds, 34kB/s.
<br />3) TFTP only test, GP2266 reaches 187kbytes/second (1.50Mbps), AR168P 127kB/s (1.01Mbps).
<br />&nbsp;
<br /><font color=magenta>Updated on Nov 25, 2008</font>
<br />AR168P network performance difference after 24 hours of software optimization:
<br />1) Ping 2952 bytes, 19 milliseconds, slightly faster than GP2266 (21ms).
<br />2) Upgrade software, 16 seconds, same as GP2266.
<br />3) TFTP only test, 208kbytes/second, or 1.66Mbps, 11% better than GP2266.
<br />So glad to see everything with KSZ8842 is better than RTL8019AS. Actually I was thinking KSZ8842 might be a little slow because its read and write procedures are more complicated.
Obviously faster bus operation helps.
</td></tr>
<tr><td><img src=../../../pa1688/user/hop3003/rtl8305sb.jpg alt="RTL8305SB chip in HOP3003 IP phone."></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
