<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688 Z80 Memory Map</title>
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
<tr><td class=THead><B>AR1688 Z80 Memory Map</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Jul 6, 2008</td></tr>
<tr><td>Bill Gates retired a few days ago. On that day when I was playing with my 8-bit toy, I can not help to remember a programming joke about him. It was over 30 years ago, when he and the lucky Paul Allen were building BASIC on an 8-bit CPU, they were told that the memory size they could use had been increased from 4k bytes to 8k bytes. They were happy to know it and also worried about what to do with those extra spaces. 
<br />I am 30 years behind Bill Gates, 30 years later, I am still working on 8-bit CPU and worrying about memory spaces calculated in kilobytes.
<br />Z80 has 64k bytes memory space. We are using it in the following way:
<br />0x0000-0x1fff: <a href="../../../ar1688/index.html">AR1688</a> internal SRAM, used to run Z80 program
<br />0x2000-0x3fff: AR1688 internal SRAM, used as <a href="20080121.php">Z80</a> software global var and stack. Global var starts from the bottom and increase, stack starts from the top and decrease. So it is possible that the stack will over flow to wash away global var and make everything unpredictable
<br />0x4000-0x7fff: AR1688 internal SRAM, there are several parts sharing those address spaces. For example, the 96k bytes DSP memory is allocated into 6 parts for Z80 to access on those addresses. And there is an extra part of SRAM used as heap, which is, the memory managed by the malloc/free functions
<br />0x8000-0xffff: Address spaces for external <a href="20080624.php">program flash</a>, LCD, network chip <a href="20080615.php">RTL8019AS</a> and DM9003. Again 32k is not large enough for all those, so we have different 32k bytes "banks" to access different parts
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
