<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>IAX2协议下Speex实际使用带宽</title>
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
<tr><td class=THead><B>IAX2协议下Speex实际使用带宽</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年11月10日</td></tr>
<tr><td>几年前<a href="20060929cn.php">H.323</a>还流行的时候, SIP是作为一个简单的VoIP协议出现的. 到今天它已经一点都不简单了. 真正简单的VoIP协议是Asterisk系统自带的IAX2. 在我们<a href="../../../ar1688/indexcn.html">AR1688</a>软件中, IAX2二进制代码只有19k字节, 而SIP用掉了44k字节. 
<br />使用同样编码算法的时候, IAX2也会比SIP少用一点带宽. 它不使用RTP协议传送语音数据. 大多数语音数据都是在"Mini Frame"中传送, 只有4个字节的包头, 比12个字节的RTP包头小. 
<br />按照我们前面<a href="20071031cn.php">SIP</a>带宽的同样方式计算, IAX2中Speex网络包总共(50 + x)字节. 当2帧(40ms)Speex数据在一个网络包中传送的时候, 实际使用带宽跟不同比特率组合的计算见下表. 
<br />(50 + 2x) / 5的公式来源于: 8kbps * ((50 + 2x) / 2x) * (x / 20). 比特率8kbps刚好是每20毫秒20个字节的数据. 
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
        <td class=c1 align="center">20ms帧 (x byte)</td>
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
