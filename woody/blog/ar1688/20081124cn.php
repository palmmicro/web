<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Micrel KSZ8842网络芯片</title>
<meta name="description" content="我们尝试在AR1688方案中使用Micrel KSZ8842替换RTL8019AS和RTL8305. 看上去充满希望, 不光节省了芯片数量, 而且性能更佳, 功耗也更低.">
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
<tr><td class=THead><B>Micrel KSZ8842网络芯片</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年11月24日</td></tr>
<tr><td>除了RTL8019AS和DM9003驱动源代码外, 用户在即将发布的0.40 API中还能找到开发中的Micrel KSZ8842源代码, 也是基于GPL版权协议. 
我们希望这个芯片能够在不久后的参考设计中替代RTL8019AS+<a href="20061213cn.php">RTL8305</a>组合. 目前的测试硬件看上去很有希望, 从发热上比较这个芯片甚至比RTL8305还小, 就不用说跟滚烫的DM9003比了. 
<br />Kendin曾经是VoIP领域最活跃的网络交换机芯片公司, 它的KS8993是第一个专门为VoIP应用设计的3口交换机芯片, 至今我们手头还有几片多年前从它Santa Clara办公室拿的样片. 
然而单纯的节省芯片成本并不能保证赢得市场, 5口交换机芯片RTL8305靠它在其它领域的巨大销售量反而赢了VoIP市场. 在我们使用台湾廉价网络交换机芯片期间, Kendin合并进了Micrel.  
<br />DM9003成了死马后, 我们重新把眼光回到了Kendin/Micrel上, 开始使用它专门为网络语音和视频应用设计的KSZ8842. 这个带8位CPU总线接口的2口交换机芯片比DM9003面世更早, 再次成为VoIP领域的第一个. 
而且它真的很凉快! 我猜它是用.13工艺生产的, 其它的如DM9003估计都还是.18工艺. 
<br />我很明白在今天32位的ARM和MIPS芯片无处不在的时候, 我看上去很奇怪, 总是在自夸我们8位<a href="20080121cn.php">Z80</a>控制器的网络性能. 不过我就是忍不住. 
<br />目前初始的KSZ8842软件网络性能还比较差, 它还没有做汇编优化. 另外跟DM9003不同, KSZ8842本身没有硬件计算校验值的功能. 我在这里记录了3个主要的性能数据, 等软件优化后再回头来比较. AR1688内部Z80在所有的测试下都跑48Mhz.
<br />AR168P是我们基于KSZ8842的新<a href="../../../ar1688/indexcn.html">AR1688</a>硬件参考设计. 
<br />迪迈特GP2266是基于<a href="20080615cn.php">RTL8019AS</a>+RTL8305组合的设计. 它一直没有量产, 因为开始它在等AR168O/DM9003, 而现在又在等AR168P/KSZ8842设计. 
<br />1) Ping 2952字节, GP2266需要21毫秒, AR168P需要35ms. 
<br />2) 升级软件, GP2266需要16秒, 大约41k字节/秒, AR168P需要19秒, 34kB/s. 
<br />3) TFTP吞吐量测试, GP2266达到187k字节/秒 (1.50Mbps), AR168P 127kB/s (1.01Mbps). 
<br />&nbsp;
<br /><font color=magenta>2008年11月25日更新</font>
<br />经过24小时后软件优化后的AR168P网络性能. 
<br />1) Ping 2952字节, 19毫秒, 比GP2266的21毫秒稍快. 
<br />2) 升级软件, 16秒, 跟GP2266一样. 
<br />3) TFTP吞吐量测试, 208k字节/秒, 1.66Mbps, 比GP2266快11%. 
<br />很高兴看到KSZ8842基本上都比RTL8019AS快. 开始我还以为KSZ8842会稍慢, 因为它读写数据过程复杂一些. 显然更快的总线操作速度起了帮助作用. 
</td></tr>
<tr><td><img src=../../../pa1688/user/hop3003/rtl8305sb.jpg alt="RTL8305SB chip in HOP3003 IP phone."></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
