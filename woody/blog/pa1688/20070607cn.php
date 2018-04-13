<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>迟到太多的好消息</title>
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
<tr><td class=THead><B>迟到太多的好消息</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年6月7日</td></tr>
<tr><td>今天一个很小的<a href="../../../pa1688/indexcn.html">PA1688</a>生产商告诉我1.58.003软件解决了他们ALC202A的问题。尽管这是个好消息，我却觉得挺伤感。这个好消息来得实在太晚了，我们应该在至少三年前就解决这个问题。
<br />PA1688使用AC97接口连接外部模拟音频AD/DA转换器。在第一个FPGA板上我们使用Wolfson的WM9703，后来WM9707代替了WM9703。那些年里我们一直在寻找其它兼容的AC97芯片替代它。Realtek的ALC202A是其中最接近成功的一个。
<br />问题的根源实际上非常简单。一个生产商的工程师注意到在复位的时候有一个异常的信号。我们使用GPIO去复位AC97。他进一步发现当使用外部复位信号去复位ALC202A而不使用GPIO时，信号是对的。我检查了软件，发现软件GPIO复位是在AC97接口时钟启动之后。把GPIO复位移到AC97接口时钟启动之前，问题就解决了。
<br />我们至少在三年前就开始使用ALC201/2A，因为Realtek的AC97芯片只有WM9707价格的一半。很多我们的大客户也跟我们一起生产了基于ALC202A样机，但是都没有解决不稳定的问题。我真希望当时我们就能发现并且解决这个问题，现在PA1688已经停产一年多了，实在是太晚了。
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/wm9707.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
