<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>A Hard Day's Night</title>
<meta name="description" content="When I was compiling Spanish software for Soyo G1681 (PA168V), I suddenly realized how we slowed down the running speed of PA1688 software.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>A Hard Day's Night</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Sep 7, 2010</td></tr>
<tr><td>I was compiling some <a href="../../../pa1688/user/pa168v.html">PA168V</a> Spanish upgrade files on my old <a href="../ar1688/20100818.php">Sony PCG-K23</a> this afternoon, and complaining for another time how MS automatic updating had successfully made a working PC so slow in 20 months. Suddenly it occurred to me that we had done just the same thing with <a href="../../../pa1688/index.html">PA1688</a> software.
<br />Every time we added some thing new, it became slower.
<br />When we added iLBC support, in order to put the code to existing program flash space, we had to compress all DSP code in program flash, and uncompress them when boot-up, thus made the boot-up progress slower than an embeded linux. 
<br />And when we added <a href="../../../pa1688/user/iphe00.html">dial-up modem</a> support in some of PA1688 hardware, to <a href="../ar1688/20100715.php">prevent fork</a> on our software, we wrapped a lot of function calls which would definitely hurt the software performance for <b>all</b> PA1688 devices.
<br />With this idea in my mind, I started to separate dial-up modem and other code at once. A new OEM_MODEM compile option is added, and most modem related code will not be included in normal upgrade files unless OEM_MODEM is defined. The means dial-up modem users need special software version from 1.65.005 (for example pa168s_sip_us_modem_165005.bin), but most ethernet users will benefit from the improved software performance. 
<br />It was close to midnight when all those optimization and test work finished. I uploaded the newly built PA168V files to <a href="../../../pa1688/software/sw165.html">web site</a> and sent email notification to the <a href="../../../pa1688/user/ag168v.html#soyo">Soyo G1681</a> PA168V owner,
who recently bought the device on internet for 6 USD each. Compared with his previous purchase of 50 "Soyo G668" <a href="../../../pa1688/user/pa168s.html">PA168S</a> ip phone for a total 150 USD, the 1-port FXS PA168V had magically doubled the price. 
</td></tr>
<tr><td><font color=gray>It's been a hard day's night, and I been working like a dog.</font> <a href="../../favorite.html#night">A Hard Day's Night</a></td></tr>
<tr><td><img src=../../../pa1688/user/g1681/soyo.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway front view." /></td></tr>
<tr><td><img src=../../../pa1688/user/g1681/back.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway back view." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
