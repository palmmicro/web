<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>ISO 8859字库</title>
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
<tr><td class=THead><B>ISO 8859字库</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年6月3日</td></tr>
<tr><td>在上个世纪DOS时代，每一个程序员都尝试过在自己的程序中显示汉字。在我们开始设计点阵显示的<a href="../../../ar1688/user/gp1266cn.html">AR168G</a>网络电话后，我特别高兴14年前编写的程序可以再次派上用场。我发掘出来那些古老的c语言和汇编代码以及8x16 ASCII字库和16x16中文字库，马上用于显示程序中。
<br />半年过去了一切正常，直到Sebastien把所有<a href="../../../ar1688/indexcn.html">AR1688</a>的资源<a href="20070405cn.php">翻译</a>成法语后，我发现我的ASCII字库中0x80后的字符跟他用的法语字符对不上号。我不得不在目前的0.13版本软件中做了个法语特殊字符显示转换表。但是问题没有完，我接着发现了我的字库中并没有全部的法语特殊字符。这让我意识到我对于世界上除了中国和美国以外的其它地方的了解少得可怜。我开始找Windows下的法语编码标准，结果很简单，答案是<a href="http://czyborra.com/charsets/iso8859.html" target=_blank>ISO 8859</a>。
<br />目前0.13和0.14版本正在封闭测试中。我们只能把接下来的改动放在0.15和0.16版本中了。漫长的14年还不够教会我如何看世界，6个月前的仓促写程序看上去很傻。AR168G现有的法语和其它语言的客户只能等到0.16版本发布后才能更新字库显示特殊字符。
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
