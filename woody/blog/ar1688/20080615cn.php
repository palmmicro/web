<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>告别RTL8019AS</title>
<meta name="keywords" content="RTL8019AS, DM9003, RTL8305">
<meta name="description" content="我们尝试在AR1688方案中使用DM9003替换RTL8019AS和RTL8305. 一开始看上去充满希望, 不过经过几个月的测试后还是失望而归. 不要使用DM9003!">
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
<tr><td class=THead><B>告别RTL8019AS</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年6月15日</td></tr>
<tr><td>在2000年的时候, 我们是最早把Realtek RTL8019AS 10Base-T网络芯片用于嵌入式系统的公司之一. 第一个<a href="../../../pa1688/indexcn.html">PA1688</a>上面RTL8019AS的驱动是从Windows DDK中NE2000源程序修改而来.
这些年来我们已经对RTL8019AS内部存储器和寄存器了如指掌. 在大量代码优化和几乎全部的原地工作优化下, AR1688上面的TCPIP协议和RTL8019AS驱动是世界上8位处理器中运行最快而且需要内存最少的.
当<a href="20080121cn.php">Z80</a>运行在48MHz时候, 用TFTP测试的UDP吞吐率可以到1.5Mbps. 在全面控制RTL8019AS内部存储器的情况下, 我们实现了原地工作的IP分包支持,
同时还实现了一个<a href="20071116cn.php">Mini Run</a>的策略在主程序被MD5计算之类的耗时任务阻塞的情况下可以优先处理RTP数据. 
<br />在上世纪90年代, RTL8019AS并不是PC上ISA总线网卡芯片唯一提供者. Davicom DM9008当时同样是一个占据了很大市场份额的芯片. 但是DM9008的内部处理看上去比较慢, 需要PC_READY信号配合工作. 
在PA1688和<a href="../../../ar1688/indexcn.html">AR1688</a>上我们都做不到这一点.
<br />在PA1688生意达到巅峰的2005年, 一个Davicom的市场人员走访了我们北京办公室, 给我们介绍新的DM9000 100Base-T芯片. 我告诉他我们并不需要一个同样价格的芯片替换RTL8019AS, 即使性能更好也不起作用. 
但是我们需要一个同时有MAC和2口网络交换机功能的芯片. 因为很多客户都希望网络电话有2个网口, 我们一直在使用另外一片RTL8305芯片实现网络交换机功能.
我们进行了相当好的可行性讨论, 不过他临出门的时候很严肃的说了一句: 我没有正式答应你这个芯片.
<br />2007年的时候, 带MAC和2口网络交换机DM9003面世了. 不过对PA1688来说已经为时太晚. 我们当时忙于新AR1688方案的开发, 一直没有测试它.
<br />如今我们终于完成了DM9003和AR1688的配合工作. 结果相当好. 在更快的总线速度和硬件计算IP/UDP校验码的帮助下, UDP吞吐率可以到2.2Mbps, 比相同条件下测试RTL8019AS提高了50%的性能.
我们终于可以跟古老的RTL8019AS说再见了.
<br />&nbsp;
<br /><font color=magenta>2008年11月11日更新</font>
<br />上周一个Davicom代理商问我目前AR1688用DM9003的产品量产情况如何. 他很惊讶我告诉他还没量产. 他甚至翻出了我5个月前写的这篇文章表达他的不理解.
<br />DM9003太热了. 我指的是它的温度实在太高, 手指摸上去都应该小心被烫到. 这个芯片让整个网络电话硬件板都处于一个温暖状态. 我们有3个客户生产了样机, 没有1个觉得这么热可以接受.
<br />另外一个问题是DM9003会带来通话时额外的噪声. 虽然这个问题客户的反应不像发热问题这么大, 但是我们的硬件部门认为不可接受.
<br />同时我们还有一个软件问题, 软件接收数据有时候会完全停止工作. 我个人认为是内部接收缓冲区溢出了, 不过我一直没有找到解决的办法.
<br />由于以上问题在我们基于RTL8019AS的设计中都不存在, 所以现在对RTL8019AS说再见还嫌太早.
<br />&nbsp;
<br /><font color=magenta>2008年11月12日更新</font>
<br />我们计划下周发布AR1688 0.40软件, 其中包括RTL8019AS和DM9003驱动源代码. 跟API的其它部分一样, 都是基于GPL版权的.
<br />DM9003驱动源代码是应Davicom代理商的要求提供的, 他希望能够帮助我们解决软件接收数据的问题. 技术支持人员告诉我他们帮助不少其它DM9000/DM9003客户解决了类似的特殊问题.
对我而言听上去更像个坏消息, 说明这个问题对DM9000/DM9003来说是普遍存在的. 不过死马只能当活马医了.
<br />&nbsp;
<br /><font color=magenta>2011年3月15日更新</font>
<br />AR1688和PA1688都不是专门的网络电话芯片, 它们都需要外接网络芯片. 所有PA1688设备上都使用了RTL8019AS.
尽管AR1688在2008年底开始支持<a href="20081124cn.php">Micrel KSZ8842</a>, 实际上绝大多数AR1688设备仍然用PA1688完全相同的方式使用RTL8019AS. 在过去的5年中我们并没有做多少创新工作.
<br />为了BOM简单节省费用, 我们从2000年一开始就省略了硬件部分的<a href="20080729cn.php">93C46 EEPROM</a>. 这是为什么我们的RTL8019AS只能工作在10Mbps半双工模式, 而且不能检测网线插拔.
这是软件无法解决的问题, 我只能一次次让这些专业而认真的询问客户失望.  
<br />虽然在新AR1688设计中加上93C46是可行的, 但是我们强烈反对这么做. 随着我们第3代<a href="../../../pa6488/indexcn.html">PA6488</a>方案即将在今年进入市场, 我们需要集中开发资源, 停止在AR1688平台上开发新设计.
同时, 全部未完成的AR1688网关、USB和WiFi设计也一律抛弃. 我们将只接着提供现有成熟的AR1688设计. 
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/rtl8019as.jpg alt="RTL8019AS chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
<tr><td>&nbsp;
<br /><font color=magenta>2012年9月10日更新</font>
<br />使用了12年的RTL8019AS后, 我们第一次碰上了严重的质量问题. 
<br />几个月前一个老客户跟我们反映最近一批生产中发现了大量坏的RTL8019AS芯片. 我们从来没有听说过这个问题, 一开始都觉得匪夷所思.
因为我们无法提供有效的帮助, 这个客户自己做了块带RTL8019AS插座的板子测试没有使用的芯片. 测试结果让我惊呆了, 从一整包660片中, 居然挑出了116片坏的!
<br />这个客户不在国内, 跟往常一样这些坏RTL8019AS是跟AR1688芯片一起由我们从深圳寄过去的. 为了比对结果, 他们从当地的一个Realtek代理处找了264片RTL8019AS重复进行测试, 结果264片都是好的.
<br />我们收到退回来的坏芯片后开始在各种不同的AR1688板子上测试. 目前为止焊了15片, 证实了至少其中6片不工作.
<br />跟这个客户一样, 现在我们只能自己也再做块带RTL8019AS插座的AR1688板子, 在每片RTL8019AS发出去前都测试一次!
</td></tr>
<tr><td><img src=../photo/20120910.jpg alt="RTL8019AS as the Prince and the Pauper." /></td></tr></td></tr>
<tr><td>&nbsp;
<br /><font color=magenta>2012年12月15日更新</font>
<br />软件API中删除不稳定的硬件设计型号VER_AR168O/VER_AR168KD和相关DM9003代码.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
