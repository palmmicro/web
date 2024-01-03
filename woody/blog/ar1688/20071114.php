<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Frames per TX</title>
<?php EchoInsideHead(); ?>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>Frames per TX</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 14, 2007</td></tr>
<tr><td>In <a href="../../../ar1688/index.html">AR1688</a> option settings, "Frames per TX" can be set from 1 to 7, which means user can specify 1 to 7 voice frames in an outgoing ethernet packet. There is no limitation regarding incoming voice packet.
<br />When we calculated <a href="20071031.php">Speex</a> actual bandwidth usage, we only listed frames 1 to 4 in an ethernet packet. This is because we only allow max frames 4 in an ethernet packet for codec like Speex which has 20ms as voice frame time. And we only allow max frames 3 for codec like iLBC in 30ms frame mode. It is to prevent unexpected delay in conversation. Because we can not tell which codec will be actually used after codec negotiation. When frames 7 selected, if G.729 is being used, the delay is 70ms, but if <a href="20070307.php">iLBC</a> 30ms mode is being used, the delay will be 210ms, so we add the limitation to control total sending out delay within 90ms.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
