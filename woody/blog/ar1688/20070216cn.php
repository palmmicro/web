<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>为什么支持ADPCM G.726 32k编码算法</title>
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
<tr><td class=THead><B>为什么支持ADPCM G.726 32k编码算法</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年2月16日</td></tr>
<tr><td>AR1688软件开发进度缓慢. 我们花了4个星期时间从0.06挪到0.07版本, 并且iLBC在0.07版本中还不能稳定工作, 反而在这个版本中加入了ADPCM G.726 32k编码算法. 在<a href="../../../pa1688/indexcn.html">PA1688</a>上我们从来没有支持过G.726因为我们从来都不觉得它重要. 其实在AR1688上我们也不觉得G.726重要. 我们开发它是因为iLBC上出了很多没有预料到的问题, 我们需要一个简单点的算法测试AR1688的DSP. 目前G.711, GSM 6.10, ADPCM G.726 32k和一个基于LMS的回声抵消算法都已经在<a href="../../../ar1688/indexcn.html">AR1688</a>上稳定工作了, 我们也通过这些算法发现了至少3个DSP指令上的问题: 
<br />1. af = reg + const指令给出的结果不对, 也不会正确设置标志位
<br />2. m寄存器跟循环缓冲区一起用的时候不能为负值
<br />3. cntr会被马上压到counter堆栈中, 而不是跟标准的ADSP21xx那样等到"do"指令执行以后才入栈
<br />希望所有的坏消息告一段落, 我们能够很快发布iLBC编码算法. 好消息是, 绝大多数用户都反应AR1688语音质量明显好于PA1688. 在我们内部测试中, 不仅质量更好, 并且有更低的硬件延时, 稳定性也好很多. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
