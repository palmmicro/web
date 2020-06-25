<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>计算Speex实际使用带宽</title>
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
<tr><td class=THead><B>计算Speex实际使用带宽</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年10月31日</td></tr>
<tr><td>我们终于基本上完成了AR1688 <a href="20070216cn.php">DSP</a>上Speex的编码. 这个开放源代码的语音压缩算法比我们预料的要复杂很多. 在8k采样下它支持8种不同比特率, 从2.15kpbs到24.6kpbs. 因为有人问通话时这个算法实际占用多少带宽, 我就写了这篇文章. 
<br />基于802.3网络, SIP协议计算: 
<br />网络CRC: 4字节
<br />MAC包头: 14字节
<br />IP包头: 20字节
<br />UDP包头: 8字节
<br />RTP包头: 12字节
<br />Speex数据: x字节, x随使用的比特率以及一个网络包中放的语音帧数不同变化(见<a href="../../../ar1688/indexcn.html">AR1688</a>中"语音帧数"的选项)
<br />总数: (58 + x)字节
<br />根据网络包中放不同语音帧计算, 实际使用带宽如下表. 
</td></tr>
</table>

<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="table1">
       <tr>
        <td class=c1 width=270 align=center>比特率 (kbps)</td>
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
        <td class=c1 align="center">20ms语音帧 (字节)</td>
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
        <td class=c1 align="center">网络包中放1帧语音 (kbps)</td>
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
        <td class=c1 align="center">网络包中放2帧语音 (kbps)</td>
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
        <td class=c1 align="center">网络包中放3帧语音 (kbps)</td>
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
        <td class=c1 align="center">网络包中放4帧语音 (kbps)</td>
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
