<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - TFTP性能</title>
<meta name="description" content="比较AR1688, PA6488和PA3288中TFTP性能的测试, 我们从PA3288开始整合PA6488和PA3288公用的TCPIP等相关软件代码, 方便以后其它平台的开发.">
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
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
<tr><td class=THead><B>从PA1688到PA6488 - TFTP性能</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年9月1日</td></tr>
<tr><td>事实上PA1688不支持TFTP协议. 除了普通的HTTP升级, 它用特殊的<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a><b>本地</b>升级工具. 
过去的三年多来我们开发了一个不成功的PA1688替代品, 但是在开发过程当中还是学了很多东西的. 其中最重要的一个, 就是按照现有<a href="../ar1688/20080811cn.php">标准</a>的方式做工作. 
<br /><a href="../../../ar1688/indexcn.html">AR1688</a>用标准的TFTP升级取代PalmTool作为<b>本地</b>升级方法. 我们叫它<a href="../ar1688/20060929cn.php">本地</a>升级方法因为在安全模式恢复中只能用它.
当然在正常运行时也能用, 就像HTTP升级一样. 作为TFTP服务器, AR1688能接收<a href="../ar1688/20080615cn.php">1.5-2.2</a>Mbps的数据. 
<br />在600MHz PA648A板子上, 用我的Sony笔记本做TFTP终端, 我能够把一个18034784字节的文件在7秒的时间导入到<a href="../../../pa6488/indexcn.html">PA6488</a> DDR2内存中! 
<br />18034784/512=35225 TFTP数据块. .
<br />每个TFTP数据块需要额外的4(TFTP头)+8(UDP头)+20(IP头)+14(MAC头)+8(MAC同步字)+4(MAC 校验值)=58字节来接收. 
<br />在7秒内的网络总接收数据是18034784+35225*58=20077834字节. 
<br />对应网络带宽20077834*8*/7=22.9Mbps. 
<br />TFTP协议需要对每个收到的数据块返回ACK, 对方没有收到当前数据块的ACK就不发新的数据. 我们在100Mbps的局域网上得到的数据传输率因此并没有100Mbps那么高. 
<br />&nbsp;
<br /><font color=magenta>2015年3月4日更新</font>
<br />在最近整合PA6488和PA3288公用的TCPIP等相关软件代码的过程中顺便测试了PA3288的TFTP性能. 使用ENC28J60网络芯片, 跑192Mhz的<a href="../../../pa3288/indexcn.html">PA3288</a>能够把一个8.5M字节的文件在27秒的时间导入,
大约相当于2.8Mbps的数据吞吐率. 就像在<a href="20090808cn.php">ping</a> 65500测试中看到的一样, 瓶颈在SPI接口的10Mbps网络芯片上. 
<br />原来AR1688和PA6488的TFTP代码都有32M字节文件大小的限制, PA3288也不例外, 不能测试大于32M字节的文件. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
