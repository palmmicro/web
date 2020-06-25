<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>缺省设置</title>
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
<tr><td class=THead><B>缺省设置</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年7月16日</td></tr>
<tr><td><a href="../../../ar1688/indexcn.html">AR1688</a>设备的设置保存在程序存储器地址空间0x10000-0x13fff, 出厂缺省设置保存在地址空间0x14000-0x17fff. 可以在软件API文件SDCC\include\ar168.h中看到具体设置的位置. SDCC\src\settings下的.txt文件是生产厂商和OEM用来产生出厂缺省设置的, 修改这些文件不会改变升级文件. 事实上应该避免通过升级软件来修改设置和缺省设置. 
<br />很多Asterisk系统集成商希望在网络电话中保存自己的缺省设置. 最好的方法是在话机出厂前提供给我们.txt设置文件样本, 我们可以帮助在话机生产时就带有这些设置. 对于现有的网络电话, 可以用下面3种方式改变缺省设置: 
<br />1. 在<a href="20080624cn.php">安全模式</a>下, 用#5*1可以保存当前设置为缺省设置. 详情见SDCC\doc\key_test.txt
<br />2. 在普通模式下, 用菜单->话机设置->保存缺省设置把当前设置保存为缺省设置
<br />3. 对程序员来说可以用<a href="20061211cn.php">API</a>函数UI_StoreDefaults()和UI_LoadDefaults()保存当前设置为缺省设置
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
