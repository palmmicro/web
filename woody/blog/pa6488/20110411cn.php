<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - 产品演化过程中的串口功能</title>
<meta name="description" content="Palmmicro各个产品系列PA1688, AR1688和PA6488中串口的使用情况介绍, 以及我们如何开始VoIP模块生意的回顾. 串口的生命力真是很顽强, 不服不行! ">
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
<tr><td class=THead><B>从PA1688到PA6488 - 产品演化过程中的串口功能</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年4月11日</td></tr>
<tr><td>虽然今天的<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>界面中仍然有串口设置界面, 我们其实仅在很早的调试阶段使用过PA1688的串口. 当年我们从节省成本上考虑, 拒绝了使用串口做为<a href="20100109cn.php">配置</a>界面. 我们总是在不遗余力的简化设计, 其中包括跟PC串口配合必须的电平转换MAX232芯片, 以及RTL8019AS设计中的<a href="../ar1688/20080615cn.php">93C46</a>芯片. 
<br />在2007下半年, 2个不同的客户都从AR1688硬件参考设计的原理图上发现了我们在使用串口管脚设计<a href="../ar1688/20080903cn.php">GPIO</a>键盘, 他们在差不多的时间同时给我们建议使用<a href="../ar1688/20071119cn.php">串口</a>作为<a href="../../../ar1688/modulecn.html">AR168M</a> VoIP模块的控制接口. 从那时候我们开始了模块设计. 到了2010年, 模块生意已经成了AR1688的主要销售来源. 
<br />为了延续我们在VoIP模块上的小小成功, 我们在<a href="../../../pa6488/indexcn.html">PA6488</a>方案中设计的第一个产品也是基于串口控制的模块<a href="20090819cn.php">PA648C</a>. 在其中我们同样使用了原来的<a href="../ar1688/20080329cn.php">高层用户界面协议</a>, 方便我们沿用原来的<a href="../ar1688/20080330cn.php">8051</a>演示软硬件. 
</td></tr>
<tr><td><img src=../photo/20111127.jpg alt="PA6488 and X-Lite fish demo via WiFi Ethernet bridge" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
