<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>伊朗新做的PA168M板子</title>
<meta name="description" content="一个勤奋的伊朗工程师完全漠视我们网站上的PA1688停产告示, 在完全没有跟我们联系的情况下自己动手做了一块PA168M板子. 现在他找过来了, 因为发现板子不能启动.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>伊朗新做的PA168M板子</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2013年3月3日</td></tr>
<tr><td>上周收到的一封邮件让我大吃一惊. 一个伊朗的工程师刚刚新做了一块PA168M板子, 勤奋的他在问如何启动硬件.
<br />我当时已经完全不记得PA168M是什么东西. 交换了几封邮件后, 我终于搞清楚了来龙去脉.
这个人从我们的<a href="../../../pa1688/hardwarecn.html">硬件</a>页面上下载了<font color=grey>PA168M(PA168S)</font>网络电话相关文件, 从一家坑爹的中国代理商那里买了全部必需的芯片, 做了板子焊上了全部器件.
因为PA1688和<a href="../../../ar1688/indexcn.html">AR1688</a>方案都需要在生产前先烧录程序存储器. 他的板子自然没法启动了.
<br />我建议了以下步骤：
<br />1. 在软件<a href="../../../pa1688/software/sw167cn.html">1.67</a>页面, 下载文件<font color=grey>2011年11月13日PA168S网络电话1.67.012 安全模式英文</font>. 解开压缩包后, 里面是<b>page0.hex</b>.
<br />2. 在硬件<a href="../ar1688/20101202cn.php">编程器</a>中, 应该有工具把这个<b>page0.hex</b>转换成一个64k字节大小的.bin文件. 或者硬件编程器本身就能直接接受.hex文件. 用这个文件的内容烧写MX29LV008TTC <i>top</i>兼容的程序存储器的前64k字节内容.
<br />3. 把程序存储器芯片焊接到板子上, 按住*键从<a href="../pa6488/20090927cn.php">安全模式</a>启动. 
<br />4. 在安全模式(192.168.1.100)中, 使用<a href="../../../pa1688/software/palmtoolcn.html">Palmtool</a>升级PA168S <a href="../../../pa1688/software/sw168cn.html">1.68</a>文件<b>pa168s_sip_us_168000.bin</b>. 
<br />回信后, 我马上把PA1688首页上的<i>停产</i>通知从<font color=grey>灰色</font>改成了<font color=red>红色</font>, 同时在硬件资料下载页面也加上了红色的警告! 
<br />&nbsp;
<br /><font color=grey>这个标着0519的PA1688-PQ芯片生产于PA1688的最后一年2005年的第19周.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/pa1688pq.jpg alt="PA1688PQ chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
