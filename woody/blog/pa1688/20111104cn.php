<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>升级老PA168F的步骤</title>
<meta name="description" content="如何升级PA168F软件">
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
<tr><td class=THead><B>升级老PA168F的步骤</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年11月4日</td></tr>
<tr><td>某用户给我们发了来几张新的<a href="../../../pa1688/indexcn.html">PA1688</a>网络电话图片, 并且报告说LCD上显示"PA168F". 查了PCB图片并且在上面找到"MX29LV004TTC"程序存储器后, 我倾向于认为它是基于早期PA168F<a href="20080806cn.php">标准</a>参考设计. 但是它的键盘远比PA168F复杂, 估计是生产商自行开发了这些键盘软件. 今天我们只能尝试一下标准的PA168F软件, 希望基本的数字键盘能正常工作. 
<br />即使是标准的PA168F, 我们在把它升级到目前的正式软件版本<a href="../../../pa1688/software/sw166cn.html">1.66</a>的过程中也会碰到问题. 因为我们早期软件开发过程中的一个愚蠢的决定, 我们改变了PA168F的启动次序, 我们需要采用一些特殊步骤才能把它升级到现在的版本. 
<br />我上传了<a href="../../../pa1688/user/pa168fcn.html">PA168F</a>的"SIP英文"和"安全模式文件到"<a href="../../../pa1688/software/sw167cn.html">1.67</a>测试软件页面. 用户可以先通过普通方式如<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>或者<a href="../pa6488/20100109cn.php">网页界面</a>正常升级SIP英文软件. 升级后如果出现不能启动的问题, 如死在了"<a href="../../../pa1688/faqcn.html#booting">Booting</a> ..."的情况, 我们可以用以下方法修复: 
<br />执行类似于<a href="20110814cn.php">这里</a>描述的步骤1到4, 强迫PA168F进入<a href="../pa6488/20090927cn.php">安全模式</a>. 选择PalmTool "PFlash Page"为"page0"、"PFlash Type"为"AM29LV004T"、"IP Address in Chip"为"192.168.1.100"、使用"Update PFlash"升级安全模式文件<a href="../../../pa1688/faqcn.html#page0">page0.hex</a>. 
<br />另外有关这个电话有趣的一点, 是它用了Winbond W83972D做为<a href="20070607cn.php">AC97</a>芯片. 考虑到我们在2004年的时候如此艰难的寻找Wolfson WM9703/WM9707的替代品, 我真希望能早几年看到这个客户的板子! 
</td></tr>
<tr><td><img src=../photo/20111104.jpg></td></tr>
<tr><td>PCB <a href="../../../pa1688/user/pa168f/pcb.jpg" target=_blank>放大</a></td></tr>
<tr><td><img src=../../../pa1688/user/pa168f/pcb_s.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
