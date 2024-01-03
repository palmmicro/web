<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>语音帧数</title>
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
<tr><td class=THead><B>语音帧数</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年11月14日</td></tr>
<tr><td>在<a href="../../../ar1688/indexcn.html">AR1688</a>设置选项中, "语音帧数"的范围是1到7. 这意味着用户可以指定1到7帧语音放在同一个发送网络包中. 没有对接收网络包中语音帧数的限制. 
<br />当我们计算<a href="20071031cn.php">Speex</a>实际使用带宽的时候, 我们只列举了1到4帧的情况. 这是因为对于20毫秒帧长的Speex算法我们最多只允许4帧语音放在一个发送网络包中. 对于iLBC算法30毫秒模式只允许3帧语音放在一个网络包中. 这是为了防范意料之外的延时. 
由于我们并不知道自动协商后到底用哪种算法, 如果选择了语音帧数7而不做限制, 用G.729的时候会带来70毫秒延时, 而用<a href="20070307cn.php">iLBC</a> 30毫秒模式则会带来210毫秒延时. 因此我们限制总共发送包的延时不超过90毫秒. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
