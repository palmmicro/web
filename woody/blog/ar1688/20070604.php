<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Font in 2x16 Character LCD</title>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>Font in 2x16 Character LCD</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>June 4, 2007</td></tr>
<tr><td>Most <a href="../../../ar1688/index.html">AR1688</a> IP phones are using 2x16 character LCD, because it is cheap and widely available. It usually uses 5x8 font. From 0x20 to 0x7f are standard ASCII characters. 
<br />I read the 3 different LCD datasheets in my computer and found none of it is compatible with <a href="20070603.php">ISO 8859</a> for the characters after 0x80. Then I wrote a program to display the actual font in those AR1688 and <a href="../../../pa1688/index.html">PA1688</a> IP phones in my hand. To my surprise, most of them are Japanese characters after 0x80. At first I was thinking why Chinese are so friendly with Japanese, or why Japan is so important to China. Then I realized it was because Japanese first built those 2x16 character LCD chips, we are still trying to be compatible with it today!
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
