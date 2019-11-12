<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>SDCC编译器2.9.0</title>
<meta name="description" content="在2006年的时候, 我们最初的AR1688软件API使用的是SDCC 2.6.0. 现在3年过去, 在软件版本0.44中, 已经是SDCC 2.9.0. 除了其中的Z80部分, 也开始用8051部分了.">
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
<tr><td class=THead><B>SDCC编译器2.9.0</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年3月29日</td></tr>
<tr><td>一年一度的, 开放源代码编译器<a href="../../../res/indexcn.html#sdcc">SDCC</a>(英文对应的意思是给小处理器用的C语言编译器)的开发团队会更新一个主要版本. 今年的2.9.0在3月22号正式发布.
<br />这个编译器在Windows下的执行程序仍旧是用MSVC 6.0编译的. 不过Windows Vista已经不再支持10年前的MSVC 6.0了. 由于上周我几乎一直带着我的Windows Vista笔记本在外面跑, 一直拖到这个周末才有条件来测试这个新版本. 
<br />在2.9.0的新功能说明中只有一条跟AR1688用的Z80有关,
<font color=gray>many optimizations to reduce code size and increase speed in the Z80 backend (对Z80进行了大量编译优化工作, 减小了代码量, 加快了执行速度)</font>.
跟2008年5月发布的2.8.0相比, 代码量的确减小了些. 但是2.9.0编译出来的代码量其实是大于AR1688从去年11月0.40软件开始使用的2.8.3测试版本.
无论如何, 我相信正式发布的2.9.0会比2.8.3好, 因此我们打算在AR1688 <a href="../../../ar1688/software/sw044cn.html">0.44</a>的软件发布中包括SDCC 2.9.0. 
<br />跟往常一样, SDCC编译器会在<a href="20061211cn.php">API</a>的SDCC\bin的目录下. 跟直接从SourceForge下载的Windows可执行文件相比, 我们单独编译的版本会小些, 因为它只包括了Z80和8051的部分.
(在<a href="../../../ar1688/download/misc/vc6sdcc.rar">这里</a>下载修改过的SDCC 2.9.0 VC6源代码)
<br />我们需要开放源代码的8051编译器, 因为我们在<a href="../../../ar1688/modulecn.html">AR168M</a>网络电话模块的示例软硬件中使用了一个8051.
为了与时俱进跟上我的64位的Windows Vista, 我决心不再学习Z80(AR1688)和8051(<a href="../../../pa1688/indexcn.html">PA1688</a>)以外的其它8位CPU了. <a href="../palmmicro/20080326cn.php">Palmmicro</a>也要在2009年加入到64位的时代潮流中. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
