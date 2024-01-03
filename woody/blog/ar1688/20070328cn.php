<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>铃音和通话保持音乐</title>
<?php EchoInsideHead(); ?>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>铃音和通话保持音乐</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年3月28日</td></tr>
<tr><td>回答了一封有关PA1688铃声升级后变成噪声的邮件后, 我意识到应该解释一下PA1688和<a href="../../../ar1688/indexcn.html">AR1688</a>铃音的区别. 这2个芯片的铃音格式是不同的. 用AR1688的铃音更新PA1688设备后会导致噪声. 用PA1688的铃音更新AR1688设备, AR1688通常会在做简单的名字检查后拒绝. 
<br />造成混乱的主要原因在于网页下载地址. PA1688铃音应该在<a href="../../../pa1688/ringcn.html">这里</a>而AR1688铃音应该在<a href="../../../ar1688/ringcn.html">这里</a>. 
<br />PA1688和AR1688铃音的区别:  
<br />1. PA1688把同一段音乐使用G.723.1和G.729分别压缩后合并在一起做为铃音. AR1688只使用G.711 mu律压缩, 避免G.723.1和G.729专利费用问题. AR1688网络电话可以完全不使用G.723.1和G.729, G.711格式的铃音质量上也会好很多. 
<br />2. AR1688铃音最长可以有24.48秒, 比PA1688固定的7.68秒长不少. 时间长而压缩效率低, 显然AR1688需要更大的程序存储器空间保存铃音.  
<br />3. AR1688使用另外192k字节程序存储器空间保存同样长度24.48秒和同样格式的通话保持音乐. 区分开振铃音和通话保持音乐后, AR1688用户应该就不会抱怨PA1688用户的典型问题"我按下通话保持键后听到了振铃音". 通话保持音乐的文件跟铃音文件一致, 只在名称上有差异. TFTP更新的时候会根据文件名称决定更新到哪块程序存储器区域. 在AR1688上我们努力改进了不少商务电话的特点, 通话保持音乐是其中之一. 
<br />我们从手机生意上看到了自定义铃音的重要性. 跟<a href="../../../pa1688/indexcn.html">PA1688</a>一样, 用户可以自己录制和制作自己的铃音和通话保持音乐, 具体步骤请阅读开发指南. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
