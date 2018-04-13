<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>USB</title>
<meta name="keywords" content="USB">
<meta name="description" content="After years of USB related study, Woody now finally has the opportunity to use it with Palmmicro PA3288 VoIP solution. Check our new WiFi VoIP product plan.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa3288.js"></script>
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
<script type="text/javascript">NavigatePa3288();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>USB</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 31, 2013</td></tr>
<tr><td>Designed as a MP3 and digital camera chip, <a href="../../../pa1688/index.html">PA1688</a> has built in USB 1.1 device, but we had never used it in our VoIP software.
<br />In 2004 a new CEO replaced Dr Wang at <a href="../palmmicro/20080326.php">Centrality</a>.
After the new CEO's visit to Beijing at the end of the year, I knew it clearly that we had to go on VoIP business by ourselves at any time.
<br />I was very actively planning what to do next in 2005 and finally decided to develop an USB FXS gateway solution first, as an extra VoIP product for our existing customers.
And then a WiFi VoIP solution to replace PA1688 later.
<br />I signed a contract with a chip design company in China, paid NRE for the 8051+USB chip, and started learning USB software programming.
Soon I found Keil has provided complete USB examples we need, with USB HID, audio and mass storage class on its MCB2140 board with Philips LPC2148 chip.
<br />The USB FXS gateway product idea was good. MagicJack sold tens of millions of such products years later, earned enough money to take over the first VoIP company VocalTec in a reverse takeover on July 16, 2010.
But we did not finish our solution. 
<br />At the end of 2005 the CEO finally fired us. Although the layoff letter came a few months later than I expected,
the decision of discontinuing PA1688 shocked me. I had to give up the USB chip and find a new solution to replace PA1688 for our customers as soon as possible.
<br />As a quick replacement, we developed <a href="../../../ar1688/index.html">AR1688</a> solution based on a popular MP3 chip in 2006. It has built in USB 2.0 device,
but we had never used it in our VoIP software neither.
<br />Things are different with PA3288 now. With USB 2.0 OTG, it is almost the chip of my dream back in 2005.
We are planning to add WiFi USB dongle support to it and build a low cost <a href="../entertainment/20110323.php">WiFi VoIP</a> solution. As a first step, I found out the updated version of MCB2140 USBMem examples from Keil,
Tang Li put it together with open source <a href="../pa6488/20101225.php">EFSL</a> file system,
now PA328A board can work as a standard FAT16 <a href="../../../pa3288/software/devguide/usb.php">USB</a> storage class disk for debug purpose.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>

