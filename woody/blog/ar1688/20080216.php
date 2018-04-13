<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Font Resources</title>
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
<tr><td class=THead><B>Font Resources</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Feb 16, 2008</td></tr>
<tr><td>We were using ISO 8859-1 8x16 ASCII <a href="20070603.php">font</a> and GB2312 16x16 Chinese font before recent <a href="20070405.php#20080213">Turkish</a> support. <a href="../../../ar1688/index.html">AR1688</a> Turkish software version brings us some good questions. For example, what should we do with the 6 different chars' font in ISO 8859-9 for Turkish? What if we need other ISO 8859 font for other languages later? How to find those self defined 5x8 CGRAM font data used in general <a href="20070604.php">2x16</a> LCD?
<br />The answer, of course, is to find those resources on the internet, where pictures of CGX are flooding these days. I found Markus Kuhn's <a href="http://www.cl.cam.ac.uk/~mgk25/ucs-fonts.html" target=_blank>page</a> and downloaded all those Unicode font for X11, converted the 5x8 font for 2x16 LCD, and 7x14 font for dot-matrix display.
<br />To avoid <a href="20070605.php">upgrade font</a> every time user changes different language software version, we added SDCC\src\font.c for ISO 8859 font data, linked it with the upgrade binary file. In this way, ISO 8859-1 font is together with French or English software version, and ISO 8859-9 font is linked with Turkish software version.
<br />There is one thing we do not like so far, the X11 font uses small '+' for '.', makes the dot-matrix display looks strange.
<br />During the work, I also found this perfect place for <a href="http://www.cs.tut.fi/~jkorpela/iso8859/" target=_blank>ISO 8859</a> information.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
