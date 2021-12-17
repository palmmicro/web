<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA3288开发指南 - USB软件</title>
<meta name="description" content="Palmmicro PA3288芯片内部集成USB 2.0 OTG控制器的相关软件开发指南. 使用的ETSL和USB驱动软件的移植说明.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa3288.js"></script>
<script src="../software.js"></script>
<script src="devguide.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateDevGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>
	
	
<table>
<tr><td class=THead><B>PA3288开发指南 - USB软件</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=gray>概览</font>
<br />PA3288内部集成USB 2.0 OTG控制器.  
<br />&nbsp;
<br /><font color=gray>USB主设备</font>
<br />&nbsp;
<br /><font color=gray>USB从设备</font>
<br /><a href="../../../woody/blog/pa6488/20090927cn.php">安全模式</a>软件通过在<font color=indigo>include\</font><b>version.h</b>中定义<i><b>CALL_NONE</b></i>编译. 在安全模式下缺省支持USB海量存储设备软件. 当它连接到例如PC这样的USB主设备上时, PC上会看到一个标准的FAT16移动硬盘.   
<br />FAT16软件在<font color=indigo>fat\</font>下, 来自开放源代码的<a href="../../../pa6488/software/devguide/filesystemcn.html">EFSL</a> 0.2.8. 我们为了减少代码量, 从中删除了对FAT12和FAT32的支持.  
<br />原始的<a href="../../../woody/blog/pa3288/20130831cn.php">USB</a>海量存储设备类软件来自<font color=indigo>KeilARM\ARM\Boards\Keil\MCB2140\USBMem\</font>. 我们用PA3288 <a href="cslcn.php">csl</a>函数取代了Philips LPC2148寄存器级别的操作, 同时用FAT16文件系统取代了原来的演示盘数据. 这些软件在<font color=indigo>usbmem\</font>中. 
<br />&nbsp;
</td></tr>
</table>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
