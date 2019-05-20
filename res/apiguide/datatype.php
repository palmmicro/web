<?php require("../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro Software API Guide - Data Type</title>
<meta name="description" content="Introducce the common basic data type and name rules of Palmmicro software API used in PA3288 and PA6488.">
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
<tr><td class=THead><B>Palmmicro Software API Guide - Data Type</B></td></tr>
<tr><td>&nbsp;
<br /><font color=grey>Name Rules</font>
<br />8-bit <font color=olive>UCHAR</font> and <font color=olive>char</font> begin with c, example: tcpip\<b>arp.c</b> <font color=olive>UCHAR</font> cHardwareLen;
<br />16-bit <font color=olive>USHORT</font> and <font color=olive>short</font> begin with s, example: tcpip\<b>ip.c</b> <font color=olive>USHORT</font> sCheckSum;
<br />32-bit <font color=olive>UINT</font> and <font color=olive>int</font> begin with i, example: tcpip\<b>icmp.c</b> <font color=olive>UINT</font> iMustBeZero;
<br /><font color=olive>BOOLEAN</font> begins with b, example: tcpip\<b>tcpsm.c</b> <font color=olive>BOOLEAN</font> bFinAcked;
<br />Add p to pointers, example: <font color=olive>UCHAR</font> pcDst[HW_ALEN]; <font color=olive>char</font> * pcBuf;
<br />Add pp to 2-dimension pointers.
<br />32-bit memory mapped registers begin with r, example: <font color=olive>REG</font> rStall; <font color=olive>PREG</font> prCtl;
<br />8-bit memory mapped registers begin with rc, example: <font color=olive>REG8</font> rc;
<br />General struct T_XXXX_XXXX begins with t, example: <font color=olive>PT_UDP_SOCKET</font> ptNext;
<br />General union U_XXXX_XXXX begins with u.
<br />PT_XXXX_XXXX and PU_XXXX_XXXX define point to struct and union.
<br />Function pointer F_XXXX_XXXX begins with f, example: <font color=olive>F_TIMER_IRQ</font> fCallBack;
<br />Const data begins with c_, example: const <font color=olive>char</font> c_pcLoop[] = "LOOP"; const parameter in a function does not add c_.
<br />None const global data begins with g_, example: <font color=olive>UINT</font> g_iCurrentTime;
<br />Data only used within the source file begins with _, example: <font color=olive>BOOLEAN</font> _bTimer;
<br />&nbsp;
<br /><font color=grey>Related Information</font>
<br /><a href="../../pa3288/software/devguide/datastructure.php">Data structure</a> of PA3288.
<br /><a href="../../pa6488/software/devguide/datastructure.html">Data structure</a> of PA6488.
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
