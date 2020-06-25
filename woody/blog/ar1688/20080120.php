<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Do NOT Upgrade "Long" Ring Tone</title>
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
<tr><td class=THead><B>Do NOT Upgrade "Long" Ring Tone</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Jan 20, 2008</td></tr>
<tr><td>Today I read an email reporting <a href="../../../ar1688/user/gp1266.html">GP1260</a> phone display error after upgrading a "long" ring tone. Actually most parts of the problem are fully covered in our development guide and on my blog here. I am repeating a few points below:
<br />1. AR1688 <a href="20070328.php">ring tone</a> is located in page 2, 3, 4, total 192k bytes, details of its format and how to build it can be found in our software development guide.
<br />2. AR1688 hold music is located in page 5, 6, 7, the format is the same as ring tone.
<br />3. <a href="../../../ar1688/index.html">AR1688</a> font used in dot-matrix display designs (AR168G/GP1260/GP1266/GP2266) is located in page 8, 9, 10, 11
<br />4. When using TFTP to upgrade ring tone and hold music, we will not check file length. This is a back door for us to upgrade font, because there is no special way to upgrade font
<br />5. A ring tone more than 192k bytes will replace hold music. A long ring tone more than 384k bytes will replace font and make dot-matrix display wrong. And a very long ring tone more than 640k bytes will destroy software program space (page 12 - 31) and make the IP phone fail to boot normally, lucky enough, safe mode in page 0 will not be replaced, the phone can still get into safe mode upgrade correct files again.
<br />6. The steps to restore font is explained in details <a href="20070605.php">here</a>.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
