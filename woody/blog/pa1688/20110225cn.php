<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>PA1688设备杀手</title>
<meta name="description" content="由于不同硬件设计中使用了不同的程序存储器，我们的软件中有缺乏有效的检查，给一个PA1688设备更新page0.hex是件很危险的事情，很容易会毁掉它。但是我却一直在建议客户做这件事情！">
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
<tr><td class=THead><B>PA1688设备杀手</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年2月25日</td></tr>
<tr><td>几天前有个用户通过话机后面的00-09-45 <a href="../palmmicro/20091114cn.php">MAC</a>地址找到了我们。我按照标准流程回信要求他提供话机详细的内外图片。从他发的(如下)图片看我猜想是个标准的<a href="../../../pa1688/user/pa168scn.html">PA168S</a>网络电话，建议他到PA1688 <a href="../../../pa1688/software/sw166cn.html">1.66</a>版本软件页面下载更新。昨天他告诉我话机更新后死在了"Booting ..."阶段。
<br />其实我们比较熟悉这个"Booting ..."问题。虽然从来没有真正找到原因，我们总是会发出page0.hex <a href="../pa6488/20090927cn.php">安全模式</a>文件，要求用户用<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>更新。虽然通常都能解决问题，但是这次我却相当的犹豫。
<br />我想起了不久前另外一个客户给我看了<a href="../../../pa1688/user/ip300cn.html">IP300</a>网路电话图片后，我建议他升级PA168S软件。升级后死在"Booting ..."阶段后，我又发给他page0.hex升级，然后就彻底把话机给毁了。这是我第二次通过发送page0.hex<a href="../pa1688/20091215cn.php">毁掉</a>PA1688设备。比第一次更糟糕的是，我至今还不知道原因。 
<br />我只能猜想这多半是另外一种<a href="../pa1688/20080806cn.php">非标准</a>PA1688设备，虽然它看上去像PA168S，实际上它不能用我们的标准软件升级。同时我会发这篇文章给这个用户，看他是否想再尝试一下危险的page0.hex。
<br />&nbsp;
<br /><font color=magenta>2011年2月26日更新</font>
<br />豫能的一个硬件工程师读了这篇文章后指出它其实是<a href="../../../pa1688/user/ywh500cn.html">YWH500</a>网络电话。
</td></tr>
<tr><td><img src=../photo/20110225.jpg></td></tr>
<tr><td><a href="../../../pa1688/user/ywh500/2l.jpg" target=_blank>大图</a> <a href="../../../pa1688/user/ywh500/1l.jpg" target=_blank>外观</a></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
