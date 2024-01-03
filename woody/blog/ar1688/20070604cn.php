<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>2x16字符型LCD中的字库</title>
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
<tr><td class=THead><B>2x16字符型LCD中的字库</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年6月4日</td></tr>
<tr><td>大部分<a href="../../../ar1688/indexcn.html">AR1688</a>网络电话都使用量大便宜的2x16字符型LCD. 其中通常是5x8的字库, 从0x20到0x7f是标准ASCII字符.  
<br />读了一下我计算机中3种不同LCD的资料, 发现都不兼容<a href="20070603cn.php">ISO 8859</a>定义的0x80后的字符. 然后写了个程序显示我手边AR1688和<a href="../../../pa1688/indexcn.html">PA1688</a>网络电话LCD中实际的字库, 让我惊讶的是, 0x80后基本上都是日文字符. 开始在想为什么我们对日本人这么友好, 或者为什么日本对中国这么重要. 后来想明白了, 是日本人先设计了这些2x16字符型LCD控制器芯片, 而我们一直在兼容它! 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
