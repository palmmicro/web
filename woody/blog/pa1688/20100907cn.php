<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>夜以继日瞎忙</title>
<meta name="description" content="在我为Soyo G1681 (PA168V)编译西班牙文软件的时候, 我突然意识到了这么多年我们是如何让PA1688的软件越跑越慢的. 增加OEM_MODEM编译选项优化一点速度.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>夜以继日瞎忙</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2010年9月7日</td></tr>
<tr><td>今天下午的时候, 我在我的老<a href="../ar1688/20100818cn.php">Sony PCG-K23</a>上编译几个西班牙文的<a href="../../../pa1688/user/pa168vcn.html">PA168V</a>升级软件.
同时在又一次抱怨微软的自动升级如何成功的在20个月内把一台好好的计算机搞得这么慢. 突然一下我想到, 其实我们对<a href="../../../pa1688/indexcn.html">PA1688</a>软件也一直在做同样的事情. 
<br />每次我们增加一点功能, 它就会变得慢一点. 
<br />当我们加入iLBC支持的时候, 为了把它放到原有的程序存储器空间中, 我们被迫压缩了程序存储器上所有的DSP代码, 然后再在启动过程中解压缩. 这样一来启动时间搞得比一个嵌入式Linux系统还长.  
<br />当我们在某些PA1688硬件设计中加入<a href="../../../pa1688/user/iphe00cn.html">拨号上网调制解调器</a>的时候, 为了保证软件<a href="../ar1688/20100715cn.php">不分叉</a>, 我们把很多函数统统包裹了一层调用.
无疑这会让<b>所有</b>PA1688设备的性能都一起下降. 
<br />想到这点后我马上开始区分拨号上网和其它代码. 增加了一个新的OEM_MODEM编译选项, 没有使用这个编译选项的情况下, 绝大多数的调制解调器代码都会被排除在普通升级软件之外.
这意味着从版本1.65.005开始拨号上网的用户需要特殊升级软件(名称类似于pa168s_sip_us_modem_165005.bin), 但是绝大多数的Ethernet网络用户会从性能中受益.  
<br />当这一切优化和测试搞完的时候已经接近午夜. 我上传了新编译的PA168V文件到<a href="../../../pa1688/software/sw165cn.html">网页</a>,
然后邮件通知日前从网上花6美元一个购买来这个<a href="../../../pa1688/user/ag168vcn.html#soyo">Soyo G1681</a> PA168V的主人.
跟他上次花150美元购买的50个"Soyo G668" <a href="../../../pa1688/user/pa168scn.html">PA168S</a>网络电话相比, 这个单口网关居然贵得翻了一倍的价格.  
</td></tr>
<tr><td><font color=gray>It's been a hard day's night, and I been working like a dog. -- A Hard Day's Night</font></td></tr>
<tr><td><img src=../../../pa1688/user/g1681/soyo.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway front view." /></td></tr>
<tr><td><img src=../../../pa1688/user/g1681/back.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway back view." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
