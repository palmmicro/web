<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - Upgrade Software Size</title>
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
<tr><td class=THead><B>From PA1688 to PA6488 - Upgrade Software Size</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 25, 2009</td></tr>
<tr><td>The size of most <a href="../../../pa1688/index.html">PA1688</a> upgrade file is fixed at 960k bytes. It takes our private <a href="../../../pa1688/software/palmtool.html">PalmTool</a> more than 1 minute to complete an upgrade process.
<br /><a href="../../../ar1688/index.html">AR1688</a> upgrade software size is fixed at 640k bytes. Depending on different hardware boards, it needs about 10 to 20 seconds to do an upgrade by TFTP.
<br />Both PA1688 and AR1688 need the upgrade software <a href="../ar1688/20060930.php">size</a> to be fixed because both 8-bit controllers need bank switching to support code size larger than 64k bytes, and we have to pre-arrange everything on the entire program flash.
<br />With 64-bit <a href="../../../pa6488/index.html">PA6488</a> things are different, it has a 32-bit flat memory space for everything. So we can have any length of <a href="20090816.php">upgrade files</a> now, from less than 64k bytes to 1280k bytes. When upgrade, we only write those program flash parts we need, the upgrade process is so fast that right now we are trying our best to get used to it!
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
