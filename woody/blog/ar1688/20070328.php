<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Ring Tone and Hold Music</title>
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
<tr><td class=THead><B>Ring Tone and Hold Music</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 28, 2007</td></tr>
<tr><td>After answering an email about PA1688 ring tone upgrade resulted in noise, I realized that it is time to explain the ring tone difference between PA1688 and <a href="../../../ar1688/index.html">AR1688</a>. The ring tone format for the 2 chips are different. Upgrade AR1688 ring tone to PA1688 devices will result in ring tone noise. Upgrade PA1688 ring tone to AR1688 devices, normally AR1688 will not accept it after a simple name check.
<br />The major confusion comes from web page download address. Users need to download PA1688 ring tones <a href="../../../pa1688/ring.html">here</a> and AR1688 ring tones <a href="../../../ar1688/ring.html">here</a>.
<br />Difference between PA1688 and AR1688 ring tones: 
<br />1. PA1688 uses G.723.1 and G.729 separately compressed music, combine together for a ring tone. AR1688 uses G.711 mu law format ring tone to avoid G.723.1 and G.729 codec license problem. AR1688 IP phones can work completely without G.723.1 and G.729 codec. And the G.711 format music ring tone has much better quality.
<br />2. AR1688 ring tone length can be as long as 24.48 seconds, longer than PA1688's 7.68 seconds. With longer time and less compressed format, obviously AR1688 uses much larger program flash space to store ring tones.  
<br />3. AR1688 uses another 192k bytes program flash space to store the same format and same 24.48 seconds length hold music. With different ring tone and hold music, AR1688 users are not likely to report typical PA1688 problem "I heard the ring tone after pressed hold key". Hold music file is the same as ring tone, except the file name itself. TFTP upgrade program checks the file name to decide which program flash section to upgrade. We have many efforts on AR1688 to improve the overall business phone experience, hold music is one of them.
<br />We learned the importance of self-defined ring tone from the mobile phone business, same as <a href="../../../pa1688/index.html">PA1688</a>, users can record and make their own ring tones, plus the new hold music, please check our development guide for details.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
