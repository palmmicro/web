<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>RTP First</title>
<meta name="description" content="With RTL8019AS ethernet chip, we created a Mini Run method to handle RTP packet first during the long process time of a SIP register packet.">
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
<tr><td class=THead><B>RTP First</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 16, 2007</td></tr>
<tr><td>There is no RTOS with <a href="../../../ar1688/index.html">AR1688</a> software, everything is being performed inside a loop like
<blockquote><code>while (1) 
<br />{ 
<br />&nbsp;&nbsp;&nbsp;&nbsp;do_everything(); 
<br />}
</code></blockquote>
To make things worse, the 8-bit Z80 processor is slow for task like MD5 encryption, typically takes 5-10 milliseconds. We use same FWD test account to test IAX2 and SIP protocol.
<a href="20071110.php">IAX2</a> protocol needs 12ms to do a register with 1 MD5 calculation. SIP protocol needs 80ms to do a register with 3 MD5 calculation.
Within the 80ms of SIP register, all incoming and outgoing RTP packets are held unhandled, thus cause a lot of RTP jitter during a call.
<br />The problem was pointed out by customer on our mailing list, the customer suggested that the usage of RTOS is the only solution.
However, AR1688 resource indeed can not afford an extra RTOS. Instead, we implemented a RTP first method in 0.25 software and solved this problem perfectly.
<br />When inside a SIP message handling process, we will call <i>TaskMiniRun</i> a few times to handle outgoing and incoming RTP packets in time.
The function acts sort of like an interrupt routine, it will save necessary information of the SIP message process, send and receive RTP data, and restore SIP message handling.
<br />Nothing is impossible.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=Update>Updated on July 29, 2015</td></tr>
<tr><td>The interrupt like function need quite some resources, we recently found a stack overflow problem when user added some of his own code.
To help debug, we added <b><i>SYS_MINI_RUN</i></b> in <b>version.h</b>, the RTP first Minu Run for RTL8019AS will only work when it is defined.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/rtl8019as.jpg alt="RTL8019AS chip on China Roby PB-35 IP phone inside PCB board." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
