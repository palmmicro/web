<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688 Z80地址空间</title>
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
<tr><td class=THead><B>AR1688 Z80地址空间</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年7月6日</td></tr>
<tr><td>Bill Gates前几天宣布退休的时候我正在玩自己的8位玩具, 当时马上想起一个他的编程笑话. 那是30年前吧, 他跟幸运的Paul Allen在一个8位CPU上写BASIC软件的时候, 突然被告知可以用的内存从4k字节增加到了8k字节, 他们还没来得及高兴就开始发愁多出来的内存该怎么使用了.  
<br />我比Bill Gates落后30年, 今天我依然还在8位CPU上写程序, 为几k字节的内存发愁. 
<br />Z80有64k字节地址空间, 我们使用方式如下: 
<br />0x0000-0x1fff: <a href="../../../ar1688/indexcn.html">AR1688</a>内部SRAM, 用于运行Z80程序
<br />0x2000-0x3fff: AR1688内部SRAM, 用于<a href="20080121cn.php">Z80</a>软件全局变量和栈. 全局变量地址从底部往上增加, 栈由顶往下减少. 有可能因为栈溢出到全局变量位置上导致程序跑飞
<br />0x4000-0x7fff: AR1688内部SRAM, 有几个部分一起共用这部分地址. 例如96k字节DSP内存在这里分成了6部分供Z80访问. 另外一部分用于malloc/free函数的SRAM也在这部分地址上
<br />0x8000-0xffff: 外部<a href="20080624cn.php">程序存储器</a>, LCD, 网络芯片如<a href="20080615cn.php">RTL8019AS</a>和DM9003使用的地址. 同样这32k地址也需要共用
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
