<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA3288开发指南 - 芯片支持库csl</title>
<meta name="keywords" content="PA3288芯片支持库csl">
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
<tr><td class=THead><B>PA3288开发指南 - 芯片支持库csl</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><font color=grey>概览</font>
<br />&nbsp;
<br /><font color=grey>GPIO</font>
<br />&nbsp;
<br /><font color=grey>PLL</font>
<br />所有CSL函数中的时钟频率参数都是以Mhz为单位。通常在系统启动时调用一次<i>PLL_Init</i>。第一个参数设置系统PLL时钟，例如384表示384000000Hz。第二个BOOLEAN参数选择CPU速度。在典型情况下，当PLL时钟为384Mhz时，当bCPU2X为FALSE时CPU速度是96Mhz， 当bCPU2X为TRUE时CPU速度是192Mhz。
<br />&nbsp;
<br /><font color=grey>SPI</font>
<br />通常在系统启动时调用一次<i>SPI_Init</i>。头一个参数设置SPI的工作频率(Mhz)。带另外一个函数指针参数，用于<i>SPI_AsyncWrite</i>回调。
<br /><i>SPI_AsyncWrite</i>可以不需要CPU等待，利用DMA写数据，所有DMA结束后会调用回调函数。
<br />虽然我们支持多个SPI设备，但是只支持单个SPI设备用DMA写数据。所有其它SPI操作都需要在CPU等待方式下完成。基本的函数是<i>SPI_EnableClock</i>、<i>SPI_DisableClock</i>、<i>SPI_SyncWrite</i>、<i>SPI_SyncRead</i>和<i>SPI_SyncReadWrite</i>。
<br /><i>SPI_BulkWrite</i>和<i>SPI_BulkReadWrite</i>提供一个简单的SPI接口。例如<i>SPI_BulkWrite</i>只是简单的依次调用了<i>SPI_EnableClock</i>、<i>SPI_SyncWrite</i>和<i>SPI_DisableClock</i>。 
<br /><i>SPI_Write</i>和<i>SPI_ReadWrite</i>通过调用<i>SPI_BulkWrite</i>和<i>SPI_BulkReadWrite</i>，为数据长度不超过4字节的操作提供了更加简单的接口。
<br /><font color=indigo>bsl\</font><b>flash.c</b>中有最完整的各种SPI函数调用的例子．
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
