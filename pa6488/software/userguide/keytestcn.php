<?php require("../../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>键盘测试</title>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa6488.js"></script>
<script src="../software.js"></script>
<script src="userguide.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<TR><TD>&nbsp;</TD></TR>
<script type="text/javascript">NavigateUserGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>键盘测试</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>1 概述</B></td></tr>
<tr><td>键盘测试不仅用于像PA648B这样实际带有键盘的设备, 也同时用于<a href="../../../woody/blog/pa6488/20090819cn.php">PA648C</a>这样的<a href="../../../woody/blog/pa6488/20110411cn.php">串口</a>控制模块. 我们用这种方式提供基于<a href="../../../woody/blog/ar1688/20080329cn.php">用户界面协议</a>的模块控制功能. 
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>2 细节</B></td></tr>
<tr><td>所有的键盘测试功能都由#n*m按键组合触发, 定义如下: 
<br />
<br />b) '#1' -- 系统测试, 如果以下键按下
<br />'*0' -- 系统重新启动
<br />
<br />h) '#7' -- 视频输入测试, 如果以下键按下
<br />'*0' -- 开始原始视频输入数据测试
<br />'*1' -- 结束所有视频输入测试
<br />'*2' -- 开始视频输入H.263编码测试
<br />'*3' -- 开始视频输入H.263编码测试, 发送重建图像
<br />'*4' -- 开始视频输入H.264编码测试
<br />'*5' -- 开始视频输入H.264编码测试, 发送重建图像
<br />
<br />i) '#8' -- <a href="../devguide/filesystemcn.html">文件</a>测试, 如果以下键按下
<br />'*0' -- 删除G.729测试文件
<br />'*1' -- 删除JPEG测试文件
<br />'*2' -- 删除H.263测试文件
<br />'*3' -- 删除H.264测试文件
<br />
<br />j) '#9' -- 算法测试, 如果以下键按下
<br />'*0' -- <a href="../devguide/testvectorscn.html">G.729</a>测试
<br />'*1' -- <a href="../devguide/jpegcn.html">JPEG</a>测试
<br />'*2' -- <a href="../devguide/h263cn.html">H.263</a>测试
<br />'*3' -- H.264测试
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
