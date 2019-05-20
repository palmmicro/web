<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - 以太网PHY开始工作了吗? </title>
<meta name="description" content="从比较Palmmicro PA1688, AR1688(KSZ8842), PA3288(ENC28J60)和PA6488上以太网PHY连接状态的检测和利用看我们的进步.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
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
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>从PA1688到PA6488 - 以太网PHY开始工作了吗? </B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年11月20日</td></tr>
<tr><td>到目前为止我给4种不同的MAC编写过了软件, 在加电后, 无一例外都需要等待1-2秒后才能正常工作. 由于Windows DDK中的NE2000驱动源程序同样等待了2秒钟, 在很长一段时间我都认为这种愚蠢等待的代码是天经地义的. 
在一年前我甚至还跟一个测试<a href="../ar1688/20080729cn.php">DM9003</a>的说, 尽管这个芯片有各种其它问题, 但是等待2秒后才能正常工作不算它的问题. 
<br /><a href="../../../pa6488/indexcn.html">PA6488</a>集成了MAC, 在<a href="20090819cn.php">PA648C</a>视频压缩模块板上我们用了一个单独的PHY芯片. 
上周我注意到<a href="../ar1688/20080811cn.php">syslog</a>的调试信息<b>PHY linked</b>总是能收到. 这样我就能在中断处理程序中马上开始其它网络工作如DHCP, 而不用再漫无目的死等2秒钟了. 
<br />在过去的AR1688开发中, 绝大多数的网络改进都同时更新回了<a href="../../../pa1688/indexcn.html">PA1688</a>. 不过这次PA6488结构上太不同了, 以至于我无法再改回去.  
<br />没有在<a href="../ar1688/20080615cn.php">RTL8019AS</a>上使用93C46导致了PHY的连接信息无法检测到. 而在AR168MK VoIP模块使用的<a href="../ar1688/20081124cn.php">KSZ8842</a>上, 
因为没有使用中断处理程序, 由每隔1秒的定时器检测出来的PHY连接状态也不会让总体等待时间有效下降. 
<br />由于PA1688和AR1688都有DSP处理语音, 在控制器方面, 网络处理就是它最重要的工作了, 我们因此没有使用中断处理网络工作. 而在PA6488上, 最繁忙工作的是进行视频处理, 因此我们就把全部网络任务集中在了中断处理程序中. 
<br />&nbsp;
<br /><font color=magenta>2015年3月10日更新</font>
<br />在2012年的时候我把PA6488网络工作从中断中改到了主循环中, 希望能够提高cache的性能. 检测网络连接状态同样改到了主循环, 这样我可以尽快开始DHCP.
这个<i>聪明的</i>主意其实也能用到KSZ8842上,不过不知道什么原因我当时没有这么去做.
<br /><a href="../../../pa3288/indexcn.html">PA3288</a>方案中使用的<a href="20090808cn.php">ENC28J60</a>网络芯片是我编写软件的第5个MAC. 当我完成让它跟PA6488的MAC以同样方式工作后,
我突然意识到我能把这个也用到KSZ8842上. 这样在6年多以后, 我把2秒的等待从KSZ8842的初始化过程中去掉了.
其结果是<a href="../../../ar1688/software/sw063cn.html">0.63.026</a>的AR168P网络电话和AR168MT网络语音VoIP模块测试软件.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
