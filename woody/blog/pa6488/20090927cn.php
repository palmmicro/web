<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - 安全模式恢复</title>
<meta name="description" content="所有Palmmicro的产品都有安全模式恢复功能. 设备上的软件分成2个独立的部分. 如果主程序因为错误的软件导致不能启动, 用户总是可以在安全模式下重新升级原来正确的软件.">
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
<tr><td class=THead><B>从PA1688到PA6488 - 安全模式恢复</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年9月27日</td></tr>
<tr><td><a href="../../../pa1688/indexcn.html">PA1688</a>设备升级一次软件大约要花一分钟时间, 这期间如果供电中断, 设备就不工作了. 为了防止出现这样的硬件故障, 我们设计了安全模式恢复. 软件被分成2个部分.
PA1688总是从安全模式部分的软件启动. 如果在启动过程中检测到*键就停留在安全模式中, 否则的话进入软件正常运行部分. 安全模式部分的软件很小, 因此更新得比较快, 在更新过程中遭遇断电的可能性也就比较小.
更重要的是, 安全模式软件被设计成为最终用户不需要再次更新. 这样当最终用户在使用和更新正常软件过程中如果碰到问题, 他们总是可以通过进入安全模式更新而重新回到以前的正确版本上. 
<br />一旦安全模式被启用, 我们发现它对软件开发工作尤其有用. 因为安全模式的存在, 我们再也不用担心错误编写的代码会毁了整个系统了. 
<br />由于8051 64k字节代码大小限制, 正常运行部分的软件因为比较大而需要做代码页面切换, 这样又会带来额外的代码开销. 为减小总体代码大小, 我们把例如出厂测试这种特殊软件也放在了不需要做代码页面切换的安全模式软件部分. 
<br />所有PA1688设备在进入安全模式后, IP地址都是192.168.1.100, MAC地址都是00-09-45-00-00-00. 有时候短暂断电不会让SDRAM数据丢失, 用户可能需要按住*键重新加电启动2次才会进入缺省的IP和MAC地址.
所有PA1688的网关上面都有一个特殊的安全模式键, 按住这个键加电进入安全模式. 而按住网关外接普通电话上的*键不会起作用. 
<br /><a href="../../../ar1688/indexcn.html">AR1688</a>安全模式的缺省IP是192.168.1.200, 缺省<a href="../ar1688/20070827cn.php">MAC</a>是00-18-1f-00-00-00. 用户只用按住*键加电启动一次就能进入缺省地址. 慢慢的我们觉得按住*键加电起动比较愚蠢. 因为我们主要做的都是网络电话, 现成的有个摘挂机的手柄.
这样后来新设计的AR1688网络电话就改为了如果启动的时候手柄是摘机状态, 就停留在<a href="../ar1688/20080624cn.php">安全模式</a>中, 如果是挂机状态, 就接着进入正常运行软件部分.
AR168M网络语音模块有个跳线区分是否进入安全模式. 这个跳线跟网络电话机的摘挂机用的同一个GPIO. 因为AR1688的Z80控制器也需要做代码页面切换, 我们就仍然把出厂测试等代码跟安全模式放在一起, 减少代码页面切换带来的额外开销. 
<br /><a href="../../../pa6488/indexcn.html">PA6488</a>安全模式的缺省IP和MAC仍然是192.168.1.200和00-18-1f-00-00-00. 用摘挂机来判断是否进入安全模式也保留了下来, 如果开机的时候是摘机状态就留在安全模式中.
PA648C模拟视频压缩模块没有摘挂机, 我们把摘挂机用的GPIO同样设计成了一个跳线. 由于我们终于摆脱了代码页面切换, 出厂测试的代码就不再放到安全模式部分了.
事实上, 为了充分减小安全模式的代码, 连LCD显示都从安全模式代码中分了出来.
<br />&nbsp;
<br /><font color=gray>这个<a href="../../../pa1688/user/ag168vcn.html">AG168V</a>背面图中唯一的'IP'键就是PA1688网关中用来进入安全模式的按键.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/g1681/back.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway back view." /></td></tr>
<tr><td>
<br />&nbsp;
<br /><font color=magenta>2009年11月29日更新</font>
<br />在AR1688和PA1688的安全模式中, 键入#9*0后设备会重新启动离开安全模式.
而在最近的软件改动中, 我们开始采用<b>摘机</b>作为AR1688和PA6488开机进入安全模式的指示, 自然我们要把摘挂机用得更彻底些. 当在安全模式中检测到<b>挂机</b>后, AR1688和PA6488会重新启动离开安全模式. 
<br />这个新功能可能会对用按住*号开机进入安全模式的较老的AR1688设备使用者带来一点困惑. 因为在挂机状态下按住*号进入了安全模式后会很快因为挂机状态被检测到而重新启动离开安全模式.
用户需要记住在安全模式中要一直保持摘机状态. 
<br />跟PA1688不同, AR1688和PA6488的<a href="../ar1688/20061211cn.php">软件API</a>都不能编译安全模式的文件. 想要测试这个新功能的AR1688客户需要写信找我们要新的安全模式升级程序. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
