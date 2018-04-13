<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR168M VoIP模块高层用户界面协议</title>
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
<tr><td class=THead><B>AR168M VoIP模块高层用户界面协议</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年3月29日</td></tr>
<tr><td>随着0.30软件的发布，我们的<a href="../../../ar1688/modulecn.html">AR168M</a> VoIP模块软硬件已经全部完工，目前可以小批量供货。
<br />为了测试<a href="20080225cn.php">模块</a>，我们用了一个外部8051控制器配合模块实现了一个完整的网络电话参考设计。跟其它<a href="../../../ar1688/indexcn.html">AR1688</a>标准硬件设计一样，我们提供8051的硬件原理图。位于SDCC\mcs51下的8051软件也是公开源代码的，并且同样用SDCC编译。软件<a href="20061211cn.php">API</a>的用户可以用同样的SDCC\bin\sdcc.exe编译AR1688软件和8051软件。
<br />为了完成8051的网络电话参考设计，我们需要在原有的<a href="20071119cn.php">串口</a>功能上定义高层<a href="../../../ar1688/software/devguide/uiprotocolcn.html">用户界面协议</a>。组织结构相当好的8051源代码可以帮助理解这篇文章中的内容，大部分用户界面处理的细节代码在SDCC\mcs51\ui.c中。
<br />欢迎大家给我们提出评论和建议完善设计。
<br />&nbsp;
<br /><font color=magenta>2011年12月18日更新</font>
<br />尽管在开始的时候，我们的网络语音模块高层用户界面协议只是出于演示的目的，它们现在已经被用到了几个真正的产品当中。上周有个国内客户要求我们通过串口增加一个"登录成功"的指示，告诉我们他仅使用了标准的AR168M软件，昨天我因此在演示协议中增加了STAT状态报告命令。
<br />&nbsp;
<br /><font color=magenta>2012年9月12日更新</font>
<br />最近我们一个用户想在<a href="../../../ar1688/roipcn.html">RoIP</a>软件上增加文本交换的功能，于是我们在演示协议中增加了第7条TEXT命令。
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
