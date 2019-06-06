<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>软件API内容</title>
<meta name="description" content="跟PA1688一样, 我们为AR1688用户提供软件API. 这里是按目录分类的内容介绍. 利用API用户可以为自己的网络电话定制升级文件, 同时还可以协助我们开发额外的功能. ">
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
<tr><td class=THead><B>软件API内容</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2006年12月11日</td></tr>
<tr><td>我们为所有的<a href="../../../ar1688/indexcn.html">AR1688</a>网络电话生产厂家和用户提供软件API. API包括源代码和目标文件, 其中源代码基于GPL版权. 利用API用户可以为自己的网络电话定制升级文件. 我们不提供全部的源代码, 因为我们不鼓励其它人把它移植到AR1688的竞争芯片上. 
<br />API以sdcc.rar的方式提供, 解压缩以后产生SDCC目录和文件. 我们设定SDCC目录是被解压缩到D盘. 如果不是的话则必须改动SDCC\src\<b>makefile</b>的第一行. 
<br />目前SDCC下有以下5个目录: 
<br />1. bin - <a href="../../../res/indexcn.html#sdcc">SDCC</a>开源的编译器和我们自己特殊的编译工具. 目前我们使用SDCC 2.6.0稳定版本. 你也可以到SDCC官方网站上下载相关文件. 这里的<b>sdcc.exe</b>文件比官方网站上的要小, 因为我们只编译了Z80部分. gnu的<b>make.exe</b>也放在这里. 
<br />2. include - .h文件. 我们只使用SDCC编译器, 不用它自带的include和库文件. 所有的.h文件都是我们自己写的, 和标准的c语言库函数的参数相比有一些小的区别. 而且并不是所有的c语言函数库都在, 只包括那些需要用到的. 我们这样做是基于性能上的考虑. 
<br />3. lib - 放在这里的实际上不是库文件, 而是一些没有提供源代码的文件编译出来的目标文件, 用于链接阶段. 和include一样, 我们完全不使用跟标准SDCC函数库. 
<br />4. src - 源代码, 包括产生升级文件所需的<b>makefile</b>和批处理文件. 所有跟用户界面和VoIP协议相关的代码都是公开源程序的. 按照代码大小估算, 80%以上的源代码都公开在这个API中. 
<br />5. tool - bin目录中我们自己特殊的编译工具的全部源代码, 以及相关的MS Visual C++ 6.0项目文件. 
<br />&nbsp;
<br /><font color=magenta>2007年5月14日更新</font>
<br />从<a href="20070405cn.php#20070514">0.12</a>版本开始SDCC设定到C盘. 
<br />&nbsp;
<br /><font color=magenta>2010年8月18日更新</font>
<br />从<a href="20100818cn.php">0.48</a>版本开始SDCC\bin下工具的编译器升级到VC2008. 
<br />&nbsp;
<br /><font color=magenta>2014年6月15日更新</font>
<br />SDCC\bin下工具的编译器升级到<a href="../entertainment/20140615cn.php">Visual Studio 2013</a>. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
