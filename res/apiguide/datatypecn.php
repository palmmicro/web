<?php require("../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro软件API开发指南 - 数据类型</title>
<meta name="description" content="介绍PA3288方案和PA6488方案公用的Palmmicro软件API中基本的数据类型和命名规则, UCHAR, USHORT, UINT, BOOLEAN等.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../js/filetype.js"></script>
<script src="../../js/copyright.js"></script>
<script src="../../js/nav.js"></script>
<script src="../../palmmicro.js"></script>
<script src="apiguide.js"></script>
<script src="../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateApiGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>
	
	
<table>
<tr><td class=THead><B>Palmmicro软件API开发指南 - 数据类型</B></td></tr>
<tr><td>&nbsp;
<br /><font color=grey>命名规则</font>
<br />8位<font color=olive>UCHAR</font>和<font color=olive>char</font>用c开头, 例如: tcpip\<b>arp.c</b>中<font color=olive>UCHAR</font> cHardwareLen;
<br />16位<font color=olive>USHORT</font>和<font color=olive>short</font>用s开头, 例如: tcpip\<b>ip.c</b>中<font color=olive>USHORT</font> sCheckSum;
<br />32位<font color=olive>UINT</font>和<font color=olive>int</font>用i开头, 例如: tcpip\<b>icmp.c</b>中<font color=olive>UINT</font> iMustBeZero;
<br /><font color=olive>BOOLEAN</font>用b开头, 例如: tcpip\<b>tcpsm.c</b>中<font color=olive>BOOLEAN</font> bFinAcked;
<br />指针前加p, 例如: <font color=olive>UCHAR</font> pcDst[HW_ALEN]; <font color=olive>char</font> * pcBuf;
<br />2维指针前加pp.
<br />32位内存映射寄存器用r开头, 例如: <font color=olive>REG</font> rStall; <font color=olive>PREG</font> prCtl;
<br />8位内存映射寄存器用rc开头, 例如: <font color=olive>REG8</font> rc;
<br />一般结构T_XXXX_XXXX用t开头, 例如: <font color=olive>PT_UDP_SOCKET</font> ptNext;
<br />一般联合U_XXXX_XXXX用u开头.
<br />PT_XXXX_XXXX和PU_XXXX_XXXX定义结构和联合的指针.
<br />函数指针F_XXXX_XXXX用f开头, 例如: <font color=olive>F_TIMER_IRQ</font> fCallBack;
<br />常量用c_开头, 例如: const <font color=olive>char</font> c_pcLoop[] = "LOOP"; 函数参数中的const不加c_.
<br />非常量的全局变量用g_开头, 例如: <font color=olive>UINT</font> g_iCurrentTime;
<br />仅在模块内使用的数据用_开头, 例如: <font color=olive>BOOLEAN</font> _bTimer;
<br />&nbsp;
<br /><font color=grey>相关信息</font>
<br />PA3288的<a href="../../pa3288/software/devguide/datastructurecn.php">数据结构</a>.
<br />PA6488的<a href="../../pa6488/software/devguide/datastructurecn.html">数据结构</a>.
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
