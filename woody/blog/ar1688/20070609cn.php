<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>如何在Linux下编译AR1688 API</title>
<meta name="keywords" content="Linux下编译AR1688软件">
<meta name="description" content="从AR1688开始提供软件API的那一天开始, 就有客户问能不能在Linux下编译. 我写了些指导意见, 经过6年的等待后, Alex Vangelov最终做成了这件事! ">
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
<tr><td class=THead><B>如何在Linux下编译AR1688 API</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年6月9日</td></tr>
<tr><td>这是个经常被问到的AR1688软件<a href="20061211cn.php">API</a>问题. 答案是可能, 但是需要额外的工作. 检查SDCC\src下的makefile, 其中用了4个工具: 
<br />AZ80 = $(PATH_SDCC)BIN\as-z80
<br />CZ80 = $(PATH_SDCC)BIN\sdcc
<br />LZ80 = $(PATH_SDCC)BIN\link-z80
<br />HEX2BIN = $(PATH_SDCC)BIN\hex2bin
<br />前3个工具是SDCC自带的, 只要下载SDCC Linux下编译好的相应软件替换即可. 目前我们使用最新的稳定版本2.7.0. 
<br />最后一个hex2bin和我们自己写的, 它的源代码在SDCC\tool\hex2bin中. 它是一个命令行工具, 源程序中大量使用了Windows MFC风格的CFile和CString, Linux用户需要修改相应代码后重新编译. 
<br />除了在Linux下编译外, 用户可能还需要在Linux下调试. 唯一的调试手段是用UDP广播输出调试信息. PA1688软件API中带的PalmTool用来接收和显示调试信息. 如果真的要有效开发的话, 
用户需要把<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>也移植到Linux下. 
<br />另外还有些命令行工具, 例如我们用SDCC\tool\convert转换话机设置. 不过修改设置这些工作可以用网页设置界面完成, 不需要再多移植程序到Linux下了. 
<br />&nbsp;
<br /><font color=magenta>2008年8月11日更新</font>
<br />从AR1688 <a href="20080811cn.php">0.37</a>版本后不再使用PalmTool调试, 改为使用SDCC\bin\<b>manager.exe</b>. 
<br />&nbsp;
<br /><font color=magenta>2010年11月23日更新</font>
<br />从SDCC版本<a href="20101123.php">3.0.0</a>开始Z80编译和链接工具名字改为<b>sdasz80.exe</b>和<b>sdld.exe</b>. 
<br />&nbsp;
<br /><font color=magenta>2013年3月10日更新</font>
<br />差不多六年后, 最近Alex Vangelov终于完成了它. 显然他对于编程序的想法和我一致, 在他的邮件开头赫然写着<font color=grey>Just for fun(仅仅是娱乐)</font>.
<br />由于我是一个<a href="../entertainment/20120719cn.php">Linux</a>编程新手, 我特别有兴趣的把他的代码合并到了我们AR1688软件代码数据库中, 并且做了如下记录:
<br />1) <font color=grey>Ne2000.h is renamed to ne2000.h, unix is case sensitive. (Ne2000.h重新命名为ne2000.h, unix区分大小写.)</font> 类似的还修改了很多sdcc\tool下<b>stdafx.h</b>有关的文件.
虽然我已经不记得为什么<b>Ne2000.h</b>成为了sdcc\include下唯一混合了大小写的文件, 我很清楚是<a href="20100818cn.php">Visual Studio</a>自动产生了这些<b>StdAfx.h</b>, 并且以<b>stdafx.h</b>的名字包含在不同的文件中.
看上去象是微软显示自己跟Unix不同的一种方式.
<br />2) <font color=grey>Path notation changed from "\\" to "/" in some files for compatibility. (为了兼容性, 某些文件中的路径记号"\\"改为"/".)</font> 这显然是微软显示自己不同的另外一个方式.
其结果是, 现在不仅象<a href="20101123cn.php">SDCC</a>这样的跨平台编译器知道如何处理这总混乱局面, 事实上VC2008也能. 在我的调试过程中, 我甚至发现VC2008能正确处理路径名写成C:\sdcc\src/settings/<b>default_sip.txt</b>的文件! 
<br />3) 在sdcc\tool\common下增加了<b>mfc2std.h</b>文件, 用来替代常用的MFC类库如CString. 虽然我不认为我会为了兼容性而完全使用标准C来写下一个PC程序, 我至少会记住把所有MFC相关的代码放在单独不同的地方.
<br />4) <font color=grey>relink tool generates linkmain_unix.lnk with linux paths, instead rewriting the existing file. (relink工具在Linux下产生新的linkmain_unix.lnk文件,而不是覆盖原有文件.)</font>
<br />5) <font color=grey>Tested on Fedora and Gentoo linux with sdcc version 3.2.0. (在Fedora和Gentoo linux下使用sdcc版本3.2.0测试通过.)</font>
这里就需要特别<font color=red>小心</font>了! 因为SDCC 3.2.0有已知的潜在<a href="20111007cn.php#20120813">问题</a>!
<br />所以好消息是, 我们<a href="../../../ar1688/software/sw061cn.html">现在</a>有了自己的在Linux下编译AR1688 API的工具. 但是坏消息是, 我们没有合适的SDCC版本!
目前使用的<a href="20101123cn.php#20101208">3.0.1 #6078</a>不同于3.0.0, 而且我们没有保存这个临时版本的源代码, 所以无法基于它编译一个Linux版本来使用.
而3.1.0和3.2.0都有潜在问题. 我不得不再次开始调试SDCC目前的最新测试版本, 希望能找到一个可用的. 上周五的的时候我在SDCC网上提交了第23个错误报告.
<br />&nbsp;
</td></tr>
<tr><td class=Update>2013年3月11日更新</td></tr>
<tr><td>Alex指出可以在SourceForge svn中下载#6078源代码. 同时他再次修改了sdcc\<b>Makefile</b>, 包括了下载和编译SDCC #6078版本的步骤. 
<br /><font color=grey>attached modified Makefile with new action "make sdcc", that downloads sdcc revision #6078 from https://sdcc.svn.sourceforge.net/svnroot/sdcc/trunk/sdcc (only z80 related files) in folder ./sdcc_6078.
executes configure && make and creates symbolic links of compiled sdcc tools in ./bin folder
<br />* svn command required
<br />result:
<br />SDCC : z80 3.0.1 #6078 (Mar 11 2013) (Linux)
<br />to use local version of sdcc with mk command: in src/Makefile at line 17
<br />AZ80 = ../bin/sdasz80
<br />CZ80 = ../bin/sdcc
<br />LZ80 = ../bin/sdld
<br />* "make sdcc" is optional and not included in "make all"
</font>
<br />为保险起见, 我下载了#6078的<a href="../../../ar1688/download/misc/sdcc6078.tar.gz">打包文件</a>, 放到了自己的网站上!
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
