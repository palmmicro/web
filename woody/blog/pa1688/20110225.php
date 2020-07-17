<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA1688 Device Killer</title>
<meta name="description" content="Due to different hardware design with different program flash and lack of safety check, update page0.hex is very easy to destroy a PA1688 device.">
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>PA1688 Device Killer</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Feb 25, 2011</td></tr>
<tr><td>A few days ago an user find us by the 00-09-45 <a href="../palmmicro/20091114.php">MAC</a> address on the back of his phone. I answered the email in the standard way, asking for detail inside and outside pictures of his phone.
From the pictures he sent (see below), I guessed it was a standard <a href="../../../pa1688/user/pa168s.html">PA168S</a> IP phone and directed him to PA1688 <a href="../../../pa1688/software/sw166.html">1.66</a> software download page.
Yesterday he told me his phone now got stuck at "Booting ..." after update.
<br />We are actually familiar with the "Booting ..." problem. Although we never figured out why, we used to sent page0.hex <a href="../pa6488/20090927.php">safe mode</a> file and asking user to update it with <a href="../../../pa1688/software/palmtool.html">PalmTool</a>.
In most cases this worked, but this time I was reluctant to do so. 
<br />I remembered that not long ago another user came up with pictures of <a href="../../../pa1688/user/ip300.html">IP300</a> IP phone, I suggested him to upgrade PA168S software,
and after he got stuck at "Booting ...", I sent him PA168S page0.hex and suggested him to update. Then the phone got completely dead. It was the second time I <a href="../pa1688/20091215.php">killed</a> a PA1688 device by sending out page0.hex.
And it was even worse than the first time, as I still do not know what was wrong. 
<br />I can only guess maybe it is another <a href="../pa1688/20080806.php">none standard</a> PA1688 device, although it looks like PA168S, it actually can not be updated with our standard software. 
And I am going to show the user this article and ask if he is willing to risk with page0.hex again.
<br />&nbsp;
<br /><font color=magenta>Updated on Feb 26, 2011</font>
<br />A hardware designer from Yuxin read this article and pointed out it was a <a href="../../../pa1688/user/ywh500.html">YWH500</a> IP phone.
</td></tr>
<tr><td><img src=../photo/20110225.jpg></td></tr>
<tr><td><a href="../../../pa1688/user/ywh500/2l.jpg" target=_blank>Large View</a> <a href="../../../pa1688/user/ywh500/1l.jpg" target=_blank>Outside</a></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
