<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR168M网络语音模块功能测试</title>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>AR168M网络语音模块功能测试</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年12月5日</td></tr>
<tr><td>转眼过去了18个月, 我们的<a href="../../../ar1688/modulecn.html">AR168M</a>网络语音模块一直还在<a href="20100625cn.php">缺货</a>中. 面对这期间来自全世界的稳定数量的询问, 我们总是死猪不怕开水烫的回答: “你可以自己做板子测试. 你看, 全部资料都在我们的<a href="../../../ar1688/hardwarecn.html">硬件</a>网页供下载. ”
<br />上个月一个保加利亚的开发者给我们提供了一个新的思路. 他购买了一台GP2266网络电话, 然后自己修改了相关<a href="20071119cn.php">UART</a>管脚电路, 用来测试网络语音模块功能. 当然软件上也需要点小改动配合, 我们于是在AR1688 <a href="../../../ar1688/software/sw055cn.html">0.55</a>测试软件页面提供了0.55.015 API下载. 从这个版本开始, <a href="../../../ar1688/user/gp1266cn.html">AR168G/GP1266/GP2266</a>网络电话的用户可以用类似于"mk gp2266 sip us uart"的命令行来编译UART测试软件. 
<br />跟编译"真正的"AR168M/AR168MS/AR168MK模块软件的时候在sdcc\include\version.h中不能同时定义SERIAL_UI和LCD_HY1602一样, 编译AR168G/GP1266/GP2266的时候也不能同时定义SERIAL_UI和LCD_ST7565. 
<br />当定义SERIAL_UI的时候, 软件会跑用于演示的<a href="20080329cn.php">高层用户界面协议</a>, 全部显示都输出到了外部的<a href="20080330cn.php">控制器</a>, 而LCD不会正常工作. 
<br />当定义LCD_XXXX的时候, LCD会正常工作, 用户此时需要在sdcc\src\serial.c中实现自己的UART通信协议. 
<br />&nbsp;
<br /><font color=magenta>2012年5月3日更新</font>
<br />从<a href="../../../ar1688/software/sw057cn.html">0.57</a>.046版本开始, SERIAL_UI和LCD_XXXX可以同时使用. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
