<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>8051软件细节</title>
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
<tr><td class=THead><B>8051软件细节</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年3月30日</td></tr>
<tr><td>尽管基于<a href="../../../ar1688/modulecn.html">AR168M</a> VoIP<a href="20080225cn.php">模块</a>和外部8051<a href="20080329cn.php">用户界面</a>控制器的网络电话参考设计是为了演示目的, 
它其实也可以当成一个低成本网络电话用于实际生产. 其中采用的8051非常便宜, 下面是SDCC\mcs51下这些公开源代码的8051软件细节: 
<br />1. 用公开源代码的SDCC编译, 采用小模式
<br />2. 不能在板上软件升级, 必须外部编程器修改程序
<br />3. 外接2x16 LCD, 8x6键盘和4个LED
<br />4. 如果P4端口可以用的话, 用于4个额外的LED (我们用来测试的Winbond产品上有P4端口)
<br />5. 使用了141字节的data和idata (意味着我们实际需要一个标准的带256字节内部RAM的8052)
<br />6. 使用了2797字节代码空间, 包括给2x16 LCD使用的扩展<a href="20070603cn.php">ISO 8859-1</a>字库 (一个约0.5美元带4K ROM的8052足够)
<br />7. <a href="20071119cn.php">串口</a>配置为19200bps波特率, 8位数据, 1位停止位, 无奇偶校验位
<br />8. 晶振工作在22.1184MHz
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
