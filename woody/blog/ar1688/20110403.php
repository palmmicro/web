<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Disable STUN with Asterisk</title>
<meta name="description" content="AR1688 user need to disable STUN options with Asterisk system. It is difficult to test now, after FWD and SIPphone all discontinued their free SIP service.">
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
<tr><td class=THead><B>Disable STUN with Asterisk</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 3, 2011</td></tr>
<tr><td>Yesterday a Chinese <a href="../../../ar1688/user/ywh201.html">YWH201</a> user was complaining the phone not working with Freeiris2 system, the login was good but when dial a number, there was always a "wrong number" error.
Following our standard <a href="20070704.php">debug</a> steps, I asked him to update to the latest <a href="../../../ar1688/software/sw052.html">0.52</a> software and checked the phone settings, everything seemed ok.
Then I started to study Freeiris2 web and also search to find what others said about the system. Soon I found it was based on <a href="http://www.asterisk.org/" target=_blank>Asterisk</a>.
Now the answer was clear, for years we knew that we can not enable STUN on all <a href="../../../ar1688/index.html">AR1688</a> and <a href="../../../pa1688/index.html">PA1688</a> devices when working with Asterisk.
After disable STUN on the phone, everything got ok.
<br />We used to test STUN with free services like FWD(free world dialup) and <a href="../../../res/sipphone.html">SIPphone</a>(<a href="http://www.google.com/gizmo5/" target=_blank>Gizmo5</a>).
However, <a href="20071116.php">FWD</a> discontinued service in 2008, and Gizmo5 will also no longer be providing service starting on today. We need to find other good test service right now.
<br /><a href="http://www.gnutelephony.org" target=_blank>GNU Telephony</a> announced GNU Free Call plan last month. And we are also working actively on GNU SIP Witch in addition to our <a href="../../../pa6488/index.html">PA6488</a> SIP development.
But when I tried to see what is new just now, I found the web site inactive. What a bad day!
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
