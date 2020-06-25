<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>8051 Software Details</title>
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
<tr><td class=THead><B>8051 Software Details</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 30, 2008</td></tr>
<tr><td>Although the IP phone reference design based on <a href="../../../ar1688/module.html">AR168M</a> VoIP <a href="20080225.php">module</a> and an external 8051 <a href="20080329.php">UI</a> controller is for demo purpose, 
it actually can be used in real production and still maintain a very low BOM cost, because the 8051 we used is also very cost effective. Here is some details of the open source software in SDCC\mcs51.
<br />1. Compile with open source SDCC compiler, using small memory mode
<br />2. Can NOT be upgraded by software on board, need a programmer to make change if needed
<br />3. Interface with 2x16 LCD, 8x6 keys and 4 LEDs
<br />4. Extra 4 LEDs if P4 port is available (on those Winbond devices we are testing)
<br />5. Used 141 bytes of data and idata (means that we actually need a standard 8052 which has 256 bytes internal RAM)
<br />6. Used 2797 bytes of code space, including extended <a href="20070603.php">ISO 8859-1</a> font for 2x16 LCD (a 4K ROM 8052 is enough, cost about 0.5 USD)
<br />7. <a href="20071119.php">UART</a> at 19200bps, 8 bit data, 1 stop, no parity check
<br />8. Oscillator at 22.1184MHz
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
