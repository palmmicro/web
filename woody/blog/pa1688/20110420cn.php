<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>额的神啊! AT323话机居然LM386一直在工作!</title>
<meta name="description" content="PA168S(AT323)话机中的LM386一直在工作, 用户反映后在PA168T参考设计解决了这个问题. 包括PA168S在内, 其它PA1688设备中LM386的使用也都可以参考这个方案解决. 这是个典型的用户驱动Palmmicro产品改进的故事.">
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
<tr><td class=THead><B>额的神啊! AT323话机居然LM386一直在工作! </B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年4月20日</td></tr>
<tr><td>这个近似于咆哮体的标题来自一个<a href="../../../pa1688/user/at323cn.html">AT323</a>用户, 他在夜深人静的时候发现话机上的LM386一直在持续产生轻微流水般的噪音.
测量了电流后, 他发现不通话时11V输入下大约是200mA, 折合2W的功耗.  
<br />幸运的是他发现了另外一台<a href="../../../pa1688/user/et6602cn.html">PA168T</a>话机没有这个噪声.
比较二者的<a href="../../../pa1688/hardwarecn.html">硬件</a>区别后, 他发现PA168T使用了PA1688的第53管脚HFPOW_CTL信号, 通过额外的S9014+S8550放大电路后控制LM386的工作开关.
在照样修改了他自己的AT323电路后问题解决, 工作电流减小到170mA. 
<br />事实上他不是第一个发现这个LM386问题的. <a href="../../../pa1688/user/pa168scn.html">PA168S</a>用户们早在2003年就指出了这个问题, 我们在随后的2004年PA168T设计上做了改进.
随着最近几天这个硬件高手指出和解决问题的过程深入, 我再一次回想起这个典型的用户驱动<a href="../palmmicro/20080326cn.php">Palmmicro</a>产品改进故事. 
</td></tr>
<tr><td><font color=gray>今年是1Q84年. 空气变了, 风景变了. 我必须尽快适应这个带着问号的世界. 像被放进陌生森林中的动物一样, 为了生存下去, 得尽快了解并顺应这里的规则. -- 1Q84</font></td></tr>
<tr><td><img src=../../../pa1688/user/at323/whitepcb_s.jpg alt="ATCOM IP PHONE AT323 internal PCB image" /></td></tr>
<tr><td>LM386是<b>ATCOM IP PHONE</b>字符串<b>E</b>上方的那个8脚芯片. <a href="../../../pa1688/user/at323/whitepcb.jpg" target=_blank>大图</a></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
