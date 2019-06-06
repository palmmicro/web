<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Z80速度</title>
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
<tr><td class=THead><B>Z80速度</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年1月21日</td></tr>
<tr><td>从我们做AR1688开始一晃过了2年, 目前看上去还好, 我们做了一个比原来<a href="../../../pa1688/indexcn.html">PA1688</a>成本低而语音质量好的方案. 不过也一直有些问题解决不了, Z80的运行速度就是其中之一. 
<br />在我第一篇<a href="../../../ar1688/indexcn.html">AR1688</a>文章中写它能跑48MHz, 但是在量产软件中我们从来都没有用过这个速度. 一小部分话机在48MHz下不能正常工作. 为保证100%工作, 迄今为止所有发布的软件都只跑24MHz, 我们一直叫它低速软件. 
<br />具体查找为什么某些话机只能跑低速的原因, 目前看上去非常复杂, 几乎跟电话每个部分相关, 不同的AR1688芯片, 不同的程序存储器芯片, 不同的LCD甚至不同的PCB布线都可能导致不同结果. 
<br />在目前0.27测试软件<a href="20061211cn.php">API</a>中加入了SetHighSpeed()函数. 它只能在function.c的UI_Init()函数中被调用一次, 或者根本不调用. 如果不调用的话软件会继续跑在24MHz, 调用以后软件会跑在48MHz. 
最终用户可以用这个函数测试手头的硬件, 绝大多数网络电话都能跑48MHz. 如果有人不幸运的有一个只能跑低速的硬件, 可以在安全模式下更新回标准的低速软件. 安全模式始终只跑低速24MHz. 
<br />更新高速软件后, 可以用Windows命令行"ping xxx.xxx.xxx.xxx -l 2952"确认高速是否起作用. 高速下ping的回应时间大约19ms, 低速下大约33ms. 密切注意以下的高速软件可能碰到的问题迹象: 
<br />1. LCD显示错误
<br />2. 新软件更新非常快, 例如9秒结束
<br />3. 在更新设置或者升级后网络电话设置莫名其妙被改动或者完全错误
<br />安全模式总会工作, 如果出现任何错误情况, 可以在安全模式下用#5*5和#5*0恢复出厂设置, 然后在安全模式下更新回标准低速软件. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
