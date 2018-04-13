<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Acoustic Echo Cancellation</title>
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
<tr><td class=THead><B>Acoustic Echo Cancellation</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 17, 2009</td></tr>
<tr><td>For many years AR1688 and <a href="../../../pa1688/index.html">PA1688</a> based IP phones do not have speaker phone function. This is a major reason that we are considered as a low-end VoIP device designer. Finally in this month, we will release the first version of AEC running on AR1688 with <a href="../../../ar1688/software/sw044.html">0.44</a> software. With this version, users will be able to use speaker phone with G.711. Although this first version can not work as good as those from GIPS yet, we have confidence to improve it in later software versions.
<br />The new AEC can work with all current <a href="../../../ar1688/index.html">AR1688</a> based device. However the quality will vary a lot with different products. The major reason is that most of our old speaker phone hardware is not well designed to ensure the linear gain requirement of current AEC algorithm when output becomes louder. Users need to test and set the speaker output to a proper value in order to make sure the AEC algorithm will work in the way it is designed.
<br />We have also added a new "Ring Volume" option to help to use the speaker phone function more easily. "Ring Volume" can be set at higher value like 31 to ensure the incoming ring is loud enough. While the original "Speaker Output" can be set at a lower level like around 20 to make sure the AEC algorithm can work in good linear status.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
