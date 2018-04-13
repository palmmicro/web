<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>活动语音检测</title>
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
<tr><td class=THead><B>活动语音检测</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年4月16日</td></tr>
<tr><td>在ITU G.729B和G.723.1语音压缩标准中把活动语音检测(VAD)作为算法的一部分后，VAD的概念被普遍接受。Cisco使用得比G.729B成文更早一点点。在Cisco系统中，语音会先用VAD系统进行预处理，然后再送到标准G.711或者G.729语音编码器中压缩。在开放源代码的<a href="20071031cn.php">Speex</a>中的处理方式跟Cisco类似，VAD是独立于Speex算法本身的一个预处理部分。
<br />在G.729B和G.723.1标准发布超过13年后，我们逐步认识到其实VAD在今天的网络电话中已经没有什么用处。我们已经不再在乎它能节省的那一点<a href="20071110cn.php">带宽</a>。对它能带来的功耗方面的降低也不见得很重视。相反，独立于压缩算法的VAD经常会给语音质量带来负面影响，增加网络抖动处理模块的复杂度。因此，如果话机不用G.729B和G.723.1的话，VAD的选项就完全多余。
<br />其实不止我们有这种想法，GIPS的开放源代码<a href="20070307cn.php">iLBC</a>算法中就没有VAD部分，在它的VoiceEngine产品中也没有包括VAD。今天重要的是AGC、AEC和带动态抖动缓冲区处理的PLC。
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
