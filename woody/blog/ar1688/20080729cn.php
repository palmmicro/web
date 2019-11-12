<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>路由器, PPPoE和DM9003</title>
<meta name="description" content="Palmmicro PA1688和AR1688产品上有关PPPoE, PoE和VLAN等的设计支持, 包括DM9003的各种特性的使用, 以及它跟RTL8019AS和KSZ8842的比较.">
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
<tr><td class=THead><B>路由器, PPPoE和DM9003</B></td></tr>
<tr><td>2008年7月29日</td></tr>
<tr><td>很多用户喜欢问你们支持PPPoE吗? 听上去是个简单而专业的问题. 不过我现在终于明白了它的言外之意. 当有人问PPPoE的时候, 可以肯定他真正想知道的是你的网络电话有没有路由器功能. 
<br />答案是否定的. AR1688没有路由器功能, 而且由于<a href="20080121cn.php">Z80</a>处理能力上的限制, 我们也不可能在以后的软件中加上它. 
<br />不过在这么多虚假的PPPoE需求轰炸下, 我们还是加上了它. 你可以把AR1688网络电话放在路由器位置上, 例如用RJ45网线连接ADSL猫, AR1688可以自己通过PPPoE协议拨号上网, 
但是它不能让你接在电话另外一个RJ45接口上的其他设备如PC上网. 
<br />对于<a href="20080615cn.php">RTL8019AS</a>来说, 虽然理论上PPPoE会带来一点网络性能下降, 实际上是区分不出来的. 
<br />DM9003的一个好处是它可以用硬件计算IP, UDP和TCP的校验值. 这对处理器性能有限的AR1688尤其有用. 不过DM9003硬件计算PPPoE包的校验值的时候会出错, 我们只好在使用PPPoE的时候关闭这个功能. 
这样一来使用PPPoE的时候DM9003的网络性能会明显下降. 
<br />对VoIP功能来说, 这些性能上的差异都不构成任何真正的区别. 不过随着日后视频功能的加入, 我们就会看到区别了. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE和PoE</td></tr>
<tr><td class=Update>2008年7月30日更新</td></tr>
<tr><td>跟PPPoE/路由器带来的混淆比, 把PoE和PPPoE弄混的客户要少很多, 不过还是有! 
<br />PoE: Power over ethernet 以太网供电.
<br />PPPoE: PPP over ethernet 以太网上的PPP. PPP是宽带普及前拨号上网使用的协议.
<br />以太网上提供所有东西的梦想是从大约10年前开始的, 现在已经基本上被无线上提供所有东西的另外一个梦想取代了. 这么多年后PoE的使用依然并不普及. 
<br />我们第一个PoE设计来自华为3Com, 当时它们购买的<a href="../../../pa1688/indexcn.html">PA1688</a>网络电话上需要额外的PoE. 此功能需要额外几个元器件, 增加大约2美元的成本. 
因为PoE需求很少, 通常生产厂商会在PCB上包括PoE设计, 需要的时候才焊接PoE相关器件. AR1688继承和优化了这个设计. 举例来说, 迪迈特的GP1266网络电话可以提供贵20人民币的特殊PoE版本. 
<br /><a href="../../../ar1688/user/gp1266cn.html">GP1266</a>有2个RJ45口, 在网络交换机功能上它们是一样的. 在使用PoE版本的时候, 只有标注LAN1的口可以接受供电. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE和PPP源代码</td></tr>
<tr><td class=Update>2008年8月3日更新</td></tr>
<tr><td><i>AR1688软件API</i>的名字意味着AR1688不是全部开放源代码的. 我们保留了一点点秘密. PPPoE和PPP源代码曾经属于秘密, 直到上周有人问如何基于API加上802.1X的支持. 
<br />加802.1X EAPOL协议, 开发者要知道如何直接读写网络数据包, 如何调用MD5函数连接RADIUS服务器. 从0.36 <a href="20061211cn.php">API</a>开始, 
AR1688开发人员会发现SDCC\src下增加了<b>net.c</b>, <b>ppp.c</b>和<b>pppoe.c</b> 3个新文件, SDCC\include下增加了<b>ne2000.h</b>和<b>dm9000.h</b> 2个新文件. 
PPPoE的实现可以作为直接读写网络数据包的例子, PPP中CHAP的实现可以作为MD5调用的例子. <a href="20071110cn.php">IAX2</a>和<a href="20060929cn.php">SIP</a>源代码中有更多MD5例子可以参考, 
不过CHAP例子对非VoIP的开发者来说也许更加容易些. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE和VLAN</td></tr>
<tr><td class=Update>2008年8月4日更新</td></tr>
<tr><td>几年前一个PA1688网络电话用户写了RTL8019AS上的802.1Q和802.1p VLAN支持代码. 2006年初时候我们把它搬到了AR1688软件上. 运行的时候, AR1688的Z80控制器负责从接收数据中挪掉VLAN标签和在发送数据中加上VLAN标签. 
<br />DM9003中网络交换机对VLAN有更好的支持, 可以在硬件上挪掉接收数据中的VLAN标签, 如果需要的话还可以在发送数据中由硬件自动加上VLAN标签. 当使用802.1Q VLAN的时候, 这是DM9003又一个加速网络性能的好功能. 
<br />如果PPPoE一起用的话, 有兴趣的可以考虑在MAC包头后应该放什么数据, VLAN标签还是PPPoE包头? 换句话说, 是PPPoE数据包中含VLAN还是相反, 或者2者都可以? 
<br />当然读相关标准可以得到答案. 也可以从DM9003手册中知道, 既然VLAN标签是在Z80处理器处理PPPoE包后由硬件处理的, 那唯一可能的就是VLAN数据包中含PPPoE. 
也就是说, PPPoE可以在VLAN网络下使用, 但是不能构建基于PPPoE拨号上网的VLAN. 回过头看PA1688上的RTL8019AS 802.1Q VLAN软件, 果然就是这么做的! 我们不禁感慨这些年有多少网络高手在玩我们这点小设备啊. 
<br />当使用802.1Q VLAN的时候, 802.3的最大数据长度从1514增加到了1518字节(不含CRC), 增加的4个字节用于VLAN标签. 再一次我们看到, PPPoE就没有这个长度<i>特权</i>, 使用PPPoE只会因为PPPoE包头占用8个字节而减少8个字节的数据. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>如何测试VLAN</td></tr>
<tr><td class=Update>2008年12月6日更新</td></tr>
<tr><td>在Nic Bellamy写完PA1688网络电话上RTL8019AS的802.1Q VLAN代码4年多以后, 我们终于可以测试VLAN功能了.  
<br />DM9003和<a href="20081124cn.php">KSZ8842</a>芯片都支持VLAN功能, 因此AR168O和AR168P网络电话都可以当成VLAN交换机使用. 为了保持一个简单的用户界面, 我们依然只在话机设置中放一个VLAN标签选项. 
VLAN交换机上的3个口都使用同样VLAN标签. 毕竟我们是设计网络电话, 而不是VLAN交换机. 
<br />普通的AR168O和AR168P软件跟基于RTL8019AS的话机软件一样工作, 在发送数据上加VLAN标签, 只响应VLAN标签匹配的接收数据. 
跟外面的非VLAN世界联系的时候, 我们需要特殊OEM_VLAN选项编译出来的软件, 让电话的端口1连接外面的非VLAN交换机或者路由器. 特殊软件<a href="20080607cn.php">编译命令行</a>类似于下面: 
<br /><b>mk ar168o iax2 us vlan</b>
<br /><b>mk ar168p sip cn vlan</b>
<br />迪迈特GP2268(AR168P)网络电话使用GP1260和GP1266同样的机壳, 上面靠近电源插座的<i>LAN1</i>标记端口1. 当使用其它生产厂商没有明显标记的设备时, 可以在2个RJ45口上插拔网线确定端口1和端口2的位置, 
基于<a href="20080811cn.php">syslog</a>标准的调试信息会指示端口连接情况. 
这个新功能也是DM9003和KSZ8842话机特有的, 在RTL8019AS上, 因为我们从一开始就毫不犹豫地节省了93C46 EEPROM, 所以无法检测网络连接情况. 
<br /><font color=gray>GP1260(AR168G)/GP1266/GP2268(AR168P)网络电话LAN1和LAN2接口.</font>
</td></tr>
<tr><td><img src=../../../ar1688/user/gp1266/03.jpg alt="GP1266 IP phone POWER, LAN1 and LAN2 interface." /></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>彻底放弃DM9003</td></tr>
<tr><td class=Update>2012年12月15日更新</td></tr>
<tr><td>软件API中删除不稳定的硬件设计型号VER_AR168O/VER_AR168KD和相关DM9003代码.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=THead>PPPoE功能变成可选项</td></tr>
<tr><td class=Update>2015年9月9日更新</td></tr>
<tr><td>在<b>version.h</b>中增加<b><i>SYS_PPPOE</i></b>, 只有在它定义了的时候才支持PPPoE功能. 对于不需要PPPoE的客户, 可以用节省出来的空间开发更多自己的功能. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
