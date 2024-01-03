<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>GPIO控制</title>
<meta name="description" content="Palmmicro AR1688软件API中GPIO控制部分源代码的说明. 注意软件更新的频率远比网络日志高, 一切以最新的软件API内容为准, 这里的内容仅供入门参考. ">
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
<tr><td class=THead><B>GPIO控制</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年9月3日</td></tr>
<tr><td>在标准<a href="../../../ar1688/indexcn.html">AR1688</a>网络电话硬件参考设计中, 所有GPIO都用于键盘和LED. API 0.37版本以前我们只提供了键盘和LED的高层控制函数. 
<br />出乎意料的是, 一个新厂商不需要GPIO输出控制LED, 反而需要几个输入的GPIO. 为了让API简单并且减少代码大小, 我们决定在0.38软件发布中以源代码方式提供GPIO控制代码. 
<br />所以在目前的<a href="20061211cn.php">API</a>中增加了SDCC\inc\gpio_sfr.h文件, 具体控制的例子可以参考SDCC\src\led.c和function.c. 
<br />&nbsp;
<br /><font color=magenta>2008年9月15日更新</font>
<br />在目前开发的0.39和0.40版本软件中我们继续提供更多GPIO控制示例. 在SDCC\src目录下, 增加了5x6和7x8键盘设计用的<B>isr_gpio.c</B>和控制AM79R70 SLIC的<B>slic.c</B>. 
<br />5x6键盘用于AR168K和AR168KD网络电话参考设计, 2个设计都在不同厂家的样品阶段. 
<br />7x8键盘用于AR168J. 
<br />AM79R70用于AR168L和AR168LS单口网关参考设计, 软件还没有完全完工. 
<br />&nbsp;
<br /><font color=magenta>2013年2月19日更新</font>
<br /><a href="../../../ar1688/software/sw060cn.html">0.60</a>中删除了不成熟的网关硬件设计型号VER_AR168L/VER_AR168LS和相关SLIC代码<b>slic.c</b>. 
<br /><a href="../../../ar1688/software/sw061cn.html">0.61.002</a>中取消了<b>gpio_sfr.h</b>, 改为使用<b>sfr.h</b>. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
