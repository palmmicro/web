<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR168M VoIP Module without UART Functions</title>
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
<tr><td class=THead><B>AR168M VoIP Module without UART Functions</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Feb 13, 2012</td></tr>
<tr><td>After building their own <a href="../../../ar1688/module.html">AR168M</a> hardware and testing carefully with <a href="20110403.php">Asterisk</a>, a customer pointed out that the <a href="20090416.php">G.729B</a> voice would sometimes get lost completely after exchange of registration message during a call.
<br />This was something new for us. Then we found that they were building RoIP (Radio over IP) functions with AR168M, but without using any external controller for <a href="20071119.php">UART</a> communications. After disable UART function on their hardware, problem solved.
<br />It is funny that 2 months ago we were adding UART <a href="20111205.php">test functions</a> on IP phones, and now we have to remove UART from AR168M module, which was designed specially for UART control by other controllers which need simple VoIP support..
<br />To generally support AR168M without UART for all users, we added compile option OEM_ROIP since 0.57.001 API on AR1688 <a href="../../../ar1688/software/sw057.html">0.57</a> test software page. Command line "mk ar168m sip us roip" will generate AR168M software without UART functions.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
