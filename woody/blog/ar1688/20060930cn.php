<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>软件升级大小</title>
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
<tr><td class=THead><B>软件升级大小</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2006年9月30日</td></tr>
<tr><td>显然软件升级文件越小, <a href="20060929cn.php">升级</a>过程就会越快. 典型的PA1688话机例如<a href="../../../pa1688/user/pa168scn.html">PA168S</a>/T的升级文件大小为960k字节, 而AR1688的升级文件只有640k字节. 文件的减小主要来源于3个部分: 
<br />1. SDCC实际上不支持代码页面切换, 为了写大于64k的代码, 我们不得不进行手工页面切换, 具体安排不同页面间函数的相互调用. <a href="../../../pa1688/indexcn.html">PA1688</a>使用Keil C51编译器, 自动代码页面切换编译的结果让我们安排了50％的代码空间作为公用代码. 而AR1688使用SDCC编译器, 只使用了25％的代码空间作为公用代码. 
<br />2. DSP代码的存储结构得到改善. 因为启动时间慢, 压缩PA1688上DSP代码导致了很糟糕用户体验. 现在我们不再压缩<a href="../../../ar1688/indexcn.html">AR1688</a>的DSP代码, 保证可以立刻启动. 在AR1688中我们把例如LPC计算等公共DSP程序集中在一起减小代码空间, 这比压缩的效率高多了. 
<br />3. 因为PA1688上无LCD的网络电话和单口FXS网关的存在, 我们使用IVR提示终端用户必要的设备信息. 在AR1688中, 我们要求至少都有2x16的LCD, 而且不打算设计网关, 这样我们不再需要IVR功能, 相应的减小了文件大小. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
