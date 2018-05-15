<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>RTP优先</title>
<meta name="description" content="由于AR1688性能限制, SIP注册信息需要比较长时间处理. 我们在RTL8019AS网络芯片上实现了一个Mini Run功能, 用于在处理SIP注册信息的时候优先处理进出的RTP包.">
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
<tr><td class=THead><B>RTP优先</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年11月16日</td></tr>
<tr><td><a href="../../../ar1688/indexcn.html">AR1688</a>软件中没有RTOS, 所有东西都在一个类似于下面的循环中处理. 
<blockquote><code>while (1) 
<br />{ 
<br />&nbsp;&nbsp;&nbsp;&nbsp;do_everything(); 
<br />}
</code></blockquote>
让情况更糟的是, 8位的Z80处理器处理MD5加密这种工作很慢, 需要大约5-10毫秒. 用FWD同一个帐号测试IAX2和SIP协议, <a href="20071110cn.php">IAX2</a>协议需要12毫秒完成一次注册工作, 其间计算1次MD5. 
SIP协议需要80毫秒完成一次注册工作, 包括计算3次MD5. 在这80毫秒SIP注册时间内, 全部进出的RTP包都被阻塞, 给通话带来了很大的RTP包抖动. 
<br />一个客户在邮件列表上指出了这个问题, 同时指出唯一的解决方法是使用一个RTOS. 不过AR1688的资源实在不能够多负担一个额外的RTOS. 我们想办法在0.25的软件上使用RTP优先的策略成功解决了这个问题. 
<br />在处理SIP消息的时候, 我们会调用几次<i>TaskMiniRun</i>函数来及时处理进出的RTP包. 这个函数以类似中断服务函数方式工作, 它会保存当前处理的SIP消息的状态, 收发RTP数据, 然后恢复SIP消息处理. 
<br />只有想不到, 没有做不到. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=Update>2015年7月29日更新</td></tr>
<tr><td>这个类似中断处理的功能额外消耗了不少资源, 最近发现有用户在添加自己开发的代码后运行过程中出现了堆栈溢出的情况. 
为方便调试, 在<b>version.h</b>中增加<b><i>SYS_MINI_RUN</i></b>, 只有当它定义了的时候才启用RTL8019AS上RTP优先的Minu Run. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/rtl8019as.jpg alt="RTL8019AS chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
