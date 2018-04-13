<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>拯救PA168Q的合理步骤</title>
<meta name="keywords" content="拯救PA168Q">
<meta name="description" content="如何挽救二手PA168Q的具体步骤. 希望这能够给缺乏耐心的Palmmicro老产品的新用户一点帮助. PA1688的产品能够在世界上一直沿用这么多年, 我们一直都很骄傲.">
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
<tr><td class=THead><B>拯救PA168Q的合理步骤</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年8月14日</td></tr>
<tr><td>上周比较随意的跟一个二手的不工作的<a href="../../../pa1688/user/pa168qcn.html">PA168Q</a>主人来往了几封邮件后, 他爆发了：
<font color=grey>Where is the start point and the end point? How am I supposed to find my way in all these links?? Which one is relevant to my case and which is not?
Then, How to send the bin file to the device. I appreciate the help, but it needs to be logical.</font>
<br />刚开始我对自己的PA1688网页工作觉得很沮丧, 后来我意识到了可能还有其它新的PA1688二手设备用户跟他有同样的抱怨. 
根据Google <a href="../entertainment/20101107cn.php">Analytics</a>的统计, 在过去5个中, 我们网页的新用户比例从61.01%增加到了74.07%(见下图). 
<br />如果我刚接触PA1688, 可能合理的步骤是：
<br />1. 找一台Windows PC, 把PC和PA168Q接到同一个局域网, 设置局域网内DHCP服务器地址为192.168.1.1, 确认192.168.1.100地址没有被使用. 
<br />2. 下载软件API和PA168Q升级文件, 当前的正式版本是<a href="../../../pa1688/software/sw166cn.html">1.66</a>. 解开软件API包到C:\Palmh323、PA168Q升级文件<b>pa168q_sip_us_166000.bin</b>到C:\Palmh323\bin. 
<br />3. 从C:\Palmh323\bin运行Run <a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>, 点击<font color=blue>开始调试</font>按钮打开UDP调试信息窗口, 把192.168.1.100填到<font color=blue>片上IP地址</font>控件中. 
<br />4. 在按下PA168Q上唯一一个键的同时加电启动开机, 至少重复2次, 直到它进入<a href="../pa6488/20090927cn.php">安全模式</a>. 进入安全模式后, 不同版本的软件会在调试信息窗口中有不同的输出. 
同时PC可以ping PA168Q的地址192.168.1.100, <a href="../palmmicro/20091114cn.php">MAC</a>地址是00-09-45-00-00-00. 
<br />5. 用PalmTool从安全模式中升级, 点击<font color=blue>更新程序</font>后选择文件<b>pa168q_sip_us_166000.bin</b>. 
<br />以上步骤完成后PA168Q重新启动, 如果幸运的话它会正常工作. 提起接在PA168Q上的普通电话的听筒, 按下PA168Q上唯一的那个键, 听筒中会报IP地址. 
<br />在中国以外使用的PA168Q和所有其它PA1688的网关都有来电显示不正常的问题, 可能只支持中国标准的<a href="http://web.textfiles.com/phreak/caller-id.txt" target=_blank>CID</a>. 
因为我们已经没有PA1688 DSP的开发人员, 我们已经无法修改这个问题, 以及其它跟DSP有关的问题. 
</td></tr>
<tr><td><img src=../photo/20110814.jpg alt="Palmmicro.com visitor overview from Google Analytics on Aug 12, 2011.0" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
