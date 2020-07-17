<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>USB接口</title>
<meta name="description" content="接触和学习了十多年的USB, Woody现在终于有机会在新的PA3288 VoIP方案中用上了. 看看我们新的WiFi VoIP产品计划吧. 真心希望能够早一点有东西可以卖.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa3288.js"></script>
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
<script type="text/javascript">NavigatePa3288();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>USB</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2013年8月31日</td></tr>
<tr><td>为MP3和数码相机设计的<a href="../../../pa1688/indexcn.html">PA1688</a>集成了USB 1.1从设备, 但是在VoIP软件中我们从来没有使用过它. 
<br />2004年一个新CEO取代了王老板在Centrality原来的位置. 年底新CEO视察过北京公司后, 我就清楚的知道要准备好随时自己继续做VoIP生意了.
<br />整个2005年我都在积极的计划下一步. 后来终于决定先做一个USB FXS网关的方案, 作为现有VoIP产品的补充, 以后再开发一个WiFi VoIP方案取代PA1688. 
<br />我跟一个国内的芯片设计公司签了合同, 付了定金开发这个8051+USB芯片, 然后开始学习USB的软件编程. 很快我发现Keil提供了全部我们需要的USB HID, 声音和海量存储设备类的例子, 只不过它是用在基于Philips LPC2148芯片的MCB2140硬件板上.
<br />USB FXS网关是个好的产品想法. 后来的几年中MagicJack销售了上千万个类似的产品, 赚的钱让它在2010年7月16号反向收购了最早的VoIP公司VocalTec. 不过我们自己的方案却没有完成. 
<br />2005年底的时候CEO终于解雇了我们. 虽然从时间上来说比我预料的要晚了好几个月, 但他决定停止PA1688的生产却大大出乎了我的意料. 我被迫放弃了USB芯片的开发, 转而用最快的方式去为我们的现有客户找一个PA1688的替代方案. 
<br />基于一个流行的MP3芯片, 我们在2006年开发了快速替代方案<a href="../../../ar1688/indexcn.html">AR1688</a>. 它集成了USB 2.0从设备, 但是同样的在VoIP软件中我们从来没有使用过它. 
<br />目前的PA3288带来的新的转机. 由于集成了USB 2.0 OTG, 它简直就是我在2005年时的梦想芯片. 我们计划给它接上WiFi USB模块, 实现一个低成本的WiFi <a href="../entertainment/20110323cn.php">VoIP</a>方案.
作为第一步, 我翻出来了新Keil版本中的MCB2140 USBMem例子, 唐丽把它和开放源代码的<a href="../pa6488/20101225cn.php">EFSL</a>文件系统集成在一起.
现在的PA328A硬件板可以作为一个标准的FAT16 <a href="../../../pa3288/software/devguide/usbcn.php">USB</a>海量存储设备用于调试数据.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
