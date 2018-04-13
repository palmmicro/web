<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>不要升级"长"铃音</title>
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
<tr><td class=THead><B>不要升级"长"铃音</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年1月20日</td></tr>
<tr><td>今天的一个电子邮件报告<a href="../../../ar1688/user/gp1266cn.html">GP1260</a>电话在升级了一个"长"铃音之后显示错误。实际上问题的大多数相关部分都在我们的开发指南和我的网络日志中有答案。我在下面重复几点：
<br />1. AR1688<a href="20070328cn.php">铃音</a>存储在2、3、4页中，总共192k字节，关于它的格式和创建方法可以在我们的开发指南中找到。
<br />2. AR1688通话保持音乐存储在5、6、7页中，格式和铃音一样。
<br />3. 点阵显示的<a href="../../../ar1688/indexcn.html">AR1688</a>话机(AR168G/GP1260/GP1266/GP2266)所用的字库存储在8、9、10、11页中。
<br />4. 当使用TFTP升级铃音和通话保持音乐时，我们不检测文件长度。这是我们为升级点阵字库留的后门，因为没有专门的方法升级点阵字库。
<br />5. 一个大于192k字节的铃音会冲掉通话保持音乐。一个超过384k字节的铃音会覆盖字库并造成点阵显示错误。一个比640k还大的铃音会破坏程序空间(12-31页)，使话机不能正常启动。幸运的是在0页中的安全模式不会被覆盖，可以进入安全模式重新升级正确的文件。
<br />6. 恢复点阵字库的详细方法在<a href="20070605cn.php">这里</a>。
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
