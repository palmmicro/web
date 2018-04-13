<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA3288 Developer's Guide - Chip Support Libary</title>
<meta name="keywords" content="PA3288 Chip Support Libary">
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
<tr><td class=THead><B>PA3288 Developer's Guide - Chip Support Libary</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=grey>Overview</font>
<br />&nbsp;
<br /><font color=grey>GPIO</font>
<br />&nbsp;
<br /><font color=grey>PLL</font>
<br />All clock frequency parameters in CSL functions are in Mhz. Usually <i>PLL_Init</i> is called once at system start up time. 
The first parameter sets the system PLL clock, for example, 384 means 384000000Hz.
The second BOOLEAN parameter selects the CPU speed. In a typical case, when PLL clock is 384Mhz, CPU speed is 96Mhz when bCPU2X is FALSE, and 192Mhz when bCPU2X is TRUE.
<br />&nbsp;
<br /><font color=grey>SPI</font>
<br />Usually <i>SPI_Init</i> is called once at system start up time, with a SPI working clock (in Mhz) parameter and a function pointer parameter as the call back function for <i>SPI_AsyncWrite</i>.
<br /><i>SPI_AsyncWrite</i> writes data using DMA without CPU waiting, the call back function will be called after all DMA operations finished.
<br />Although we support multiple SPI devices, we only support one SPI device for DMA write only. All other SPI operations need to be done in CPU waiting mode.
The basic functions are <i>SPI_EnableClock</i>, <i>SPI_DisableClock</i>, <i>SPI_SyncWrite</i>, <i>SPI_SyncRead</i> and <i>SPI_SyncReadWrite</i>.
<br /><i>SPI_BulkWrite</i> and <i>SPI_BulkReadWrite</i> provide a simple SPI interface. For example, <i>SPI_BulkWrite</i> simply calls <i>SPI_EnableClock</i>, <i>SPI_SyncWrite</i> and <i>SPI_DisableClock</i> one by one. 
<br /><i>SPI_Write</i> and <i>SPI_ReadWrite</i> provide a more simple interface for data length within 4 bytes by direct function call of <i>SPI_BulkWrite</i> and <i>SPI_BulkReadWrite</i>.
<br /><font color=indigo>bsl\</font><b>flash.c</b> has the most complete examples of all kinds of SPI function calls.
<br />&nbsp;
<br /><font color=grey>TIMER</font>
<br />&nbsp;
<br /><font color=grey>USB</font>
<br />&nbsp;
</td></tr>
</table>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
