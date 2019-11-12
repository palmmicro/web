<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>找出两幅图不同之处</title>
<meta name="description" content="比较基于Palmmicro AR1688方案的标准AR168R RoIP模块和为REMOTA TECNOLOGIA设计的特殊版本, 顺便比较记录其它容易混淆的问题.">
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
<tr><td class=THead><B>找出两幅图不同之处</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2012年11月11日</td></tr>
<tr><td>上个月有个丹麦用户抱怨说他收到的<a href="../../../ar1688/roipcn.html">AR168R</a>板子没焊接完. 他发了个照片, 上面标注着缺少RS232电平转换芯片和DB9插座. 
<br />其实他收到的是我们标准的RoIP板子, 但是被我们网页上AR168R图片误导了. 我们把给REMOTA TECNOLOGIA的特别版本的板子照片放在了上面.   
<br />当我们交换了更多的电子邮件后, 发现了更多有关AR168R混淆误导的内容. 由于我们缺乏必要的文档, 我收集了这些内容在这里, 为其它客户以及我自己避免日后猜谜用. 
<br />1) 我们标准的AR168R软件在没有<a href="20070604cn.php">LCD</a>的情况下不会工作.
要让AR168R在没有LCD的时候工作, 必须把sdcc\include\<b>version.h</b>文件中#ifdef <b><i>VER_AR168R</b></i>部分内的<b><i>LCD_HY1602</b></i>定义去掉后重新编译软件.  
<br />2) 标准AR168R软件中没有包括<a href="20071119cn.php">串口</a>功能. 要使用串口功能, 必须用<b><i>OEM_UART</b></i>选项重新编译软件. 命令行可以用<font color=gray>mk ar168r sip us uart</font>.
不需要安装额外的编译器, <a href="20101123cn.php">SDCC</a>编译器已经包括在软件API中, 在sdcc\bin目录下.
<br />3) 在我们的示例串口<a href="20080329cn.php">协议</a>中, 所有的字符串都必须象在C语言中那样以'\0'(ascii 0x00)结尾.
否则AR1688不能正确处理收到的命令, 可能会在sdcc\bin\<b>manager.exe</b>的调试信息窗口中输出信息<a href="../../../ar1688/faqcn.html#module">UART data lost</a>.  
<br />4) 在示例协议中, <font color=gray>KEY Z</font>用来给AR1688指示挂机, <font color=gray>KEY z</font>指示摘机. 
<br />从2010年<a href="../../../ar1688/modulecn.html">AR168M</a> VoIP模块卖<a href="20100625cn.php">断货</a>后, 我们采用了各种<a href="20111205cn.php">不寻常的方法</a>帮助客户测试模块功能.
幸运的是这样的日子快完了, 我们可能会较快收到一个100片的AR168M订单. 到时候我们会多生产一些供日后其它客户测试. 而目前烦人的<font color=gray>把AR168R当AR168M使用</font>也可以停止了.    
</td></tr>
<tr><td><a href="../photo/large/20121111.jpg" target=_blank>大图</a></td></tr>
<tr><td><img src=../photo/20121111.jpg alt="Standard AR168R RoIP module photo by an user from Denmark." /></td></tr>
<tr><td><img src=../../../ar1688/roip/ar168r_s.jpg alt="Special AR168R RoIP module for REMOTA TECNOLOGIA in Brazil." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
