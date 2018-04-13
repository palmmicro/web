<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>EFSL文件系统</title>
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
<tr><td class=THead><B>EFSL文件系统</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2010年12月25日</td></tr>
<tr><td>1999年的时候我写了第一个非PC上跑的软件，用来管理Palm1硬件中SDRAM的FAT文件系统，通过UART跟PC交换文件。后来Palm1被叫做了<a href="../../../pa1688/indexcn.html">PA1688</a>。
<br />Palm1最初是为mp3播放器和数码相机设计，因此我们需要跟PC交换和管理文件。从硬件角度来说，至少对mp3播放器而言，Palm1是个合适的结构。后来很多同样8位控制器加ADSP2181兼容DSP结构的mp3芯片在市场上的成功证明了这一点。基于Palm1的mp3播放器没有获得成功，主要原因是我们的软件不够好，其中就包括了我笨拙的FAT。
<br />在2003年底的新年晚餐后，当只剩我们4个人还在桌子边上时，<a href="../palmmicro/20061123cn.php">王老板</a>对王翰晟、秦晓懿和我说：我一世英名，毁在你们手上。虽然他看起来是在开玩笑，当时我还是比较惊讶的。不过后来我意识到他是正确的。 
<br />不过对我个人而言就不同了。虽然这个FAT软件没有用在任何实际产品中，但是它是我嵌入式软件开发的出发点，直接导致了后来2000年的<a href="../ar1688/20080615cn.php">RTL8019AS</a>软件以及我们VoIP生意的开始。
<br />当<a href="../../../pa6488/indexcn.html">PA6488</a>再次需要文件系统管理DRAM时，我首先想到了我的老FAT。不过我很快就发现这是个坏主意。当年的我缺乏<a href="../ar1688/20080811cn.php">标准</a>意识，最终的版本是个为代码大小和运行性能过度优化的非标准FAT，而且代码本身组织得也很糟糕。
<br />最终我选择了开放源代码的<a href="../../../pa6488/software/devguide/filesystemcn.html">EFSL文件系统</a>。同样有2个选择，版本0.3.6还是0.2.8。当我发现0.3.6的文档自从0.2.8就没有更新后，我决定采用稳定版本0.2.8。
<br />在EFSL标准FAT支持下，我们可以在将来扩展更多功能。例如<a href="20090819cn.php">PA648C</a>视频压缩模块目前没有本地存储功能，但是我们可以扩展接SD卡，用同样的EFSL软件管理它。
<br />一般来说文件系统是操作系统3大功能之一。不过跟PA1688和<a href="../../../ar1688/indexcn.html">AR1688</a>一样，我们在PA6488上仍然没有采用任何操作系统。
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
