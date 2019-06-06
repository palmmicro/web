<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA3288开发指南 - 函数概览</title>
<meta name="description" content="PA3288函数概览">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa3288.js"></script>
<script src="../software.js"></script>
<script src="devguide.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateDevGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>
	
	
<table>
<tr><td class=THead><B>PA3288开发指南 - 函数概览</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=grey><a name="include">Include文件</a></font>
<br />所有外部include文件都在<font color=indigo>include</font>子目录下. 
<br />除了<b>version.h</b>和<b>type.h</b>外, 全部其它.h文件都对应某一个子目录下.c文件中的函数. 例如, <b>csl.h</b>包括所有<font color=indigo>csl</font>子目录下.c文件中的函数声明. 
<br />&nbsp;
<br /><font color=grey><a name="csl">芯片支持库csl</a></font>
<br />所有芯片支持库中的函数命名都类似于<i>ABCD_Eabc</i>. 例如, 从函数名<i>GPIO_Write</i>几乎可以肯定它声明在<b>csl.h</b>中, 实现在<font color=indigo>csl\</font><b>gpio.c</b>中. 
<br />所有csl中的.c文件都独立于<b>version.h</b>, 也就是说它们只和PA3288芯片相关, 独立于具体的<a href="../../../woody/blog/ar1688/20061014cn.php">硬件型号</a>. 通常它们只需要include <b>type.h</b>、<b>csl.h</b>和内部的<font color=indigo>csl\</font><b>reg.h</b>. 
<br />如果你需要使用"复杂的"函数如<i>strcmp</i>, 考虑把这部分代码移出csl. 绝大部分这里的代码都只跟芯片寄存器操作相关. 
<br />在<i>main</i>函数开始的时候<i>ABCD_Init</i>函数的调用次序很重要. 不要改变它, 除非你真的有100%的把握知道你在做什么. 
<br />&nbsp;
<br /><font color=grey><a name="bsl">硬件板支持库bsl</a></font>
<br />所有硬件板支持库中的函数命名都类似于<i>AbcdEfgh</i>, 其中的Abcd通常是一个硬件板上跟PA3288芯片互联工作的可编程器件的名字. 例如, 在<font color=indigo>include\</font><b>bsl.h</b>中的<i>OV7670Init</i>函数说明它的函数体在<font color=indigo>bsl\</font><b>ov7670.c</b>中. 从名字看这个函数的功能是有关OmniVision VGA图像传感器的初始化. 
<br />对几乎每个<font color=indigo>bsl</font>子目录下的<b>abcd.c</b>文件来说, 都对应有一个<b>version.h</b>中的<b><i>BSL_ABCD</i></b>编译定义. 例如, 只有用了OV7670的硬件板才会定义<b><i>BSL_OV7670</i></b>, 这样我们能够方便控制在哪里调用OV7670的相关函数. 
<br />由于不同的硬件板可能用不同的方式连接外部器件, 例如使用了不同的GPIO, bsl中.c文件通常都需要include <b>version.h</b>.  
<br />这里大多数代码都跟利用<b>csl.h</b>中的函数操作可编程器件中的寄存器相关. 跟在csl中的情况一样, 留心把"复杂的"代码移出bsl. 
<br />&nbsp;
<br /><font color=grey><a name="sys">系统级别</a></font>
<br />系统级别的函数也类似于<i>AbcdEfgh</i>, 但是这里Abcd不再是器件名字. 跟上面一样, 所有系统级别的函数都声明在<font color=indigo>include\</font><b>sys.h</b>中, 实现在<font color=indigo>sys</font>子目录下.  
<br />对每个<b>abcd.c</b>而言, 在<b>version.h</b>中可能会有对应的一个或者多个<b><i>SYS_ABCD_XXXX</i></b>编译定义. 例如当<b><i>SYS_DEBUG</i></b>没有被定义的时候, 编译出来的代码至少要比打开调试功能时候要小7k字节. 而当<b><i>SYS_SERIAL_UI</i></b>定义了的时候, 说明系统支持我们的演示<a href="../../../woody/blog/ar1688/20080329cn.php">高层界面协议</a>.  
<br />跟<a href="#csl">csl</a>中情况不同, 系统级别的.c文件通常都需要include <b>version.h</b>, 便于利用其中的<b><i>SYS_ABCD_XXXX</i></b>定义控制程序流程. 
<br />&nbsp;
<br /><font color=grey><a name="fat">简单文件系统</a></font>
<br /><font color=indigo>fat</font>子目录下简单实现了一个FAT16兼容的文件系统, 函数定义在<font color=indigo>include\</font><b>fat.h</b>中. 
<br />不支持子目录, 只同时支持1个文件读和1个文件写的操作, 不支持文件seek功能. 
<br />&nbsp;
<br /><font color=grey><a name="md5">MD5算法</a></font>
<br /><font color=indigo>md5</font>子目录下是来自GRUB(GRand Unified Bootloader)的GNU GPL2的MD5算法实现, 函数声明在<font color=indigo>include\</font><b>md5.h</b>中. 
<br />&nbsp;
<br /><font color=grey><a name="test">模块测试</a></font>
<br />所有最终产品不会用到的模块测试代码放在<font color=indigo>test</font>子目录下, 函数声明在<font color=indigo>include\</font><b>test.h</b>中.  
<br />例如, <font color=indigo>test\</font><b>test_md5.c</b>文件中的函数<i>Test_Md5</i>实现了所有RFC 1321中推荐的字符串测试. <b>version.h</b>中有编译定义<b><i>TEST_MD5</i></b>, 控制何时做这个测试. 
<br />&nbsp;
<br /><font color=grey>相关信息</font>
<br />PA6488的<a href="../../../pa6488/software/devguide/functionoverviewcn.html">函数概览</a>. 
</td></tr>
</table>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
