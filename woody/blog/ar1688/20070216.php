<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Why Support ADPCM G.726 32k Codec</title>
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
<tr><td class=THead><B>Why Support ADPCM G.726 32k Codec</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Feb 16, 2007</td></tr>
<tr><td>AR1688 software development is slow. It took us 4 weeks to move from software version 0.06 to 0.07 and still failed to provide a steady iLBC codec support in version 0.07. Instead, we added ADPCM G.726 32k codec support in this version. We have never supported G.726 in <a href="../../../pa1688/index.html">PA1688</a> before because we never think it is important. And we do not think G.726 is important neither with AR1688. The reason we added it, is because we met so many unexpected problem with iLBC, and we have to run something simpler to test the DSP core inside AR1688. With G.711, GSM 6.10, ADPCM G.726 32k and a LMS based echo cancellation algorithm running on <a href="../../../ar1688/index.html">AR1688</a> steadily. We have least found 3 problems related with DSP instructions:
<br />1. af = reg + const instruction will not give correct answer and will not set flag correctly
<br />2. m register can not be set to negative value when used with circle buffer
<br />3. cntr will be pushed immediately on to counter stack instead of waiting for "do" instructions executed, not consistent with standard ADSP21xx
<br />Hopefully, all bad news are over and we can release iLBC support soon. The good news is, most people reporting that AR1688 voice quality is greater than PA1688. And with our internal test, it not only has better quality, it also has less hardware delay and runs more steadily.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
