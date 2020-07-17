<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>GPIO Control</title>
<meta name="description" content="GPIO control source code description for Palmmicro AR1688 software API. Keep in mind that software changes more frequently than blog.">
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
<tr><td class=THead><B>GPIO Control</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Sep 3, 2008</td></tr>
<tr><td>In standard <a href="../../../ar1688/index.html">AR1688</a> IP phone hardware reference design, all GPIO are used as key and LED. We only provided high level key and LED control functions in API before software version 0.37.
<br />To our surprise, a new manufacturer does not need those GPIO output LED but needs to use several GPIO as input. To make API simple and reduce code size, we decided to put GPIO control as source code with the release of 0.38 software.
<br />In current <a href="20061211.php">API</a>, SDCC\inc\gpio_sfr.h is added, and control example code can be found in SDCC\src\led.c, function.c.
<br />&nbsp;
<br /><font color=magenta>Updated on Sep 15, 2008</font>
<br />We are providing more source code examples on GPIO control along with current 0.39 and 0.40 software development. In SDCC\src directory, <B>isr_gpio.c</B> is added for 5x6 and 7x8 keypad designs, and <B>slic.c</B> is added for AM79R70 SLIC control.
<br />5x6 keypad is used in AR168K and AR168KD IP phone reference designs, both designs are at sampling stage by different manufacturers.
<br />7x8 keypad is used in AR168J.
<br />AM79R70 is used in AR168L and AR168LS 1-port FXS gateway reference designs, which are not ready with software yet.
<br />&nbsp;
<br /><font color=magenta>Updated on Feb 19, 2013</font>
<br /><a href="../../../ar1688/software/sw060.html">0.60</a> software removed unmature ATA/Gateway hardware type VER_AR168L/VER_AR168LS and related SLIC code <b>slic.c</b>.
<br /><b>gpio_sfr.h</b> removed in <a href="../../../ar1688/software/sw061.html">0.61.002</a>, use <b>sfr.h</b> instead.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
