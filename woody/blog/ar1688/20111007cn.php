<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>每个人都会问愚蠢问题</title>
<meta name="description" content="从SDCC版本3.0.1 #6078后, 我们就再也没有找到过一个编译AR1688软件稳定能用的版本. 这里记录的是我一直调试问题的工作. 软件真是个无休止的工作, 活到老做到老吧!">
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
<tr><td class=THead><B>每个人都会问愚蠢问题</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年10月7日</td></tr>
<tr><td>自从2009年初我们开始<a href="../../../pa6488/indexcn.html">PA6488</a>方案开发后, AR1688上面的主要开发工作就停止了.
但是就在全世界包括<a href="../palmmicro/20080326cn.php">Palmmicro</a>的我们都认为8位控制器难以为继的时候, <a href="../../../res/indexcn.html#sdcc">SDCC</a>编译器的开发团队仍然在不停工作.
这样一来, 有关编译器的更新信息变成了我们的软件发布详情以及我的AR1688博客的重要内容.
<br />目前主要的SDCC Z80开发人员Philipp在今年年初宣布了一个用于减少<a href="20081202cn.php">Z80</a>代码大小的新寄存器分配方案设计. 几个月后他完成了. 我一直坚信更小的代码有利于所有AR1688用户, 于是在6月份开始测试.
经过几个错误报告和修改后, 7月份的时候我终于用新版本全程编译成功. 尽管它仍然有错误编译代码的问题, 让我最不舒服的却是它的编译时间.
在我带4G内存的Sony <a href="../pa6488/20090808cn.php">VGN-FW235J</a>上, 编译一次全部AR1688软件的时间由原来的2分钟左右增加到了差不多半个小时. 
<br />9月份Borut宣布了64位Windows上的64位SDCC支持. 我作为第一个报告了结果的用户抢先做了测试, 希望能够减少编译时间. 但是结果令人失望, 在我64位Windows Vista上, 32位和64位的SDCC实际上并没有表现出明显的性能区别. 
<br />我在SDCC邮件列表上问, 64位的SDCC到底有什么好处呢?
Philipp建议<font color=grey>Try --max-allocs-per-node 100000000 (recommended: At least 64 GB of RAM) or even just --max-allocs-per-node 8000000 (recommended: At least 6GB of RAM). It won't work with the 32-bit version unless you use PAE.</font>
<br />我接着为我的机器问4GB内存下建议的<font color=blue>--max-allocs-per-node</font>参数是多少? 这次Philipp没有像往常那样立刻回答.
当天晚上梦中, 我才意识到我问了一个<a href="20110826cn.php">愚蠢</a>的问题. 4G内存是32位系统能支持的最大值, 因此同样也不会有什么不同. 
<br />&nbsp;
<br /><font color=magenta>2011年10月17日更新</font>
<br />昨天Borut宣布将于2011-11-26发布SDCC 3.1.0版本, 以纪念C语言之父Dennis M. Ritchie. 我意识到要再次开始测试SDCC的问题了, 不然跟不上这些开发人员. 
<br />通常我都自我介绍是个软件工程师. 不过在过去的一年中, 对于AR1688和SDCC而言, 我做的大多都是测试工程师的工作. 而且这种测试甚至比PA6488方案的开发还要困难. 
<br />在连续10个小时的测试工作后我提交了编译器错误3424436, 而且最终我发现SDCC编译出问题的函数<i>SipCallStep1</i>跟差不多一年前我报告的编译器错误3122620中的是同一个函数. 
<br />事实上这不是第一次同一个函数编译出错了, 某些代码就是天生与众不同的难于编译. 在之前的错误报告3381400和3407632中, 我发现同一个函数<i>_DspLoadFile</i>被以不同的方式编译错误了2次. 为了避免下一个10小时的测试工作, 下次我打算从先抓老嫌疑犯开始!
<br />&nbsp;
<br /><font color=magenta>2012年3月17日更新</font>
<br />去年SDCC开发团队发布了3.1.0版本, 在过了快5个月后, 它编译AR1688软件时仍然表现得一团糟. 
<br />当SDCC在2009年发布<a href="20090329cn.php">2.9.0</a>的时候我们几乎没有碰到什么问题. 2010年的SDCC 3.0.0让我们花了2个星期追赶新版本.
至今的<a href="../../../ar1688/software/sw057cn.html">0.57</a>测试版本仍然在沿用<font color=grey>SDCC 3.0.1 #6078 (Dec 7 2010) (MINGW32)</font>. 
<br />SDCC 3.1.0则是一开始就不对头, 它正式发布的时候就没有解决我提交的第4个<font color=blue>--max-allocs-per-node</font>编译错误.
虽然我欣赏其中的新特性<font color=grey>new register allocator in the z80 and gbz80 ports (optimal when using --opt-code-size and a sufficiently high value for --max-allocs-per-node for the z80 port)</font>,
我一直被<font color=red>Caught signal 11: SIGSEGV</font>的程序崩溃困扰.
我在另外的地方读到<font color=grey>Almost all signal 11 crashes (segment faults) are caused by a reference to the object of a null pointer</font>, 我猜想新寄存器分配方案的实现中肯定还有不少潜在问题. 
<br />Philipp提供了另外一个选项<font color=blue>--oldralloc</font>来使用老的寄存器分配方案. 在很多次对新方案失望后, 我开始测试使用老分配方案的3.1.0版本, 没想到也是错误一堆.
在Philipp修改好我提交的2个<font color=blue>--oldralloc</font>编译错误后, 我想我终于找到了一个更新到3.1.0的方式. 
<br />昨天我开始编译全部的AR1688升级文件, 没想到的是, 原来有GB2312编码汉字的源程序居然全部不能编译了!
<br />&nbsp;
<br /><font color=magenta><a name="20120813">2012年8月13日</a>更新</font>
<br />在Philipp的建议下, SDCC的开发人员提前了今年的3.2.0版本发布, 希望能有个稳定版本. 当时我在忙着学习<a href="../entertainment/20120719cn.php">Linux</a>编程.
上周我完成AR1688 <a href="../../../ar1688/software/sw058cn.html">0.58</a>软件发布的测试后, 想到的第一件事情就是测试SDCC的新版本. 
<br />刚开始我挺高兴, 3.1.0版本中2个让我恼火的问题, <font color=red>Caught signal 11: SIGSEGV</font>和<font color=blue>--max-allocs-per-node</font>, 居然都解决了.
但是测试了更多的AR1688设备后, 我又新发现了至少3个问题. 看来在相当一段时间内, 我们还要继续使用老的<a href="20101123cn.php#20101208">3.0.1 #6078</a>版本.
<br />下表中总结了测试结果. 代码大小和编译时间使用命令行<font color=grey>mk ar168g sip us</font>和标准编译器选项<font color=blue>-mz80 -c --std-c99</font>产生.   
</td></tr>
</table>

