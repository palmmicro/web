<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Steps to Upgrade an Old PA168F</title>
<meta name="description" content="How to bring an old Palmmicro PA168F IP phone up to date. Requires skill as well as luck too due to poorly designed software.">
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
<tr><td class=THead><B>Steps to Upgrade an Old PA168F</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 4, 2011</td></tr>
<tr><td>An user emailed us some new pictures of a <a href="../../../pa1688/index.html">PA1688</a> based IP phone and reported it displayed "PA168F" on the LCD.
After checking the PCB picture and found "MX29LV004TTC" program flash there, I tend to believe it is based on the early PA168F <a href="20080806.php">standard</a> reference design. However, it has much more complicated function keys than PA168F.
The manufacturer might have developed some of their own software for those keys. Today we can only try the standard PA168F software in the hope of those basic digital keys will work normally.
<br />Even with standard PA168F, we may still meet problem to upgrade it with current software release <a href="../../../pa1688/software/sw166.html">1.66</a>. Because of a stupid decision with our early software development, we changed the booting sequence for PA168F, now we need to do some special steps to bring the PA168F software up to date.
<br />I have uploaded <a href="../../../pa1688/user/pa168f.html">PA168F</a> "SIP English" and "Safe mode file" to <a href="../../../pa1688/software/sw167.html">1.67</a> test software page.
User can first try to upgrade the SIP English file normally by <a href="../../../pa1688/software/palmtool.html">PalmTool</a> or <a href="../pa6488/20100109.php">web interface</a>. After upgrade, if it can not boot up, for example stuck at "<a href="../../../pa1688/faq.html#booting">Booting</a> ...", we can fix it in the following way:
<br />Do similar steps 1 to 4 described <a href="20110814.php">here</a>, force PA168F into <a href="../pa6488/20090927.php">safe mode</a>.
Select PalmTool "PFlash Page" to "page0", "PFlash Type" to "AM29LV004T", "IP Address in Chip" to "192.168.1.100", and use "Update PFlash" to update safe mode file <a href="../../../pa1688/faq.html#page0">page0.hex</a>.
<br />Another interesting point of this phone is that it uses Winbond W83972D as the <a href="20070607.php">AC97</a> chip. Considering we had so many trouble sourcing Wolfson WM9703/WM9707 replacement for our customers during 2004, I hope I had seen this board a long long time ago!
</td></tr>
<tr><td><img src=../photo/20111104.jpg></td></tr>
<tr><td>PCB <a href="../../../pa1688/user/pa168f/pcb.jpg" target=_blank>Large View</a></td></tr>
<tr><td><img src=../../../pa1688/user/pa168f/pcb_s.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
