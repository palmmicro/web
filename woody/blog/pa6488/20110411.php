<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - UART Function in Product Evolution</title>
<meta name="description" content="The review of UART used in Palmmicro solutions including PA1688, AR1688 and PA6488. With the story of how we started VoIP module business.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
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
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>From PA1688 to PA6488 - UART Function in Product Evolution</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 11, 2011</td></tr>
<tr><td>Although today there are still UART options in <a href="../../../pa1688/software/palmtool.html">PalmTool</a>, we only used PA1688 UART in very early debug stage.
We refused to use UART for <a href="20100109.php">configuration</a> based on cost. We are always ready to save extra parts for the simplest BOM, among them were the MAX232 chip to do voltage convert to match PC UART,
and the <a href="../ar1688/20080615.php">93C46</a> chip to work with RTL8019AS.
<br />In late 2007, two different customers found AR1688 UART pins used as <a href="../ar1688/20080903.php">GPIO</a> for keys from our hardware schematics,
and suggested to use <a href="../ar1688/20071119.php">UART</a> as a control interface for <a href="../../../ar1688/module.html">AR168M</a> VoIP module almost at the same time.
Since that time our module solution business began, and in 2010 it had become the major part in our AR1688 sales.
<br />Because of the small success with VoIP module, we are designing the first <a href="../../../pa6488/index.html">PA6488</a> solution based product <a href="20090819.php">PA648C</a> as module controlled by UART too.
And we are also still using the same <a href="../ar1688/20080329.php">high level UI protocols</a>, so we can use the same <a href="../ar1688/20080330.php">8051</a> demo hardware and software.
</td></tr>
<tr><td><img src=../photo/20111127.jpg alt="PA6488 and X-Lite fish demo via WiFi Ethernet bridge" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>

