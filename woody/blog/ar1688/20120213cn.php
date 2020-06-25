<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>不带串口功能的AR168M网络语音模块</title>
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
<tr><td class=THead><B>不带串口功能的AR168M网络语音模块</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2012年2月13日</td></tr>
<tr><td>在用<a href="20110403cn.php">Asterisk</a>仔细测试过他们自己生产的<a href="../../../ar1688/modulecn.html">AR168M</a>硬件后, 一个客户给我们指出通话中<a href="20090416cn.php">G.729B</a>的语音在交换注册信息后可能会完全丢失. 
<br />这对我们来说是个新问题. 结果我们发现他们在用AR168M开发RoIP(Radio over IP)功能, 没有使用任何外部控制器来进行<a href="20071119cn.php">串口</a>通信. 在他们的硬件上关闭串口软件功能后问题解决. 
<br />想想都觉得可笑, 2个月前我们刚刚在网络电话上特意增加了串口<a href="20111205cn.php">测试功能</a>, 而现在我们却要从AR168M模块上去掉串口功能. 要知道, AR168M就是为方便其他控制器通过串口简单的实现网络语音功能而设计的. 
<br />为了给所有不需要用串口的AR168M用户一个交代, 从0.57.001版本开始我们增加了编译选项OEM_ROIP. 新版API可以在AR1688 <a href="../../../ar1688/software/sw057cn.html">0.57</a>测试页面下载. 命令行"mk ar168m sip cn roip"会产生不带串口功能的AR168M升级软件. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
