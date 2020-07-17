<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>简单串口</title>
<meta name="description" content="由于来自用户的需求日渐增加, 我们开始在AR1688软件API中提供简单串口支持. 串口软件可以用OEM_UART的选项编译. 目前串口配置为19200bps波特率, 8位数据, 1位停止位, 无奇偶校验位. ">
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
<tr><td class=THead><B>简单串口</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年11月19日</td></tr>
<tr><td>由于不断有用户对使用<a href="../../../ar1688/index.html">AR1688</a>的串口实现不同于我们标准参考设计的VoIP功能感兴趣, 我们在目前的0.25测试软件中增加了对串口的软件支持. 
<br />AR1688的串口是最简单的, 只有一个RX管脚和一个TX管脚, 没有其他如硬件流量控制和状态管脚. 对发送和接收的数据内部各有8级8位硬件FIFO. 由于PLL的限制, 所有的波特率上都有0.16%的硬件误差. 
<br />串口软件可以用OEM_UART的选项编译.
由于2个串口管脚分别在ADC键盘(<a href="20061213cn.php">AR168F</a>/<a href="../../../ar1688/user/gp1266cn.html">AR168G</a>/<a href="../../../ar1688/user/gf302cn.html">GF302</a>/<a href="../../../ar1688/user/ywh201cn.html">YWH201</a>), 5x5键盘(<a href="../../../ar1688/user/gp1266cn.html">GP1266</a>)和5x6键盘(AR168K)中使用了, 我们需要在用串口的时候禁用这些键盘方案. 
<br />目前串口配置为19200bps波特率, 8位数据, 1位停止位, 无奇偶校验位. 需要的话波特率最高可以设置到115200bps. 
<br />接收数据时, Z80在接收FIFO半满后产生中断, 我们会把能够接收到的数据都读到一个255字节的循环缓冲区中等待主程序处理. 我们尽可能尽快出串口中断, 以防止串口中断阻碍DSP中断, 导致DSP性能下降. 
<br />发送数据的时候不采用中断. 我们把需要发送的数据保存在另外一个255字节的循环缓冲区中, 然后在主程序空闲时调用发送数据函数, 每次都一直写到发送FIFO满为止. 255字节看上去有点大, 但是可以在保证数据完整性的前提下不用死等发送FIFO有空闲, 从而避免主程序被阻塞, 妨碍其它关键任务如RTP的处理. 
<br />由于上层软件得不到接收或者发送的错误报告, 应用程序需要自己处理数据错误检测和重传. 
<br />在uart.c中我们实现了一个基于"字符串"的串口通信例子, 不带任何错误检测. 用'\0'区别开串口上传送的不同字符串. 为保证发送数据能被及时接收, 在每个字符串后我们多发了4个'\0', 这样Z80能在"半满"时进入中断及时收到全部字符串的数据. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
