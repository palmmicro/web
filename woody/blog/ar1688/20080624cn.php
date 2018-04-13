<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>安全模式下的升级</title>
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
<tr><td class=THead><B>安全模式下的升级</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年6月24日</td></tr>
<tr><td>安全模式软件保存在程序存储器的第一个64k字节中(<a href="20070605cn.php">第0页</a>)。安全模式运行的时候，后32k字节的指令直接在程序存储器上运行，对应Z80地址空间0x8000-0xffff，头8k字节程序复制到<a href="../../../ar1688/indexcn.html">AR1688</a>内部SRAM中运行，对应Z80地址空间0x0000-0x3fff。
<br />有些软件只能在SRAM运行，例如写程序存储器的函数。
<br />用TFTP升级的时候，TFTP软件在程序存储器上运行，接收数据保存到DSP内存。收满64k字节后，我们会切换到SRAM上运行写程序存储器的函数，把这64k字节数据写到相应地址，然后切换回程序存储器继续运行TFTP协议。.
<br />在安全模式下，用户既可以升级主程序，也可以升级安全模式程序本身。 
<br />最近一个客户报告他在安全模式下升级安全模式程序的时候TFTP因超出等待时间失败。这其实是可以预料到的，在头64k程序存储器被新的数据写过以后，原来运行的老TFTP多半找不到原来切换回去的路了。不过不用担心，尽管PC方面报告错误，升级本身应该已经成功。
<br />为避免这种疑惑，建议尽可能只在主程序中升级安全模式程序。
<br />另外注意保护升级安全模式的时候千万不要断电。一旦安全模式被损坏，我们在软件上就无能为力了。
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
