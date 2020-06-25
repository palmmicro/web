<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Small Device C Compiler 2.9.0</title>
<meta name="description" content="Our first AR1688 software API released with SDCC 2.6.0 in 2006, now SDCC 2.9.0 is ready and included in 0.44.">
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
<tr><td class=THead><B>Small Device C Compiler 2.9.0</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 29, 2009</td></tr>
<tr><td>Once a year, the open source <a href="../../../res/index.html#sdcc">SDCC</a> development team will update a major version. On March 22 they released 2.9.0.
<br />The Windows SDCC binary files still use MSVC 6.0 to compile. But the 10 years old MSVC 6.0 can not run with Windows Vista any more.
As I was out most of the time in last week with my Windows Vista laptop, I was not able to try it until this weekend.
<br />The only thing related with our AR1688 Z80 in the 2.9.0 release note is <font color=gray>many optimizations to reduce code size and increase speed in the Z80 backend</font>.
This statement is true compared with 2.8.0 release on May 2008. But actually the code size is larger than 2.8.3 test version which we started to use on Nov 2008 (with AR1688 0.40 software release).
But anyway, I believe in release versions, so we will release AR1688 <a href="../../../ar1688/software/sw044.html">0.44</a> software based on SDCC 2.9.0.
<br />As usual, the SDCC compiler is located in our software <a href="20061211.php">API</a> SDCC\bin. It is smaller than those binary files directly downloaded from SourceForge because we only have Z80 and 8051 compiled in. 
(Download SDCC 2.9.0 VC6 modified source code <a href="../../../ar1688/download/misc/vc6sdcc.rar">here</a>)
<br />We need open source 8051 compiler too because our <a href="../../../ar1688/module.html">AR168M</a> VoIP demo application was built on a 8051 controller.
<br />To keep up with my 64-bit Windows Vista, I will not learn any other 8-bit CPU besides Z80 (in AR1688) and 8051 (in <a href="../../../pa1688/index.html">PA1688</a>) any more.
<a href="../palmmicro/20080326.php">Palmmicro</a> is also moving into 64-bit in 2009.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
