<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688编程第一课</title>
<meta name="description" content="在Palmmicro AR1688方案卖了4年多后来写编程第一课实在是太晚了, 不过晚总比没有好. 内容有: 如何改变显示类型, 增加一个c语言源文件, 增加G.729语音提示.">
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
<tr><td class=THead><B>AR1688编程第一课</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年3月31日</td></tr>
<tr><td>在AR1688卖了4年多后来写编程第一课实在是太晚了, 不过晚总比没有好. 
总是有人问<font color=grey>怎么把显示屏上的<a href="20070903cn.php">GP1266</a>字样改成我自己的字符串</font>? 刚刚我又读了一封这种邮件, 于是开始写这篇文章. 
<br />其实这篇文章没有多少可写的内容. 在软件<a href="../pa6488/20090811cn.php">API</a>的sdcc\src\<B>ui_str.c</B>中有个叫<i>LoadString</i>的函数, 
其中已经有了好几个<a href="../pa6488/20090816cn.php">OEM_XXXX</a>特殊显示的字符串的改动了.  
<br />要注意的是, 改<i>LoadString</i>不仅会改动显示屏内容, 同时也会改变SIP消息<b>User-Agent</b>中的内容. 
<br />&nbsp;
</td></tr>

<tr><td class=Update>2012年1月7日更新</td></tr>
<tr><td>很多用户都需要增加自己的UDP或者<a href="../../../ar1688/faqcn.html#tcp">TCP</a>连接. 在AR1688软件中每个连接都在一个单独的文件中实现. 
这一课讲如果在AR1688软件<a href="20061211cn.php">API</a>中增加一个文件. 具体步骤: 
<ol>
  <li>决定新的文件放在哪个<a href="20080706cn.php">页面</a>. 我们推荐把TCP连接放在3, UDP连接放在2.</li>
  <li>修改sdcc\src\<a href="20070609cn.php">makefile</a>中跟.c文件相关的2处地方.</li>
  <li>把新的.rel文件添加到sdcc\src\<b>linkmain.lnk</b>. 不要把它加到文件末尾, 而要加到同一个页面的其他.rel文件一起. 
      否则编译时会有类似于<font color=red>Error: banked code exceeded bank 7 end (default 0xe000)</font>的信息. 或者更糟糕的是, 没有出错信息, 但是链接后的文件结果是错误的.</li>
  <li>不要在新文件中做类似于<font color=grey>UDP_SOCKET _pTestSocket = NULL;</font>这样的全局变量初始化(也不要在其它老文件中加全局变量初始化), 把初始化代码放在例如<i>SntpInit</i>这样的函数中. 
      否则编译时会有类似于<font color=red>Error: sram code exceeded code end (default 0x2000)</font>的信息. 
      在我们分页面的代码结构下, <a href="20101123cn.php">SDCC</a>不能把全局变量初始化的代码生成在我们需要的地址范围中.</li>
</ol>
<br />&nbsp;
</td></tr>

<tr><td class=Update>2012年2月26日更新</td></tr>
<tr><td>原来我们设计了PCMU格式的<a href="20110307cn.php">语音提示</a>, 用于在没有LCD的AR1688设备上方便的用语音播放IP地址. 
最近几个月来有几个<a href="../../../ar1688/modulecn.html">AR168M</a>网络语音模块的客户都希望能够在通话过程中根据对方按键播放语音提示. 
并且其中一个还在积极开发<a href="../pa6488/20101213cn.php">G.729</a>语音提示功能. 本课程的内容主要在过去一周对他们的技术支持当中产生. 
<br />首先我们要准备压缩好的G.729数据. 压缩工作可以由<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>完成, 而且PalmTool的全部源代码都提供在PA1688软件API中, 
最新的版本是<a href="../../../pa1688/software/sw168cn.html">1.68</a>. 其中G.729源代码下载于<a href="http://www.itu.int/ITU-T/" target=_blank>ITU-T</a>. 
<br />在<a href="../../../ar1688/software/sw057cn.html">0.57</a>.006演示软件代码中, 我们采用了更简单的方法得到G.729压缩数据. 
PA1688的<a href="../../../pa1688/ringcn.html">自定义铃声</a>由G.723.1和G.729压缩数据合并而成, 前2/5是G.723.1, 后3/5是G.729格式. 我下载了PA1688铃声<b>alice.dat</b>, 重新命名为<b>font_alice.dat</b>后存在了sdcc\src\res下. 
<br />下一步我们要把G.729数据存放到程序存储器. 跟PCMU一样, 我们仍旧使用<a href="20070605cn.php">字库页面</a>8-11. 
为简化更新过程, 我们现在支持类似于<font color=grey>tftp -i xxx.xxx.xxx.xxx put font_alice.dat</font>的命令行来直接升级字库和IVR语音提示文件. 
<br />接着我们需要读G.729数据并且在通话过程中送给对方. 由于数据存放在程序存储器中, 读数据的代码就不能再在程序存储器中运行, 而需要运行在<a href="20080706cn.php">SRAM</a>中. 一个好的选择是<B>main.c</B>. 
我们还需要方便的定时把数据送给对方. 由于DSP在大多数时候都会定时调用<B>main.c</B>中的<i>TaskOutgoingData</i>函数, 这里是个合适的地方用程序存储器中读出来的数据替换DSP编码出来的G.729数据. 
演示代码用<B><i>SYS_IVR_G729</i></B>定义区分开, 在用新增加的<B><i>OEM_IVRG729</i></B>和老的<a href="20120213cn.php">OEM_ROIP</a>编译选项编译时候会被包括进来. 
<br />最后我需要指出的是, 这个演示代码很原始, 还需要不少改进才能用在实际产品当中. 例如在替换G.729数据时, 总该判断一下当前是否在使用G.729 CODEC. 
另外在RoIP应用中使用<a href="20090416cn.php">VAD</a>的情况下, <i>TaskOutgoingData</i>函数可能会因为判断没有语音而不被调用到, 发送数据的工作就需要在<B>isr_gpio.c</B>中的<i>_10msCounter</i>函数里定时完成. 
还有, 当G.729数据超过32k字节后, 还需要更多的代码来换页. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
