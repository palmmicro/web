<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Speex Actual Bandwidth Calculation</title>
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
<tr><td class=THead><B>Speex Actual Bandwidth Calculation</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Oct 31, 2007</td></tr>
<tr><td>We have finally almost finished Speex coding on AR1688 <a href="20070216.php">DSP</a>. This open source voice codec turned out to be much more complicated than we expected. There are 8 different bitrate with 8k sampling, from 2.15kpbs to 24.6kpbs. I am writing this article to answer a question of how much bandwidth this codec actually use during a call.
<br />Let us calculate based on 802.3 ethernet, using SIP protocol:
<br />Ethernet CRC: 4 bytes
<br />MAC header: 14 bytes
<br />IP header: 20 bytes
<br />UDP header: 8 bytes
<br />RTP header: 12 bytes
<br />Speex data: x bytes, x depends on bitrate used and number of frames packed in an ethernet packet ("Frames per TX" option in <a href="../../../ar1688/index.html">AR1688</a>)
<br />Total: (58 + x) bytes
<br />When different frames are included in an ethernet frame, the actually used bandwidth are:
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
        <td class=c1 align="center">20ms frame (byte)</td>
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
        <td class=c1 align="center">1 frame in ethernet packet (kbps)</td>
        <td class=c1 align="center">25.6</td>
        <td class=c1 align="center">27.2</td>
        <td class=c1 align="center">29.2</td>
        <td class=c1 align="center">31.2</td>
        <td class=c1 align="center">34.4</td>
        <td class=c1 align="center">38.4</td>
        <td class=c1 align="center">41.6</td>
        <td class=c1 align="center">48</td>
      </tr>
      <tr>
        <td class=c1 align="center">2 frames in ethernet packet (kbps)</td>
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
        <td class=c1 align="center">3 frames in ethernet packet (kbps)</td>
        <td class=c1 align="center">10.1</td>
        <td class=c1 align="center">11.7</td>
        <td class=c1 align="center">13.7</td>
        <td class=c1 align="center">15.7</td>
        <td class=c1 align="center">18.9</td>
        <td class=c1 align="center">22.9</td>
        <td class=c1 align="center">26.1</td>
        <td class=c1 align="center">32.5</td>
      </tr>
      <tr>
        <td class=c1 align="center">4 frames in ethernet packet (kbps)</td>
        <td class=c1 align="center">8.2</td>
        <td class=c1 align="center">9.8</td>
        <td class=c1 align="center">11.8</td>
        <td class=c1 align="center">13.8</td>
        <td class=c1 align="center">17</td>
        <td class=c1 align="center">21</td>
        <td class=c1 align="center">24.2</td>
        <td class=c1 align="center">30.6</td>
      </tr>
</TABLE>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
