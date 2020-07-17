<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - G.729 Test Vectors</title>
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>From PA1688 to PA6488 - G.729 Test Vectors</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 13, 2010</td></tr>
<tr><td>We have been using G.729 test vectors to test if hardware is stable from PA1688 to PA6488.
<br /><a href="../../../pa1688/index.html">PA1688</a> has a SDRAM interface with very weak driving power. There was panic when we found many customers boards can not work steadily. We needed a method to test in exact bits rather than making a phone call. 
Then we came to the idea of using our DSP developers data of G.723.1 and <a href="../ar1688/20070307.php">G.729</a> test vectors. Based on those data, we provided with all manufacturers detail steps to verify each hardware board by running the test sequences and compare data bit exactly.
<br /><a href="../../../ar1688/index.html">AR1688</a> does not need external DRAM, but we still need to test how fast our DSP can run stably and how <a href="../ar1688/20070216.php">different</a> it was with PA1688. As normal AR1688 device does not have enough space to hold so many test data, 
we were using <a href="../ar1688/20101202.php">AR168DS</a> programmer, which has 4pcs extra program flash, to run the G.729 test vectors.
<br />Now we need to test both DSP speed and DDR2 DRAM interface with <a href="../../../pa6488/index.html">PA6488</a> devices. Although we have no plan to use G.729 with PA6488 devices, 
we still have decided to use its <a href="../../../pa6488/software/devguide/testvectors.html">test vectors</a> in our hardware test, mostly because I like to do repeated jobs. As it is the 3rd time to do the same job, I have finished the calling interfaces and testing process very quickly. 
<br />However, I am never an algorithm guy. What I know about G.729 is only those calling interfaces. All <a href="../palmmicro/20080326.php">Palmmicro</a> G.729 implementations were done by Ph.D candidates in the past 12 years.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>

