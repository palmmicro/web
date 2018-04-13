<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - Ethernet PHY Ready?</title>
<meta name="keywords" content="Ethernet PHY Linked Status">
<meta name="description" content="Comparing the detection of Ethernet PHY linked status in PA1688, AR1688(KSZ8842), PA3288(ENC28J60) and PA6488.">
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
<tr><td class=THead><B>From PA1688 to PA6488 - Ethernet PHY Ready?</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 20, 2011</td></tr>
<tr><td>I have programmed 4 different MACs so far, after power up, all need 1-2 seconds delay before working normally.
As the NE2000 driver in Windows DDK source code also waited 2 seconds, for a long time I believed that silly waiting code was perfectly normal.
About a year ago I even convinced someone who was testing <a href="../ar1688/20080729.php">DM9003</a> that although the chip did have various problems, waiting for 2 seconds before it can be used was not a bug.
<br /><a href="../../../pa6488/index.html">PA6488</a> has built-in MAC, we used a separate PHY chip on the <a href="20090819.php">PA648C</a> video compression module board.
Last week I noticed the <a href="../ar1688/20080811.php">syslog</a> debug message of <b>PHY linked</b> can always be received.
In this way I can do other network job like DHCP immediately in the interrupt service routine, instead of waiting pointlessly for 2 seconds.
<br />As with AR1688 development, most of the ethernet related improvements had also been updated with <a href="../../../pa1688/index.html">PA1688</a>.
However, PA6488 is so different that I can not do the same change back. 
<br />As we did not use 93C46 with <a href="../ar1688/20080615.php">RTL8019AS</a>, we can not detect the PHY link status.
And although we can detect link status with <a href="../ar1688/20081124.php">KSZ8842</a>, which used in AR168MK VoIP module, we did not used any interrupt on the ethernet part,
with the 1 second timer to check link status, it is hard to reduce the overall waiting time.
<br />As PA1688 and AR1688 both have DSP to do voice processing, on the controller part, ethernet handling is the most important job, so we do not use interrupt for ethernet.
With PA6488, the most heavy job now is video processing, and we process all ethernet tasks in interrupt.
<br />&nbsp;
<br /><font color=magenta>Updated on Mar 10, 2015</font>
<br />In 2012 I changed PA6488 ethernet handling from interrupt to normal main loop, in the hope of better cache performance. The detection of link status was also moved in to main loop,
so I can start DHCP as soon as possible. This <i>smart</i> idea can be used on KSZ8842 too, but for some unknown reason, I did not do it at that time.
<br />The <a href="20090808.php">ENC28J60</a> ethernet chip used in <a href="../../../pa3288/index.html">PA3288</a> solution is the 5th ethernet MAC I have programmed.
After I made it worked the same way as the MAC of PA6488, I suddenly realized that I can apply the changes to KSZ8842 too.
Finally after 6 years, I removed the 2 seconds wait in KSZ8842 init process. The result is the <a href="../../../ar1688/software/sw063.html">0.63.026</a> test upgrade file of AR168P IP phone and AR168MT VoIP module.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>

