<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>ISO 8859 Font</title>
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>ISO 8859 Font</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>June 3, 2007</td></tr>
<tr><td>In the old last century DOS days, every programmer had tried to display Chinese in his own application. When we began to design dot-matrix display for <a href="../../../ar1688/user/gp1266.html">AR168G</a> IP phone, I was so happy that the program skills of 14 years ago can be used again. I digged out those ancient c and asm codes with ASCII 8x16 and Chinese 16x16 font and put it into display at once.
<br />Everything is ok on the past half year, until Sebastien <a href="20070405.php">translated</a> all <a href="../../../ar1688/index.html">AR1688</a> resources into French. Some French characters are encoded after 0x80. I found my ASCII font after 0x80 can not match its coding. I had to make a convert table for French display, this is what now in 0.13 firmware. But problem continues, I found not all French special characters are in my font. The lead me to consider how poor my knowledge it is, regarding the world except China and US. Then I begin to search for the a standard of Windows French encoding. The result is better than I expected, the answer is <a href="http://czyborra.com/charsets/iso8859.html" target=_blank>ISO 8859</a>.
<br />As 0.13 and 0.14 are freezed for testing right now, we can only make the changes in 0.15 and 0.16. I feel so stupid of my actions 6 months ago. Seems that 14 years are not long enough to teach me consider more of the world before making movement. For French and other language AR168G existing users, they will need to upgrade font specially after 0.16 firmware upgrade to display special characters correctly.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
