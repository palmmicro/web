<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>使用RFC 2833发送PTT</title>
<meta name="description" content="RFC 2833, PTT">
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
<tr><td class=THead><B>使用RFC 2833发送PTT</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2012年4月30日</td></tr>
<tr><td>Radio over IP是<a href="../../../ar1688/modulecn.html">AR168M</a>网络语音模块用得最多的地方之一. 基于它的受欢迎程度, 我们甚至在去年开始了<a href="../../../ar1688/roipcn.html">AR168R</a> RoIP模块的设计. 
<br />由于有强烈的<a href="20080811cn.php">标准</a>愿望, 我一直在犹豫用什么方式传送COR/PTT信号. 我强烈反对某些客户单开一路<a href="20110331cn.php">UDP/TCP</a>的做法. 用于手机对讲(PoC)的RFC 4354看来是已有SIP协议中最接近的, 但是我无法找到实际测试兼容性的方法, 同时我还很怀疑现在谁还会跟着可怜的老Nokia走. 有人用<a href="../../../ar1688/indexcn.html">AR1688</a>软件中从来没有用过的RTCP, 还有人用特殊的SDP协商后在RTP中传输, 所有这一切对我而言都看上去很奇怪. 
<br />昨天我突然想到, 其实我要传送的无非就是按键的信息: 我按下键开始说话, 停止说话后松开键. 为什么不直接用代码中现成的RFC 2833软件当成DTMF按键传送? 这样即使AR168R跟其它SIP终端通信的时候, 对方也无非认为只是几个按键而已, 没有什么特别的. 
<br />基于这个简单的想法, 我在<b>ar168r.c</b>中定义了KEY_COR_HIGH和KEY_COR_LOW. PTT按下时我送出KEY_COR_LOW宣布我要说话了. PTT松开后我送出KEY_COR_HIGH表示讲话完毕. 
<br />&nbsp;
<br /><font color=magenta>2013年9月19日更新</font>
<br />跟Asterisk MeetMe的测试发现用RFC 2833发送的PTT信息会在会议中丢失. 我们在<a href="../../../ar1688/software/sw063cn.html">0.63</a>软件中修改了交换COR/PTT信号的方式, 改为用<a href="20080512cn.php">SIP MESSAGE</a>文本发送"COR HIGH"和"COR LOW".  
<br />&nbsp;
<br /><font color=magenta>2014年6月25日更新</font>
<br />增加<b><i>OEM_JOSN</i></b>编译选项, 给需要保留用RFC 2833交换RoIP COR/PTT信号的厂商. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
