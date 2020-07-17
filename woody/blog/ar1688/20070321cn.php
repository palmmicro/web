<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>拨号映射</title>
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>拨号映射</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年3月21日</td></tr>
<tr><td>过去我们在<a href="../../../pa1688/indexcn.html">PA1688</a>上支持7种不同通信协议, 很多协议其实根本没有带来什么销售业绩, MGCP就是其中一个失败者. 不过在MGCP上的工作为其它协议带来了新功能. 今天<a href="../../../ar1688/indexcn.html">AR1688</a>支持SIP和IAX2协议, 2者都有类似于MGCP自带的拨号映射功能. 
<br />拨号映射的详细说明在RFC 3435的2.1.5部分, 它用于判断电话用户是否拨号完毕, 方式是把已经拨的号码跟一个拨号映射规则表比较. 在MGCP协议中, 拨号映射的规则表来自服务器消息. 在我们的SIP和<a href="20060929cn.php">IAX2</a>中, 规则表由用户或者系统预先定好, 保存在话机设置中, 并且可以在自动管理中自动更新. 
<br />在我们的软件<a href="20061211cn.php">API</a>中, 用命令行"sdcc\bin\getopt.bat xxx.xxx.xxx.xxx", 会弹出options.txt, 其中有2个不同的部分[settings]和[digitmap], 拨号映射规则表就在[digitmap]中. 用户也可以通过用网页浏览器访问网络电话IP地址浏览和修改拨号映射规则表. 
<br /><a href="../../../res/sipphonecn.html">SipPhone</a>是我最常用的测试点之一, 它的测试号码如下: 
<br />**: 播放你自己的SIPphone号码
<br />*0: 测试你的路由器是否跟SIP兼容
<br />411: 语音提示的Tellme信息服务
<br />1-747-474-ECHO(1-747-474-3246): 回声测试 - 重复你自己说的话
<br />1-747-474-5000: SIPphone欢迎提示
<br />1-747-XXX-XXXX: 呼叫其它SIPphone号码
<br />针对以上拨号规则, 定义相应规则表如下: 
<br />*x: 负责判断**和*0
<br />4xx: 负责判断411
<br />1xxxxxxxxxx: 负责判断1-xxx-xxx-xxxx号码
<br />x.T: 负责其它号码
<br />当拨号映射功能不用的时候, 用户需要在输入号码结束后按下"呼叫"键呼出, 跟用手机一样. 在VoIP的早期, 很多软硬件都用'#'键作为呼叫键. 随着VoIP和传统PSTN的融合, 因为#在PSTN系统中大量用于附加服务, 今天用#键当"呼叫"键功能已经不再是个好主意了. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
