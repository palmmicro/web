<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>The End of IAX2</title>
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>The End of IAX2</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 13, 2011</td></tr>
<tr><td>Yesterday Tang Li fixed an <a href="../ar1688/20071110.php">IAX2</a> outgoing voice bug when used as callee. This bug was the result of <a href="../../../pa1688/software/sw157.html">1.57</a> changes back in 4 and a half years ago.
An user added remote ring back tone for IAX2 and we merged the source code changes without careful test. 
<br />It is surprising this obvious bug was not found until recently reported by another user.
Considering that our website has very steady <a href="20110814.php">visitors</a> about 1k per month, and over half of them are looking for <a href="../../../pa1688/index.html">PA1688</a> software update,
the only explanation would be that nobody is interested in IAX2 any more.
<br />We were <a href="../ar1688/20070321.php">proudly</a> to support 7 different communication protocols in PA1688, but wisely reduced to <a href="../ar1688/20060929.php">SIP</a> and IAX2 only with <a href="../../../ar1688/index.html">AR1688</a>. As video and voice over IP market getting mature today,
now I believe SIP will be the only one we need to support with the coming <a href="../../../pa6488/index.html">PA6488</a> solution.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
