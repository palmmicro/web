<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>iLBC编码算法完成</title>
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
<tr><td class=THead><B>iLBC编码算法完成</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年3月7日</td></tr>
<tr><td>在一月一月的拖延后, 今天<a href="20070216cn.php">iLBC</a>编码算法终于在AR1688芯片上正常运行了, 在代码整理和内部测试后我们会发布0.08版本软件, 这个周末有望放在我们网站上. 
<br />有人问过我为什么iLBC的开发计划放在G.729的前面. 最重要的原因是iLBC没有专利费用. <a href="../../../ar1688/indexcn.html">AR1688</a>芯片的价格不包含任何专利费用, 如果用户使用G.729或G.723.1这两个著名ITU-T标准编码算法的话, 生产厂商需要付专利费用. 这样自然会提高网络电话的总价格. AR1688网络电话的设计理念类似于IAX2协议, 让终端尽可能简单好用, 同时做到全世界最低价, 便宜到能够跟普通电话差不多. 因此我们最不愿意看到的就是付额外的编码算法专利费用. 当然我们还是会在不久的将来提供G.729和G.723.1算法支持, 但是只会把它们作为可选项目, 可以从标准软件中拿出来不使用. 同时我们还会在软件中加入另外一个不收专利费用的算法Speex. 
<br />当然先做iLBC还有其它的原因. G.729是个12年前的老标准, 它原本是为电路交换系统设计的, 用来给标准的64k pcm信道扩容. G.729没有考虑过IP网络通信的特点, 而iLBC正好相反, 是专门为网络语音通信设计的, 在网络丢包的情况iLBC效果会更好. 
<br />我们在做决定前充分意识到了G.729目前广泛用在交换PSTN和IP通话的落地网关中, 另外我们还了解到Cisco已经在去年给它的落地网关加入了iLBC支持. 然而我们还是收到了大量的抱怨说iLBC不能跟PSTN电话互通. 作为一个经常<a href="20060929cn.php">升级</a>软件的开发人员, 我明显低估了升级Cisco落地网关软件的复杂程度. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
