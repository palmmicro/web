<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>在Asterisk系统下禁用STUN</title>
<meta name="description" content="AR1688用户不要在Asterisk系统下使用STUN选项. 在FWD和SIPphone都停止了免费SIP服务后, 现在测试STUN越来越不容易了. 希望GNU SIP Witch能日后扛起大旗.">
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
<tr><td class=THead><B>在Asterisk系统下禁用STUN</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年4月3日</td></tr>
<tr><td>昨天一个国内客户报告<a href="../../../ar1688/user/ywh201cn.html">YWH201</a>跟Freeiris2系统配合使用有问题. 能登录但是拨号后总会出现"wrong number"的错误. 按照我们标准<a href="20070704cn.php">调试</a>流程, 我让他升级到了最新的<a href="../../../ar1688/software/sw052cn.html">0.52</a>版本软件, 然后检查了话机设置, 看上去都正常. 接着我开始研究Freeiris2的网站, 同时搜索其它人对这个系统的评论. 很快我就发现它其实是基于<a href="http://www.asterisk.org/" target=_blank>Asterisk</a>. 这下问题就简单了, 多年来我们一直都知道跟Asterisk配合工作的时候不能在<a href="../../../ar1688/indexcn.html">AR1688</a>和<a href="../../../pa1688/indexcn.html">PA1688</a>设备上打开STUN选项. 客户关闭STUN后就一切正常了. 
<br />我们一直在用FWD(free world dialup)和<a href="../../../res/sipphonecn.html">SIPphone</a>(<a href="http://www.google.com/gizmo5/" target=_blank>Gizmo5</a>)这些免费服务测试STUN. 在<a href="20071116cn.php">FWD</a>于2008年停止服务后, Gizmo5从今天开始也停止服务了, 我们马上需要找新的测试平台. 
<br /><a href="http://www.gnutelephony.org" target=_blank>GNU Telephony</a>在上个月宣布了GNU Free Call计划. 我们同时也在<a href="../../../pa6488/indexcn.html">PA6488</a> SIP开发的同时积极地加进去GNU SIP Witch的支持. 不过当我今天去它们网上查看有什么更新时, 发现网站服务处于停止状态, 看来今天实在不是一个好日子! 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
