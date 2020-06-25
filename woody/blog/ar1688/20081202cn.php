<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688 Z80性能</title>
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
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
<tr><td class=THead><B>AR1688 Z80性能</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年12月2日</td></tr>
<tr><td>在写完<a href="20080121cn.php">Z80速度</a>10个月后, 我们已经积累了很多有关AR1688 Z80性能和网络电话系统限制的经验. 
<br />慢的2x16 LCD控制器是导致Z80不能跑48MHz以上的最常见原因. 也很好解决, 换一个快的就行. 市场上其实有很多快的控制器, 那些慢的仅仅只是因为太古老. 点阵显示的LCD控制器全部都很快, 从来没有出过类似问题. 
<br />接在Z80数据总线上的程序存储器不够快是另外一个原因. 幸运的是我们发现程序存储器只是在写入的时候不够快. 这样我们可以在写程序存储器的时候让Z80跑24MHz, 其它绝大多数时间系统都能够跑高速. 
<br />网络芯片是最后一个接在Z80数据总线上的, 解决了LCD和程序存储器问题后, 就由它决定AR1688网络电话到底能跑多快. 
<br />接最常用的<a href="20080615cn.php">RTL8019AS</a>, Z80能跑60MHz. 
<br />Micrel <a href="20081124cn.php">KSZ8842</a>不如RTL8019AS, 接它的时候Z80只能跑45MHz. 
<br />单纯从速度上考虑, Davicom DM9003是最好的, 接它的时候Z80能跑AR1688芯片的设计极限72MHz. 
<br />Z80性能到底重要在什么地方? 
<br />即使Z80跑24MHz, <a href="../../../ar1688/indexcn.html">AR1688</a>网络电话也能处理1Mbps的UDP数据. 大约10倍于普通的VoIP流量. 因此Z80性能跟网络性能关系不大. 
<br />当考虑周期性的重新注册消息对语音产生的抖动影响(<a href="20071116cn.php">Rtp优先</a>), Z80性能就重要了, 因为我们用它计算MD5. 做少于56字节的单次加密计算时, 48MHz需要4.7毫秒, 60MHz需要3.7毫秒, 72MHz需要3.0毫秒. 
<br />由于软件接口不同, 上面链接中描述的"Rtp优先"策略只能用在RTL8019AS上. 对KSZ8842和DM9003就需要让MD5计算越快越好了. 除了让Z80跑更高频率, 我们也在计划对MD5算法做更多的汇编优化. 
<br />Z80性能也会影响"实际"<a href="20070216cn.php">DSP</a>运算能力. 在Z80和DSP交换数据的时候, 我们会把DSP放在一个只能进中断处理的循环中等待. Z80读写DSP数据越快, DSP等待时间就越少, 实际运算能力就越高. 
<br />为什么我一直在谈论性能和优化? 可能这是我唯一知道自己能做好的事情吧. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=gray>"We should forget about small efficiencies, say about 97% of the time:
<br />premature optimization is the root of all evil." - Donald Knuth "Structured
<br />Programming with go to Statements" Computing Surveys, Vol. 6, No. 4,
<br />December, 1974, page 268.
</font></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
