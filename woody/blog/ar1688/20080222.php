<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Detail Steps to Add ISO 8859-2 Font to AR1688 Software</title>
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
<tr><td class=THead><B>Detail Steps to Add ISO 8859-2 Font to AR1688 Software</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Feb 22, 2008</td></tr>
<tr><td>Based on <a href="../../../ar1688/index.html">AR1688</a> 0.28 software release:
<br />1. Download font <a href="20080216.php">files</a>, copy 5x8.bdf, 7x14.bdf and MAPPINGS\8859-2.txt to SDCC\bin
<br />2. Run command line SDCC\bin\font.exe 5x8.bdf -t5. Generate array.txt file
<br />3. Run command line SDCC\bin\font.exe 8859-2.txt -i. Generate font.txt, this is the 5x8 font for <a href="20070604.php">2x16</a> LCD extended CGRAM display
<br />4. Run command line SDCC\bin\font.exe 7x14.bdf -t7. Generate array.txt file
<br />5. Run command line SDCC\bin\font.exe 8859-2.txt -i (again). Generate font.txt, this is the 8x16 font for dot-matrix display
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