<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="table1">
       <tr>
        <td class=c1 width=100 align=center>SDCC版本</td>
        <td class=c1 width=100 align=center>额外的编译器选项</td>
        <td class=c1 width=100 align=center>代码大小(字节)</td>
        <td class=c1 width=100 align=center>编译时间(分钟)</td>
        <td class=c1 width=240 align=center>已知问题</td>
      </tr>
      <tr>
        <td class=c1 align="center">3.0.1 #6078</td>
        <td class=c1 align="center"></td>
        <td class=c1 align="center">158073</td>
        <td class=c1 align="center">2</td>
        <td class=c1 align="center"></td>
      </tr>
      <tr>
        <td class=c1 align="center">3.2.1 #8062</td>
        <td class=c1 align="center"></td>
        <td class=c1 align="center">156413</td>
        <td class=c1 align="center">6</td>
        <td class=c1 align="center"><a href="../../../ar1688/modulecn.html">AR168M</a>串口错误</td>
      </tr>
      <tr>
        <td class=c1 align="center">3.2.1 #8062</td>
        <td class=c1 align="center"><font color=blue>--oldralloc</font></td>
        <td class=c1 align="center">154871</td>
        <td class=c1 align="center">3</td>
        <td class=c1 align="center"><a href="../../../ar1688/user/gp1266cn.html">AR168G</a>键盘错误</td>
      </tr>
      <tr>
        <td class=c1 align="center">3.2.1 #8062</td>
        <td class=c1 align="center"><font color=blue>--max-allocs-per-node 10000</font></td>
        <td class=c1 align="center">152552</td>
        <td class=c1 align="center">13</td>
        <td class=c1 align="center"><a href="../../../ar1688/roipcn.html">AR168R</a>某SIP消息在<a href="../../../res/voiptalkcn.html">VoIPtalk</a>系统下错误</td>
      </tr>
</TABLE>

<table>
<tr><td>上面的编译时间都在我的老Sony VGN-FW235J上测试, 它运行的是Intel(R) Core(TM)2 Duo CPU T5800 @ 2.00GHz, 4GB DDR2内存和64位Windows Vista.
当在我新的Sony VPCEG, 运行Intel(R) Core(TM) i5-2450M CPU @ 2.50GHz, 6GB DDR3内存和64位Windows 7上对比测试最长时间的情况后, 总时间从13分钟降到了6分钟. 在过去的2个月中我都一直没有意识到我的新电脑比老的快了这么多! 
<br />&nbsp;
<br /><font color=magenta>2012年8月14日更新</font>
<br />今天的测试显示SDCC 3.2.0正式版本没有AR168G键盘错误的问题(用<font color=blue>--oldralloc</font>编译选项).  
<br />&nbsp;
<br /><font color=magenta>2014年1月26日更新</font>
<br />有关Borut Ražem的坏<a href="https://sourceforge.net/p/sdcc/discussion/1864/thread/a7cdb71e/" target=_blank>消息</a>. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
