<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Logic Puzzle: Find the Differences ...</title>
<meta name="description" content="Compare Palmmicro AR1688 solution based standard AR168R RoIP module and special version for REMOTA TECNOLOGIA.">
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
<tr><td class=THead><B>Logic Puzzle: Find the Differences ...</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 11, 2012</td></tr>
<tr><td>Last month a customer in Denmark complained that the <a href="../../../ar1688/roip.html">AR168R</a> board he received was incomplete,
and he attached the photo showing that the RS232 driver and DB9 connector were missing.
<br />What he received was actually our standard board for Radio over IP application, but the picture in AR168R web page was misleading, as we had put the image of the special board for REMOTA TECNOLOGIA on it.  
<br />After we exchanged more emails, more misleading and confusing details about AR168R were revealed. As we have poor documentation about it,
I am collecting them here as a reminder to avoid the puzzles for future customers and myself as well.
<br />1) Our standard AR168R software will not work if <a href="20070604.php">LCD</a> is absent.
To use AR168R without LCD, the software must be compiled with <b><i>LCD_HY1602</b></i> undefined in #ifdef <b><i>VER_AR168R</b></i> section in sdcc\include\<b>version.h</b>. 
<br />2) The standard AR168R software has not included <a href="20071119.php">UART</a> function. To use UART function, the software must be compiled with option <b><i>OEM_UART</b></i>,
as in command line <font color=gray>mk ar168r sip us uart</font>. No extra compiler installation is needed, the <a href="20101123.php">SDCC</a> compiler is included in the software API package, in sdcc\bin directory.  
<br />3) In our demo UART <a href="20080329.php">protocols</a>, all strings must be ended with '\0'(ascii 0x00) like in C programming.
Otherwise AR1688 will not be able to handle the command sent to it, and may output debug message like <a href="../../../ar1688/faq.html#module">UART data lost</a> in sdcc\bin\<b>manager.exe</b> debug window. 
<br />4) In the demo protocols, <font color=gray>KEY Z</font> is for hook down indication to AR1688, and <font color=gray>KEY z</font> for hook up.
<br />Since <a href="../../../ar1688/module.html">AR168M</a> VoIP module went <a href="20100625.php">out of stock</a> in 2010,
we have developed various <a href="20111205.php">unusual ways</a> for people to test the module functions.
Fortunately the puzzle may end in the near future, as we may receive an order of 100pcs AR168M soon.
We will prepare more boards for other future customers at the time of manufacturing, and end the annoying practice of <font color=gray>using AR168R as AR168M</font>.   
</td></tr>
<tr><td><a href="../photo/large/20121111.jpg" target=_blank>Large</a></td></tr>
<tr><td><img src=../photo/20121111.jpg alt="Standard AR168R RoIP module photo by an user from Denmark." /></td></tr>
<tr><td><img src=../../../ar1688/roip/ar168r_s.jpg alt="Special AR168R RoIP module for REMOTA TECNOLOGIA in Brazil." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
