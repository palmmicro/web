<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>过度软件优化</title>
<meta name="description" content="过度的RTL8019AS软件优化导致基于PA1688方案的ET6602网络电话工作不稳定, 为了这个明显是缺乏测试的个别现象, 结果我们只好又返回了随大流的版本.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>过度软件优化</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年4月27日</td></tr>
<tr><td>发现和解决了<a href="20110420cn.php">LM386</a>问题的这个用户从去年开始就有另外一个问题. 他从<a href="http://tradearchive.taobao.com/trade/detail/trade_snap.htm?trade_id=56743898219541" target=_blank>淘宝</a>上花50人民币买了个<a href="../../../pa1688/user/et6602cn.html">ET6602</a>网络电话, 然后发现这个电话只能用PA168T 1.51版本软件, 更新到当时的1.64后就会非常不稳定. 那时候我猜想这只不过是另外一个不能使用我们通用软件的<a href="20080806cn.php">非标准</a>PA1688设备而已. 不过现在这个用户对技术的热情连同他解决问题的能力给了我深刻印象, 我于是决定再次看看这个问题. 
<br />出乎我意料的是, 这个ET6602的确能在我们标准1.51(这是<a href="../palmmicro/20080326cn.php">Centrality</a>在2006年停止<a href="../../../pa1688/indexcn.html">PA1688</a>生意后我们发布的第一个版本)软件下工作, 但是换到目前的1.66正式版本后就很容易死机. 然后我测试了1.57死机、1.54正常、1.56正常. 比较1.56和1.57源代码后, 很清楚是其中的<a href="../ar1688/20080615cn.php">RTL8019AS</a>软件过度优化导致了不稳定的问题. 
<br />事实上我还记得这些改动, 当时先是在<a href="../../../ar1688/indexcn.html">AR1688</a>性能优化过程中修改的, 然后返回应用在了PA1688上, 却没有在众多PA1688设备中广泛测试. 显然并非所有PA1688设备都生而平等. 这个ET6602在硬件上有明显缺陷, 需要特殊的软件异常保护. 在恢复了过度优化的软件内容后, 我上传了<a href="../../../pa1688/software/sw167cn.html">1.67</a>测试版本到我们网站.  
</td></tr>
<tr><td><img src=../../../pa1688/user/et6602/6s.jpg alt="PA1688 based ET6602 IP phone PCB" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
