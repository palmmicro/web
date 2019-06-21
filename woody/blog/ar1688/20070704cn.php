<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>调试常见问题</title>
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
<tr><td class=THead><B>调试常见问题</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年7月4日</td></tr>
<tr><td>我们为客户提供包括电话, MSN和电子邮件等多种技术支持. 电话只要是用中文打的就行. 我们大多数人都不能像美国人或者印度人那样讲英语. 昨天我接了几个来自印度的电话, 其中一半的时间我都在猜对方在讲什么, 至于另外一半时间呢, 我估计对方在猜我在讲什么! 
在微软的软件下长大, 我天生喜欢MSN, 不过我每次我建议用MSN被拒绝的时候, 我都能理解大家对M$仇恨多深. 好在电子邮件总是可以有效沟通, 请大家尽量给我们多发<a href="mailto:support@palmmicro.com">邮件</a>吧. 
<br />发电子邮件的时候请包括以下部分: 
<br />1. <a href="20061014cn.php">硬件型号</a>, 例如迪迈特<a href="../../../ar1688/user/gp1266cn.html">GP1260/1266</a>, 金未来<a href="../../../ar1688/user/gf302cn.html">GF302</a>, 豫能<a href="../../../ar1688/user/ywh201cn.html">YWH201</a>/601
<br />2. 软件版本, 目前最新的稳定版本是0.16
<br />3. 协议, SIP或者IAX2
<br />4. <a href="20070405cn.php">语言</a>, cn, us, fr, it以及其它
<br />5. OEM标签, 如果有的话
<br />6. 以.html格式存放的话机设置. 用户可以用浏览器的"另存为"功能把网页设置存到一个.html文件中. 这个文件可能因为安全原因不能全部显示, 但是我们可以用Microsoft Word之类的html编辑工具察看
<br />7. 详细的问题描述, 最好有可以测试的帐号
<br />8. 测试中用到的其它软件和硬件. 请尽可能给我们提供测试中用到的软件来重复问题
<br />9. 任何格式的网络抓包
<br />10. 用文本格式发给我们<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>调试信息输出. 必须打开<a href="../../../ar1688/indexcn.html">AR1688</a>设置的调试选项.
<br />11. 某些特殊情况下, 我们会需要用户运行下面的命令行后送给我们page0.dat和page1.dat文件:
<br /> tftp -i xxx.xxx.xxx.xxx get page0.dat
<br /> tftp -i xxx.xxx.xxx.xxx get page1.dat
<br /> 
<br />0.16软件调试常见问题: 
<br />1. 通话中没有声音: 检查CODEC选项确认没有使用G.723.1和Speex
<br />2. 通话中不发给对方声音:
<br /> a. 检查RTP端口选项确保不是0, 从<a href="20060929cn.php">IAX2</a>转换回SIP协议后会把RTP端口清0
<br /> b. 检查"语音帧数"的值在1-7之间
<br />&nbsp;
<br /><font color=magenta>2008年8月11日更新</font>
<br />从<a href="20080811cn.php">0.37</a>版本后不再使用PalmTool调试, 改为使用SDCC\bin\manager.exe. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
