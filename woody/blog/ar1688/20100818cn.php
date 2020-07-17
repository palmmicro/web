<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>用VC2008编译AR1688 Windows下工具</title>
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
<tr><td class=THead><B>用VC2008编译AR1688 Windows下工具</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2010年8月18日</td></tr>
<tr><td>20个月前我换下老的Sony PCG-K23, 开始用Sony VGN-FW235J. 
但是老机器一直没有停止维护使用, 因为我需要<a href="../entertainment/20100529cn.php">Visual C++</a> 6.0编译AR1688和<a href="../../../pa1688/indexcn.html">PA1688</a> Windows下的工具. 
在这个过程中, 执着的微软自动升级终于成功地把我的老机器改造成了光跑VC6一个程序都嫌太慢的废物. 我不得不开始用新机器上的VC2008来编译AR1688工具.  
<br>很快我发现已经有人做过了这个升级工作, 所有工具都能在multi-byte设置下成功编译, 但是最明显的问题是, 在我64位Vista系统下, Manager.exe的调试信息输出不正常. 
<br>我决定全部改用缺省的新的unicode选项编译. 结果这个工作大大超出了我的预期时间. 原来代码中混合使用memcpy/strcmp和CString的编程方式在unicode下带来了无穷无尽的麻烦问题. 
<br>从目前测试来看升级结果还算好. 尤其让我觉得有趣的是, 用multi-byte编译时, 所有hex2bin.exe这样的命令行工具都比以前小了30%, 而改用unicode后又减小了10%. 图形界面的Manager.exe也比以前小了一点点. 结果现在总的压缩后软件API小了10%, 从2.4M字节降到了2.2M字节. 
<br>接下来我试图把<a href="20090329cn.php">SDCC 2.9.0</a>也从VC6升级到VC2008, 但是折腾了几个小时后被迫放弃. 问题实在太多了, 无论是multi-byte还是unicode都无法编译成功. 目前我们还只能使用VC6编译的SDCC, 还好我们不需要经常改动它. 等以后SDCC 3.0.0发布的时候, 我们就只能用mingw/gcc编译的SDCC了. 
<br>在这里顺便宣布发布<a href="../../../ar1688/indexcn.html">AR1688</a> 0.48软件的第一个测试版本0.47.021, 此版本的软件API已经可以从我们网站<a href="../../../ar1688/software/snapshotcn.html">下载</a>. <a href="../../../ar1688/software/sw048cn.html">0.48</a>正式版本计划在10月1号发布. 
<br>因为AR1688工具现在是用Microsoft Visual Studio 2008 (VC9)和Windows SDK v7.1编译的, 在运行它们前用户可能需要从<a href="http://www.microsoft.com/downloads/details.aspx?FamilyID=9b2da534-3e03-4391-8a4d-074b9f2bc1bf&displaylang=en" target=_blank>微软下载</a>和安装VC9的可再发行组件包. 这个包有1.8M字节, 比Microsoft Visual Studio 2010 (VC10)的5M字节可再发行组件包小不少, 但是比我熟悉的MFC42.dll可大得太多了. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
