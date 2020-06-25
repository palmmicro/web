<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>烧录程序存储器</title>
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
<tr><td class=THead><B>烧录程序存储器</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2010年12月2日</td></tr>
<tr><td>一个GP1266用户和一个AR168MS<a href="../../../ar1688/modulecn.html">网络语音模块</a>生产商都在问如何自己烧录设备上用的程序存储器, 我于是写了这篇简单的说明. 所有提到的文件都可以在AR1688 <a href="../../../ar1688/software/sw049cn.html">0.49</a>测试软件页面下载. 
<br />此用户的<a href="../../../ar1688/user/gp1266cn.html">GP1266</a>电话不能启动而且不能进安全模式, 我要说这是头一次听到这种问题, 通常<a href="../pa6488/20090927cn.php">安全模式</a>总是会工作. 
他计划取下程序存储器, 用外部编程器烧录它, 然后再焊接回去. 所需步骤如下: 
<br />1. 下载压缩的<a href="../../../ar1688/software/049/gp1266_sip_us_049016_all.zip">gp1266_sip_us_049016_all.bin</a>, 用普通支持MT28F016S5芯片的编程器烧录它, 焊接回去. 一切顺利的话电话会用MAC地址00-18-1f-00-00-00启动 
<br />2. 下载压缩的其它文件<a href="../../../ar1688/software/049/gp1266_sip_us_049016.zip">gp1266_sip_us_049016.bin</a>, <a href="../../../ar1688/software/049/gp1266_sip_us_mac_049016.zip">gp1266_sip_us_mac_049016.bin</a>和
<a href="../../../ar1688/software/049/gp1266_none_us_049016.zip">gp1266_none_us_049016.bin</a>, 按照<a href="20070827cn.php">这里</a>的描述修改MAC地址. 这一步是必须的, 它不仅修改设置中的MAC地址, 
而且产生<a href="20070605cn.php">page0</a>中的MAC校验值. 普通编程器只能修改MAC地址, 校验值错误的情况下用户会看到类似于"hardware check failed"的调试错误信息
<br />对生产商来说, 尽管上面的步骤也可以使用, 但是第2步对于量产来说太麻烦了. 我们寄了一个基于<a href="../../../ar1688/indexcn.html">AR1688</a>芯片的AR168DS编程器给他们, 专门设计用于烧录SST39VF1681和MX29LV160CB程序存储器. 我们另有为使用MT28F016S5的生产商准备的AR168D编程器. 
<br />下面是我用来写这篇说明的AR168DS<a href="../../../ar1688/programmercn.html">编程器</a>图片. 
</td></tr>
<tr><td><img src=../photo/20101202.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
