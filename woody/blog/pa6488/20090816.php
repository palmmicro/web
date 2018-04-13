<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - Upgrade Software Name</title>
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
<tr><td class=THead><B>From PA1688 to PA6488 - Upgrade Software Name</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 16, 2009</td></tr>
<tr><td>Both <a href="../../../pa1688/index.html">PA1688</a> and <a href="../../../ar1688/index.html">AR1688</a> upgrade software name use the same <a href="../ar1688/20080607.php">name rules</a>. In the format looks like xxxxxx_yyyy_zz_vvvvvv.bin or xxxxxx_yyyy_zz_oooooo_vvvvvv.bin.
<br />The detail name comes from software API include\version.h, where xxxxxx is from hardware board name define VER_XXXXXX, yyyy from software protocol define CALL_YYYY, zz from ISO 3166 resource define RES_ZZ and oooooo from special OEM_OOOOOO define. The "oooooo" field is only in the name when special software implementation inside the upgrade file.
<br />With <a href="../../../pa6488/index.html">PA6488</a>, we are putting different protocols like <a href="../ar1688/20060929.php">SIP</a> and <a href="../ar1688/20071110.php">IAX2</a> into the same upgrade software file. The CALL_YYYY and "yyyy" fields are removed from both version.h and software file name. As CALL_NONE was used for safe mode recovery with PA1688 and AR1688, we are adding special OEM_SAFEMODE to replace it. In this way, a name like "pa648c_us_010023.bin" means the 0.10.023 version English upgrade file for PA648C video compression module, and "pa648b_cn_safemode_002034.bin" is 0.02.034 Chinese version for PA648B development board special safe mode recovery purpose. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
