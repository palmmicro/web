<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA3288 Developer's Guide - USB Software</title>
<meta name="description" content="PA3288 USB Software">
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
<tr><td class=THead><B>PA3288 Developer's Guide - USB Software</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=gray>Overview</font>
<br />PA3288 has built in USB 2.0 OTG controller. 
<br />&nbsp;
<br /><font color=gray>USB Host</font>
<br />&nbsp;
<br /><font color=gray>USB Slave</font>
<br /><a href="../../../woody/blog/pa6488/20090927.php">Safe mode</a> software is compiled when <i><b>CALL_NONE</b></i> is defined in <font color=indigo>include\</font><b>version.h</b>.
USB mass storage device software is included in safe mode software by default. A standard FAT16 disk will appear when it connects to an USB host, for example a PC.  
<br />FAT16 software located in <font color=indigo>fat\</font> comes from open source <a href="../../../pa6488/software/devguide/filesystem.html">EFSL</a> 0.2.8, we removed FAT12 and FAT32 support for smaller code size. 
<br />Original <a href="../../../woody/blog/pa3288/20130831.php">USB</a> mass storage class software comes from <font color=indigo>KeilARM\ARM\Boards\Keil\MCB2140\USBMem\</font>. 
We replaced Philips LPC2148 register level operations with PA3288 <a href="csl.php">csl</a> functions, and changed the demo disk data to our FAT16 system.
Those software is located in <font color=indigo>usbmem\</font>.
<br />&nbsp;
</td></tr>
</table>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
