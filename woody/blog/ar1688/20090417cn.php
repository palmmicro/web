<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>声学回声抵消</title>
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
<tr><td class=THead><B>声学回声抵消</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年4月17日</td></tr>
<tr><td>多年以来基于AR1688和<a href="../../../pa1688/indexcn.html">PA1688</a>的网络电话都不能支持免提通话. 主要是由于这个原因, 我们一直被认为只能设计低端的VoIP设备. 到这个月总算我们要在AR1688 <a href="../../../ar1688/software/sw044cn.html">0.44</a>的软件发布中加入第一版的声学回声抵消(AEC)的功能了. 在这个版本中, 用户可以用G.711算法进行免提通话. 虽然这个第一版的声学回声抵消效果还不能跟GIPS的相比, 好在我们有信心在以后的版本中不断改进它. 
<br />所有<a href="../../../ar1688/indexcn.html">AR1688</a>的设备都能通过软件升级使用这个新AEC算法. 但是具体的效果在不同产品上可能会大不相同. 效果不理想的主要原因是很多老的免提功放设计在音量大了以后都没有做到线形放大, 导致AEC自适应算法失效. 用户可能会需要根据具体情况选择合适的免提输出音量大小. 
<br />我们同时增加了新的"振铃音量"选项配合免提通话功能使用. "振铃音量"可以设置成比较大, 如最大值31, 这样铃声可以很大. 而原来的"免提输出音量"可以设置到20左右, 保证功放的线性放大, 使AEC算法能够正常起作用. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
