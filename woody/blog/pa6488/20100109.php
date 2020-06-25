<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - Web Interface</title>
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
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
<tr><td class=THead><B>From PA1688 to PA6488 - Web Interface</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Jan 9, 2010</td></tr>
<tr><td>Web interface was not so widely as today when we were developing <a href="../../../pa1688/index.html">PA1688</a>. I still remember that we had to explain a lot to some users why we did not provide serial port configuration as other devices. I also remember that we implemented a telnet interface in early versions of PA1688 software, because we were all using telnet to visit bbs at that time. We did not spend much time on the look of the PA1688 <a href="../../../pa1688/settings/sipphone_sip_us.html" target=_blank>web interface</a>, and  it is looks ugly for most of the users.
<br />An engineer in Huawei3Com thought it was ugly too and tried to improve. After he knew that PA1688's built-in web server can only provide one file, he implemented a better look one using a little javascript. This is where today's <a href="../../../ar1688/index.html">AR1688</a> web interface comes from. The javascript was obviously written for IE. So AR1688 <a href="../../../ar1688/settings/sipphone_sip_us.html" target=_blank>web interface</a> looks a little strange for Firefox and Chrome users.
<br />With almost unlimited resources for <a href="../../../pa6488/index.html">PA6488</a> web interface. It finally becomes a normal one, just looks like my home page today. I believe that there will be user with professional web design experience to develop a much better one based on PA6488 API in the future. And we can move on with it then.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
