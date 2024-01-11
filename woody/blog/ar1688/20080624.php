<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Safe Mode Upgrade</title>
<?php EchoInsideHead(); ?>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>Safe Mode Upgrade</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Jun 24, 2008</td></tr>
<tr><td>Safe mode program is stored at the first 64k bytes (<a href="20070605.php">page0</a>) space on the program flash. When safe mode is running, the second 32k bytes instructions are running on program flash itself, using Z80 address space 0x8000-0xffff, while the first 8k bytes are copied to <a href="../../../ar1688/index.html">AR1688</a> internal SRAM and running there, using Z80 address space 0x0000-0x3fff.
<br />Some functions can only run on SRAM, for example, program flash writing routines.
<br />When running TFTP upgrade, TFTP program is running on flash, saving all received data into DSP memory, when it reaches 64k bytes, we will switch to run program flash writing routines in SRAM, and write the 64k bytes data to its proper address, and then switch back to run TFTP protocol on program flash.
<br />In safe mode, users can upgrade both main program and safe mode program itself. 
<br />A recent customer report says that TFTP timed out when upgrading safe mode program under safe mode. Actually this can be expected because after the first 64k flash space written, the old TFTP program lost its way. However, the upgrade process is usually successful, even the PC side shows the error.
<br />To avoid confusion, please always only upgrade safe mode program when main program is running.
<br />Make sure power supply is good when upgrade safe mode program. If safe mode is broken, we can do nothing about the device by software any more.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
