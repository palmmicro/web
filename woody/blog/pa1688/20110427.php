<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Software Over-Optimization</title>
<meta name="description" content="How our RTL8019AS software over-optimization resulted in an unsteady ET6602 IP phone. Software test is never enough.">
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
<tr><td class=THead><B>Software Over-Optimization</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 27, 2011</td></tr>
<tr><td>The same user who found and solved the <a href="20110420.php">LM386</a> problem had another question since last year. He bought an <a href="../../../pa1688/user/et6602.html">ET6602</a> IP phone for 50RMB on <a href="http://tradearchive.taobao.com/trade/detail/trade_snap.htm?trade_id=56743898219541" target=_blank>Taobao</a>,
but found the phone can only use PA168T software 1.51, with 1.64 the phone got very unsteady. I thought it was just another <a href="20080806.php">non-standard</a> PA1688 device which can not work with standard software at that time.
But now the user's enthusiasm in technology and ability to solve problem impressed me, and I decided to check the problem again.
<br />To my surprise, this ET6602 indeed can work with our standard 1.51 software, which was the first software release since Centrality discontinued <a href="../../../pa1688/index.html">PA1688</a> business in 2006. But with current 1.66 software release it often got dead.
Then I tested 1.57 failed, 1.54 ok, 1.56 ok. After comparing the source code between 1.56 and 1.57, it was clear that the software optimization for <a href="../ar1688/20080615.php">RTL8019AS</a> caused the unsteady problem.
<br />I can still remember those changes, which was first made on <a href="../../../ar1688/index.html">AR1688</a> performance improvement, and then moved back to PA1688 without widely tests on various PA1688 devices. Obviously not all PA1688 devices are created equal, this ET6602 is poorly made in hardware and needs special software error protection.
After restored those software over-optimization, I updated its <a href="../../../pa1688/software/sw167.html">1.67</a> test software in our website. 
</td></tr>
<tr><td><img src=../../../pa1688/user/et6602/6s.jpg alt="PA1688 based ET6602 IP phone PCB" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
