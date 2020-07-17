<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>用重拨键当静音键</title>
<meta name="description" content="基于一个5111PHONE用户所做的软件修改, 我们现在在标准PA1688软件中用重拨键当静音键. 能显示我们的进步的地方是, 所有AR1688电话设计都有单独的静音键.">
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>用重拨键当静音键</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2013年2月10日</td></tr>
<tr><td>上个月我收到一封邮件: 
<br /><font color=gray>First, let me thank you for making the pa1688 source code available. (首先, 谢谢你们pa1688源代码公开的举措.)
<br />I have a few 5111PHONE units, and they've been working quite well for nearly ten years. However, I have often wished that they had a mute button. (我手头有几台5111PHONE电话, 在过去接近10年中一直工作得相当好. 但是, 我经常希望它们有一个静音键.)
<br />I spend a lot of time on conference calls, and I like to put them on speaker while I half-listen. It is usually a good idea to mute the microphone for obvious reasons ... 
(我在会议电话中度过了很多时间, 当我只是在听的时候, 我喜欢把电话放到免提上. 由于显而易见的原因, 把麦克风静音会是个好主意 ...)
<br />... so I have assigned a mute function to the redial button. It's not likely that I will need to redial the previous number while on a call, so it seemed the logical thing to do.
(... 于是我用重拨键实现了静音功能. 因为我不太可能会在打电话的时候重拨上一个号码, 这看起来是个合理的方案.)
<br />Diff attached. I'd appreciate it if you were to incorporate some version of the patch into your repository, so that I won't have to manually patch the source when I update the firmware.
(附件中是改动的代码. 我希望你能够把这个改动用到你的版本中, 这样我下次升级软件的时候不用再手工做这个修改了.)
<br />Thanks again for making the source code free. (再一次感谢自由软件.)
</font>
<br />我高兴的合并了他的改动, 并且觉得奇怪为什么这么好的主意在过去10年中没有被实现过. 很快我发现我们标准的<a href="../../../pa1688/user/pa168scn.html">PA168S</a>软件中, <b>服务IP</b>键按照完全相同的方式被复用成了<b>静音</b>键.
<br />由于<b>重拨</b>键更为常见, 而且通常占据着更好的位置, 我把这个功能用在了所有PA1688电话的<a href="../../../pa1688/software/sw169cn.html">1.69</a>后软件版本中.
<br />然后我检查了<a href="../../../ar1688/indexcn.html">AR1688</a>电话, 很欣慰的发现它们全部都有一个单独的<b>静音</b>键. 显然在我们7年前设计AR1688方案的时候, 还是多少有了些长进的!
<br />&nbsp;
<br /><font color=gray>上海五川提供的官方<a href="../../../pa1688/user/5111phonecn.html">5111PHONE</a>图片.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/5111phone/ib_302.jpg alt="The official picture of 5111PHONE provided by 5111SOFT." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
