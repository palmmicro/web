<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>按#键呼叫</title>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>按#键呼叫</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年3月20日</td></tr>
<tr><td>在网络电话和小网关使用的早期, 用户们"被迫"使用'#'号键来呼叫. 不像传统电话, 这些设备通常都不知道什么时候拨号结束. 在使用古老<a href="20060929cn.php">H.323</a>协议的年代有许多IP地址对打的呼叫, 尤其是跟Windows自带的NetMeeting测试互通的时候. 由于'*'号键通常用来输入网络地址中的'.', 就只剩下'#'用来呼出了. 
<br />传统电话运营商痛恨H.323. 不过在它们把自己的主干网纷纷转成IP网的年代, 它们同样想在终端上有所作为. MGCP协议就这样失败的出炉了. 唯一可取的是其中的"digit maps", 这样终端可以知道什么时候算是拨号完毕. 
<br />SIP和<a href="20071110cn.php">IAX2</a>协议在刚开始制定的时候也没有考虑这个问题. 后来加了"Overlapped Sending"或者"Server's Dial Plan"这样一些东西修修补补. 
<br />在MGCP协议的"digit maps"的启发下, AR1688和PA1688的设备都有单独的"<a href="20070321cn.php">拨号映射</a>"的选项, 用来自定义拨号规则, 这样可以在拨号完成后自动呼出. 
<br />事实上传统电话运营商在特殊服务号码中广泛使用了'#'键, <a href="../../../pa1688/indexcn.html">PA1688</a>的设备刚开始跟华为和UT的系统测试的时候碰到了大量这种问题, 我们被迫在"service type"的选项中加了"huawei"和"utstarcom", 用户选择这2个选项后按'#'键就不会呼出了. 
<br />刚开始做<a href="../../../ar1688/indexcn.html">AR1688</a>软件的时候我们吸取教训, 决定彻底放弃'#'键呼出的方式. 但是日子久了, 老用户还是喜欢用'#'号键呼出, 我们后来又被迫加了个"按#键呼叫"的选项. 
<br />在美国, '#'号键被叫做Pound, 很长一段时间我都会哼哼"池塘边的榕树上, 知了在声声叫着夏天". 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
