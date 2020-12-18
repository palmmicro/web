<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>JPEG总动员</title>
<meta name="description" content="当PA6488网络语音和视频方案需要JPEG的时候, 我写了这个纪录从1992年开始通过宫泽理惠(Rie Miyazawa)Santa Fe JPEG文件学习软件编程的过程.">
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>JPEG总动员</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年5月16日</td></tr>
<tr><td>在1992年的某一天, 杨明激动万分地给我描述了一种叫做JPEG的新技术. 他刚刚把自己的宫泽理惠收藏从BMP转成了JPG, 节省了大量的软盘. 他同时有点担心压缩有损以及在莫钧的286计算机上看有点慢这些问题. 这是我第一次接触JPEG. 
<br />第一次我着手用JPEG源代码是在1997年. 贾博士和我一起写了个测试CMOS摄像头原始图像扩展算法的程序. 我用<a href="http://www.ijg.org/" target=_blank>IJG JPEG</a>版本"6a 7-Feb-96"的源代码处理JPG文件的读写. 下面的图片是这个程序的抓屏, 我当时在测试中大量的使用了宫泽理惠的图片. 
<br />当PA6488的<a href="20100109cn.php">网页界面</a>需要JPEG文件支持时, 我从IJG下载了版本"8b 16-May-2010", 很快开始了<a href="../../../pa6488/software/devguide/jpegcn.html">使用</a>. 由于JPEG只是偶尔用到, 性能上要求不是很高, 因此我们也没有像对付H.264那样优化它. 
<br />上个月的时候我无意中发现IJG挪到了版本"8c 16-Jan-2011". 虽然具体的改动不影响我们<a href="../../../pa6488/indexcn.html">PA6488</a>方案, 为求心安我还是在上周合并了代码. 
</td></tr>
<tr><td><img src=../photo/20110516.jpg alt="test interpolation algorithm with Rie Miyazawa Santa Fe JPEG file" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
