<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>如何更新字库</title>
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
<tr><td class=THead><B>如何更新字库</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年6月5日</td></tr>
<tr><td>目前所有<a href="../../../ar1688/indexcn.html">AR1688</a>网络电话都使用2Mx8比特的程序存储器, 并且软件结构相同. 程序存储器被分成32个不同的64K空间, 称之为页. 例如, 第一个64k为安全模式所在的第0页. 话机设置和地址本在第二个64k空间为第1页. 
<br />第8页到第11页用于存储字库, 总共有256k字节. 刚好存放6000多个常用汉字的16x16点阵字库. 只有点阵显示的LCD需要使用点阵字库. 常见的2x16字符型LCD使用LCD控制器内部的字库. 
<br />一般来说字库不需要改动, 在第一次写程序存储器时写入就行了. 凡事都有特例, 如我在<a href="20070603cn.php">前面</a>提到的, 我们需要升级ISO 8859的字库显示法语和其他的西欧语言的特殊字符. 这样我们需要一个后门来升级字库, 步骤如下(在Windows命令行模式): 
<br />1. 进入C:\SDCC\src\res
<br />2. 输入命令"copy /b holdmusic.dat+font.dat holdmusic_font.dat"
<br />3. 使用升级通话保持音乐的命令, 输入"tftp -i xxx.xxx.xxx.xxx put holdmusic_font.dat"
<br />按照这种方式, 通话保持音乐和字库将都被src\res中的文件更新, 如果你不想使用缺省的通话保持音乐的话可以改回去. 
<br /><a href="20070328cn.php">通话保持音乐</a>存储在第5页到第7页. 目前的软件在TFTP模式升级时不检查文件的长度, 所以当字库文件附加在通话保持音乐文件后面时, 会继续更新字库. 
<br />&nbsp;
<br /><font color=magenta>2008年2月16日更新</font>
<br />从<a href="20080216cn.php">0.28</a>版本后不再需要单独升级ISO 8859字库. 
<br />&nbsp;
<br /><font color=magenta>2012年7月4日更新</font>
<br />从<a href="../../../ar1688/software/sw057cn.html">0.57</a>版本后字库可以直接用命令行"tftp -i xxx.xxx.xxx.xxx put font_xxxxxxxx.dat"更新.  
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
