<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - 升级文件大小</title>
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
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
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>从PA1688到PA6488 - 升级文件大小</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年8月25日</td></tr>
<tr><td>绝大多数<a href="../../../pa1688/indexcn.html">PA1688</a>的升级文件固定在960k字节, 用我们私有的<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>做一次更新需要超过1分钟的时间. 
<br />所有<a href="../../../ar1688/indexcn.html">AR1688</a>的升级文件都是640k字节, 不同的硬件板升级速度有所不同, 总体来说用TFTP升级的时候, 大约需要10到20秒时间. 
<br />因为PA1688和AR1688的8位控制器都需要页面切换来实现超过64k字节的代码, 我们必需事先规划好程序存储器上每一块位置的用途, 所以它们的升级文件都是固定<a href="../ar1688/20060930cn.php">大小</a>的.  
<br />64位的<a href="../../../pa6488/indexcn.html">PA6488</a>就不同了, 它有32位统一线性地址空间. 这样我们可以采用非固定长度的<a href="20090816cn.php">升级文件</a>, 从不到64k字节到1280k字节都行, 升级的时候只需要写入真正用到的程序存储器地址. 现在的升级速度实在太快了, 我们正在努力让自己适应这种新情况! 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
