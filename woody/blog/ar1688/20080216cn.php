<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>字库资源</title>
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
<tr><td class=THead><B>字库资源</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年2月16日</td></tr>
<tr><td>在最近加入<a href="20070405cn.php#20080213">土耳其语</a>支持前, 我们一直在用ISO 8859-1 8x16 ASCII<a href="20070603cn.php">字库</a>和GB2312 16x16中文字库. <a href="../../../ar1688/indexcn.html">AR1688</a>土耳其语软件给我们带了一些好问题. 例如如何处理ISO 8859-9土耳其语的6个特殊字符? 其它语言需要其它ISO 8859字库怎么办? 到哪里找这些常见<a href="20070604cn.php">2x16</a>字符型LCD中使用的自定义5x8 CGRAM字库数据? 
<br />答案当然来自于最近CGX图片无处不在的互联网. 我找到了Markus Kuhn的<a href="http://www.cl.cam.ac.uk/~mgk25/ucs-fonts.html" target=_blank>页面</a>, 下载了X11下的各种Unicode字库, 为2x16 LCD转换了5x8字库, 为点阵显示转换了7x14字库. 
<br />为避免用户每次改语言版本时候都要<a href="20070605cn.php">升级字库</a>, 我们增加了文件SDCC\src\font.c存放ISO 8859字库数据, 跟升级文件链接在一起. 这样法语或者英语版本中会有ISO 8859-1字库, 而土耳其语升级文件中会带有ISO 8859-9字库. 
<br />目前为止只有一个我们不喜欢的地方, X11字库中使用小'+'代表'.', 让点阵显示看上去比较奇怪. 
<br />在此工作过程中, 我还发现了一个非常好的<a href="http://www.cs.tut.fi/~jkorpela/iso8859/" target=_blank>ISO 8859</a>信息页面. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
