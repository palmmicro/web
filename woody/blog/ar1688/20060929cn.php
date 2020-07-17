<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>软件升级</title>
<meta name="description" content="由于通信协议经常变动, 今天网络电话最重要的功能莫过于软件升级了, AR1688采用了TFTP协议. 本文比较了Palmmicro AR1688和PA1688的软件升级功能, 当然我们的越做越好的了.">
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
<tr><td class=THead><B>软件升级</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2006年9月29日</td></tr>
<tr><td>什么是今天网络电话最重要的功能? 我的答案是软件升级. 为什么? 因为VoIP技术一直很快地在变化! H.323太古老了而且不能很好地穿透NAT. MGCP是传统电信运营商主导的产物而且有违于互联网的精神.
好吧, 从互联网发源的SIP和开放源代码的IAX2怎么样呢? 它们都尴尬的输给了基于私有协议的Skype. 因此如果你的网络电话不能容易的升级, 你期望它能用多久? 
<br />我们在<a href="../../../ar1688/indexcn.html">AR1688</a>上做的第一件事就是软件升级. 它具备老PA1688所有好的升级特点, 并且我们尽力消除了PA1688中不好的方面.
<br />1) 话机死机时可以按*键进入安全模式. 在安全模式下用户能够使用"本地"的方法再次升级话机. PA1688需要按住*键上电两次进入192.168.1.100.
AR1688只需要按住*键上电一次即可进入192.168.1.200. 为什么不是100? 因为我们希望避免PA1688和AR1688同时进入安全模式时出现问题. 
<br />2) 使用AR1688话机死机的概率大大降低. 跟PA1688不同, AR1688话机即使在升级的过程中掉电也不会死机, 因为我们对于当前正在运行的程序和正在更新的软件使用了不同的程序存储器地址空间. 
<br />3) "本地"升级方法从使用私有协议的<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>改为TFTP. 在过去的多年中我们经常被要求提供Linux下的PalmTool版本. 而Linux用户不必找我们要TFTP客户端程序.
在Windows环境中命令行升级方法: <font color=gray>tftp -i xxx.xxx.xxx.xxx put ar168e_sip_cn_000543.bin</font>. 
<br />4) 是的, 文件名使用和<a href="../../../pa1688/indexcn.html">PA1688</a>一样的格式, 以上的文件名意思是用SIP协议, 中文资源的0.00.543版本(当前稳定的演示版)升级一个AR168E话机. 
<br />5) "本地"升级的速度快多了. PA1688使用PalmTool升级960k字节的文件需要68秒. AR1688使用TFTP方式可以在16秒内升级640k字节的文件. 
<br />6) 两个芯片都支持HTTP升级, AR1688升级的速度就提高得更多了. 
<br />&nbsp;
<br /><font color=magenta>2014年8月3日更新</font>
<br />Yves指出:
<br /><b>Unix(Linux, MacOSX, Solaris or any BSD)用户注意要用TFTP非文本模式传输文件, linux命令行应该是:  tftp xxx.xxx.xxx.xxx -m binary -c put ar168e_sip_cn_000543.bin</b>
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
