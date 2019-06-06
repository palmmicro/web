<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - G.729测试序列</title>
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
<tr><td class=THead><B>从PA1688到PA6488 - G.729测试序列</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2010年12月13日</td></tr>
<tr><td>从PA1688到PA6488, 我们一直在用G.729测试序列测试硬件的稳定性. 
<br /><a href="../../../pa1688/indexcn.html">PA1688</a>有个驱动能力极弱的SDRAM接口. 只能用恐慌来描述当时我们发现不少客户的硬件不能稳定工作的情形. 我们需要一个精确测试数据的方式, 而不是打个电话听听声音. 然后我们想到了用DSP开发人员使用的G.723.1和<a href="../ar1688/20070307cn.php">G.729</a>测试序列数据. 基于这些数据, 我们提供给了所有客户详细的步骤和方法, 通过测试序列的精确数据对比来确认全部硬件是否稳定. 
<br /><a href="../../../ar1688/indexcn.html">AR1688</a>不需要外部的DRAM. 但是我们仍然需要测试DSP的最高稳定运行速度以及跟PA1688 DSP的<a href="../ar1688/20070216cn.php">区别</a>. 由于普通AR1688设备没有足够的地方放这些测试数据, 我们使用了有4片额外程序存储器的<a href="../ar1688/20101202cn.php">AR168DS</a>烧录器运行G.729测试序列. 
<br />现在我们需要测试<a href="../../../pa6488/indexcn.html">PA6488</a>设备DSP的速度以及DDR2 DRAM接口的稳定程度. 虽然我们并没有在PA6488产品上使用G.729的计划, 我们还是决定用它的<a href="../../../pa6488/software/devguide/testvectorscn.html">测试序列</a>来测试硬件. 当然主要原因是因为我喜欢做重复的工作. 由于这已经是我第3次做同样的事情了, 我很快就完成了调用接口和测试流程的代码.  
<br />不过我从来都不是一个搞算法的人. 对于G.729我仅仅知道调用接口而已. 在过去12年来, 全部Palmmicro的G.729实现都是由读博士的人完成的. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
