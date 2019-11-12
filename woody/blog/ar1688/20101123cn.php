<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>SDCC 3.0.0之路</title>
<meta name="description" content="把AR1688软件的编译器从开放源代码的SDCC 2.9.0升级到3.0.0并不容易. 经过2个星期对各种开发版本的努力测试, 我们终于稳定到了3.0.1 #6078上.">
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
<tr><td class=THead><B>SDCC 3.0.0之路</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2010年11月23日</td></tr>
<tr><td><a href="../../../res/indexcn.html#sdcc">SDCC</a>开发团队用了19个月的时间从<a href="20090329cn.php">2.9.0</a>升级到11月1号发布的3.0.0. 看起来这段时间内做了不少内务整理工作. 发布特性列表中跟我们AR1688中Z80直接相关的有:
<font color=gray>
<br />* changed z80 and gb targets object file extension to .rel (z80和gb目标文件后缀改为.rel)
<br />* special sdcc keywords which are not preceded by a double underscore are deprecated in sdcc version 3.0.0 and higher. See section ANSI-Compliance in sdccman (版本3.0.0以及以后, 特殊sdcc关键字都统一到以双下划线开头, 参见sdccman的ANSI-Compliance部分)
<br />* asxxxx / aslink renamed to sdas / sdld and synchronized with ASXXXX V2.0 (asxxxx/aslink名字改为sdas/sdld, 跟ASXXXX V2.0同步)
</font>
<br />显然这些改动意味着我们代码中大量的相关改动.
部分由于我忙于<a href="../../../pa6488/indexcn.html">PA6488</a>工作, 部分由于我懒于<a href="20100715cn.php">分叉</a>一个测试版本, 我没有参与第1和2发布预览版本的测试.
但是当我开始测试3.0.0后, 我意识到自己犯了一个错误.
<br />看上去绝大多数世界上其它的Z80用户也跟我一样懒! 因此Z80部分不像8051部分测试得那么好. 我首先碰到了内嵌汇编代码不能编译的问题, 很快SDCC邮件列表上有人回答, 问题已知并且已经在最近新测试版本中修改.
然后我碰到了另外一个已知问题, 某些jp指令会被误优化成jr. 这次没有完成的修改, 好在已经有人在问题跟踪系统上发表了一个临时解决方法. 
<br />在修改了好几百处代码后, 我不希望返回等待. 我开始自己测试这个临时解决方法. 这个方法需要重新编译SDCC. 因为之前我已经试过在<a href="20100818cn.php">VC2008</a>上编译2.9.0并且失败了, 我只好开始学习在我的Windows Vista上用其它方法编译它. 
<br />我先安装了Cygwin, 经过几个小时后我看到了错误信息<font color=red>gcc options -mno-cygwin not used any more (gcc选项-mno-cygwin已经不再使用)</font>. 我意识到Cygwin上的编译也跟MSVC上的编译一样被放弃了. 现在唯一的办法只能是在Linux上用MinGW编译. 
<br />我下载了<a href="http://www.virtualbox.org/" target=_blank>VirtualBox</a>并且安装了它. 当我试图增加一个Linux虚拟机的时候它提示我要Linux DVD安装盘. 然后我下载了<a href="http://www.daemon-tools.cc/eng/products/dtLite" target=_blank>DAEMON Tools Lite</a>虚拟光驱和<a href="http://www.ubuntu.com/" target=_blank>ubuntu</a>-10.10-dvd-i386.iso文件作为Linux安装盘. 整个安装过程比我预想的顺利. 另外几个小时后我可以编译和测试了. 最终我用了一个更加安全的临时解决方法, 用它编译了现在的AR1688软件0.49.007. 
<br />结果很好, SDCC 3.0.0比2.9.0编译出来的代码小了5%. 对Z80来说, 这通常也意味着5%性能上的提高. 
<br />SDCC 3.0.0痛恨垃圾代码. 我在类似于<font color=gray>'T'</font>的常量前加了几百个<font color=gray>(UCHAR)</font>, 并且调整了不少const的字符串指针声明.
在<b>rc4.c</b>中, 原来写成<font color=gray>x = x + something</font>的会编译不了, 改成<font color=gray>x += something</font>才能编译.
最要命的经历来自我自己的<b>crt0.s</b>, 其中有一个空函数调用到了一个没有用的部分, 在2.9.0中没有问题但是3.0.0把这个函数调用编译到了一个我没想到的地址, 彻底毁了<a href="../pa6488/20090927cn.php">安全模式</a>的启动过程. 我在搞坏2台网络电话后才找到问题所在. 
<br />因为SDCC 3.0.0而带来了这么多改动, 我们计划在近期发布0.50版本软件. 软件API 0.49.007作为0.50的第一个预览版本, 现在已经可以在网上<a href="../../../ar1688/software/snapshotcn.html">下载</a>.
希望我们的客户不像SDCC Z80用户一样懒于测试预览版本. 因为有很多文件名的改动, 我建议把原来的API彻底删除后在解开新的<a href="20061211cn.php">API</a>压缩包.
<br />新API包比原来大很多, 主要是因为MinGW编译出来的<b>sdcc.exe</b> 3.0.0现在有2.3M字节, 而VC6编译出来的<b>sdcc.exe</b> 2.9.0只有0.8M字节. 其它bin子目录下SDCC相关工具也都比以前大了很多.
<br />在mcs51子目录中跟<a href="../../../ar1688/modulecn.html">AR168M</a>配合使用的8051软件也更新到了使用SDCC 3.0.0编译.
<br />&nbsp;
<br /><font color=magenta>2010年12月7日更新</font>
<br />Philipp是目前SDCC Z80上的主要开发人员.
当我发现他在自己的Z80<a href="http://www.atariage.com/forums/topic/172020-sdcc-300-released-and-some-updates-of-my-development-tools/" target=_blank>项目</a>中开始使用C99 <font color=olive>bool</font>后, 我觉得应该在AR1688上也尝试一下.
<br />在SDCC\inc\<b>type.h</b>文件中, 我们一直把<font color=olive>BOOLEAN</font>定义成<font color=olive>unsigned char</font>.
既然SDCC 3.0.0支持<b>stdbool.h</b>中的<font color=olive>bool</font>, 我照搬把<font color=olive>BOOLEAN</font>改成了<font color=olive>_Bool</font>, 增加<font color=blue>--std-c99</font>编译选项, 编译了一个SIP版本.
让我吃惊的是, 编译出来的代码比原来大. 然后我测试确认了<font color=blue>--std-c99</font>编译选项只影响<font color=olive>bool</font>的改动. 因为我愿意用较大代码换取较快执行速度, 我接下来测试速度. 
<br />我在<b>icmp.c</b>中写了下面的测试函数, 在ICMP回应前调用它, 这样我可以用ping测试函数执行时间: 
<br /><font color=olive>BOOLEAN</font> <i>TestBoolean</i>(<font color=olive>BOOLEAN</font> b1)
<br />{
<br />    <font color=olive>USHORT</font> s;
<br />    <font color=olive>BOOLEAN</font> b2;
<br />    <font color=olive>BOOLEAN</font> b3 = <i>IsHighSpeed</i>();
<br />    for (s = 0; s < 30000; s ++) b2 = b1 ? b3 : FALSE;
<br />    return b2;
<br />}
<br />当<font color=olive>BOOLEAN</font>定义成<font color=olive>unsigned char</font>时, 函数执行时间是137毫秒, 产生的代码小4字节. 当定义成<font color=olive>_Bool</font>, 使用bit相关指令时, 函数执行时间是167毫秒.
在这里我们再次看到了对Z80来说, 较小的代码通常意味着较快的速度. 因为C99 <font color=olive>bool</font>导致大代码和慢速度, 我决定先不用它. 
<br />跟2周前比较, 下面是有关SDCC 3.0.0的其它更新信息:
<br />1. <font color=gray>jp to jr</font>优化问题和<b>rc4.c</b> <font color=gray>x = x + something</font>编译错误都已经由Philipp解决. 
<br />2. 另外一个活跃开发人员Borut指出<font color=gray>Cygwin contains both gcc-3 (the good old version with -mno-cygwin) and gcc-4. You probably installed gcc-4. You can also install both versions and switch between then using set-gcc-default-3.sh and set-gcc-default-4.sh commands.</font>
因为我满意我的Linux虚拟机, 就没有进一步尝试Cygwin了. 
<br />3. 当谈论<b>sdcc.exe</b>的大小的时候我没有用MinGW的strip工具. 我忽略了它的原因是一个巧合, 下载的包括全部CPU支持的版本和我编译的只有Z80和8051支持版本的刚好都是2.3M字节.
使用strip后只包括Z80和8051支持的版本是1.0M字节, 只比2.9.0 VC6下编译的大一点点. 
<br />&nbsp;
<br /><font color=magenta><a name="20101208">2010年12月8日</a>更新</font>
<br />昨天我把<i>TestBoolean</i>函数的测试结果发到SDCC用户邮件列表后, Philipp很快就在#6078中做了修改. 今天我测试了修改结果, 代码大小已经一样了.
而且当<font color=olive>BOOLEAN</font>定义成<font color=olive>_Bool</font>时执行时间变成了133毫秒, 比<font color=olive>unsigned char</font>快了4毫秒. 
<br />对总体的AR1688软件而言, <font color=olive>_Bool</font>依然会比<font color=olive>unsigned char</font>产生稍大的代码.
不过Philipp建议保留<font color=olive>_Bool</font>, 我决定听从他的专家意见.
从目前的0.49.026版本开始, 所有makefile中都增加了使用C99 <font color=olive>bool</font>所必须的<font color=blue>--std-c99</font>的编译选项, 并且<font color=olive>BOOLEAN</font>在<b>type.h</b>中定义成了<font color=olive>_Bool</font>. 
<br />因为目前测试0.49和SDCC 3.0.0的客户很少, 我们决定不急于发布0.50版本, 等到充分测试后再说. 我增加了一个单独的<a href="../../../ar1688/software/sw049cn.html">0.49</a>页面便于下载测试软件. 
<br />&nbsp;
<br /><font color=magenta>2012年7月19日更新</font>
<br />现在VirtualBox可以直接读取.iso文件, 不再需要虚拟光驱.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
