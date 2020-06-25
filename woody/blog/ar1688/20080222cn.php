<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>在AR1688软件中添加ISO 8859-2字库的具体步骤</title>
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
<tr><td class=THead><B>在AR1688软件中添加ISO 8859-2字库的具体步骤</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年2月22日</td></tr>
<tr><td>基于<a href="../../../ar1688/indexcn.html">AR1688</a> 0.28版本软件: 
<br />1. 下载字库<a href="20080216cn.php">文件</a>, 拷贝5x8.bdf, 7x14.bdf和MAPPINGS\8859-2.txt到SDCC\bin
<br />2. 运行命令行SDCC\bin\font.exe 5x8.bdf -t5. 产生array.txt文件
<br />3. 运行命令行SDCC\bin\font.exe 8859-2.txt -i. 产生font.txt, 这是给<a href="20070604cn.php">2x16</a> LCD扩展CGRAM显示用的5x8字库 
<br />4. 运行命令行SDCC\bin\font.exe 7x14.bdf -t7. 产生array.txt文件
<br />5. 再一次运行命令行SDCC\bin\font.exe 8859-2.txt -i. 产生font.txt, 这是给点阵显示用的8x16字库
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
