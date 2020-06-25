<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>命名规则</title>
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
<tr><td class=THead><B>命名规则</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2008年6月7日</td></tr>
<tr><td>典型的<a href="../../../ar1688/indexcn.html">AR1688</a>升级文件名具备xxxxxxxxxxxxxxx_yyyy_zz_vvvvvv.bin这样的格式. 在特殊情况下也可能是xxxxxxxxxxxxxxx_yyyy_zz_ooooooooooooooo_vvvvvv.bin, 在下划线'_'之间的不同部分有不同的含义. 
<br />xxxxxxxxxxxxxxx: 这是我们常说的"<a href="20061014cn.php">硬件型号</a>". 尽管是基于同样的AR1688芯片, 不同的厂商会有不同的主板设计, 需要不同的升级软件. 虽然我们也可以象大多数PC软件那样做硬件检测让所有不同的设备使用相同的软件, 但是那样会浪费大量的代码和内存空间, 对于低成本资源有限的AR1688系统来说是不合适的. "AR168X"硬件型号通常是开放给所有客户的标准设计. 在大多数情况下厂商会为了区分产品而选择不同的硬件型号. 如Digitmat选择"<a href="../../../ar1688/user/gp1266cn.html">GP1266</a>"和"GP2266"硬件型号用于他们的IP电话. 硬件型号可以是15个字符和数字的组合. 跟文件名的其它部分类似, 硬件型号是不区分大小写的, 并且在名字中不能用下划线. 例如"BT_2008"需要改为"BT2008N", "DX_DT"要改为"DXDT". 
<br />yyyy: 这是协议类型. 它最多4个字节, 例如"<a href="20060929cn.php">SIP</a>"或"<a href="20071110cn.php">IAX2</a>". 字符串"none"用于生成安全模式的升级文件, 它只有64k字节, 文件大小远小于正常的升级文件. 
<br />zz: 这是<a href="20070405cn.php">资源</a>类型. 它只有2字节, 例如"cn"用于中文, "fr"用于法文. 我们遵守ISO 3166标准的国家编码. 一个显而易见的问题是从一开始我们就没有考虑使用多个语言的国家. 所以为使用法语的加拿大人编译一个用于IP电话的加拿大法文版软件有点难. 
<br />ooooooooooooooo: 这是OEM类型, 其规则类似于硬件型号. 再一次说明不要在OEM名字中使用下划线. 将相同的硬件产品供应给不同的OEM客户时会用到OEM类型. 这样特殊的设置和功能特点能够包含于不同的升级文件中. 在开发阶段我们也使用不同的OEM名字做各种各样的测试. 
<br />vvvvvv: 这是版本部分. 它总是6个数字. 前三个数字是主版本, 后3个数是小版本号. 例如033007表示0.33版本中的007测试版. 我们使用偶数主版本号用于正式发布并且让小版本数字为0. 032000是最近的软件正式发布版. 
<br />几年前我们在OBWAN的建议下开始使用这些命名规则, 当时他是一个积极的<a href="../../../pa1688/indexcn.html">PA1688</a>用户. 我们一直在向所用的用户和合作伙伴学习, 所以有什么建议的话请今天就发给我们! 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
