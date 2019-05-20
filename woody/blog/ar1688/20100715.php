<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>No Proprietary Forks</title>
<meta name="description" content="To reduce software support work, Palmmicro never forks software. To keep a single version, we only roll back our software when something is seriously wrong.">
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
<tr><td class=THead><B>No Proprietary Forks</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>July 15, 2010
<br />I read the email about commercial licensing for x264 the day before yesterday, it said about no proprietary forks twice. I really love those people, not only because they are doing a great job, but also the working style of them.
<br />We never support proprietary forks neither, it is well-known and heavily complained that we always ask user to upgrade to the most recent steady version, before we do any technical support. 
<br />To always keep only one version, we sometimes need to do roll backs, often unwillingly of course. A major roll back on AR1688 DSP works was done recently as users' test indicating unsteady working problems since 0.44. We had to use old 0.42 DSP code now in our 0.47 test version.
<br />This roll back means the complete failure of our efforts on <a href="20090417.php">acoustic echo cancellation</a> and de-jitter between 0.44 and 0.46 software version. We had to admit that we can only do a low-end VoIP job with <a href="../../../ar1688/index.html">AR1688</a>, just as we did with <a href="../../../pa1688/index.html">PA1688</a>. Hopefully our <a href="../../../pa6488/index.html">PA6488</a> solution can do a better job in the near future.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
