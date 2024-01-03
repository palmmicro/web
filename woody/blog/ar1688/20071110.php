<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Speex Bandwidth Usage with IAX2 Protocol</title>
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
<tr><td class=THead><B>Speex Bandwidth Usage with IAX2 Protocol</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 10, 2007</td></tr>
<tr><td>SIP was planned as a simple VoIP protocol when <a href="20060929.php">H.323</a> was popular years ago. However it is not simple at all today. IAX2 is the native protocol of Asterisk system. It is a true simple VoIP protocol. We used only 19k bytes binary code for IAX2 protocol with <a href="../../../ar1688/index.html">AR1688</a> software, and used 44k bytes on SIP.
<br />IAX2 also uses less bandwidth than SIP when using the same codec. It does not use RTP protocol for voice data. Most voice data was packaged in "Mini Frame", which has only 4 bytes head, less than the 12 bytes header of RTP.
<br />Following the same way we calculated with <a href="20071031.php">SIP</a>, the total number in an IAX2 and Speex ethernet packet is (50 + x) bytes. When 2 frames (40ms) of Speex data is packed in one ethernet frame, the actual bandwidth usage with different bitrate are in the table below.
<br />(50 + 2x) / 5 is coming from: 8kbps * ((50 + 2x) / 2x) * (x / 20). 8kbps is the bitrate same as 20 bytes in every 20 miliseconds.
</td></tr>
</table>

<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="table1">
       <tr>
        <td class=c1 width=270 align=center>Bitrate (kbps)</td>
        <td class=c1 width=40 align=center>2.15</td>
        <td class=c1 width=40 align=center>3.95</td>
        <td class=c1 width=40 align=center>5.95</td>
        <td class=c1 width=40 align=center>8</td>
        <td class=c1 width=40 align=center>11</td>
        <td class=c1 width=40 align=center>15</td>
        <td class=c1 width=40 align=center>18.2</td>
        <td class=c1 width=40 align=center>24.6</td>
      </tr>
      <tr>
        <td class=c1 align="center">20ms frame (x byte)</td>
        <td class=c1 align="center">6</td>
        <td class=c1 align="center">10</td>
        <td class=c1 align="center">15</td>
        <td class=c1 align="center">20</td>
        <td class=c1 align="center">28</td>
        <td class=c1 align="center">38</td>
        <td class=c1 align="center">46</td>
        <td class=c1 align="center">62</td>
      </tr>
      <tr>
        <td class=c1 align="center">SIP (58 + 2x) / 5 (kbps)</td>
        <td class=c1 align="center">14</td>
        <td class=c1 align="center">15.6</td>
        <td class=c1 align="center">17.6</td>
        <td class=c1 align="center">19.6</td>
        <td class=c1 align="center">22.8</td>
        <td class=c1 align="center">26.8</td>
        <td class=c1 align="center">30</td>
        <td class=c1 align="center">36.4</td>
      </tr>
      <tr>
        <td class=c1 align="center">IAX2 (50 + 2x) / 5 (kbps)</td>
        <td class=c1 align="center">12.4</td>
        <td class=c1 align="center">14</td>
        <td class=c1 align="center">16</td>
        <td class=c1 align="center">18</td>
        <td class=c1 align="center">21.2</td>
        <td class=c1 align="center">25.2</td>
        <td class=c1 align="center">28.4</td>
        <td class=c1 align="center">34.8</td>
      </tr>
</TABLE>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
