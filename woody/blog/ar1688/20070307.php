<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>iLBC Codec Ready</title>
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
<tr><td class=THead><B>iLBC Codec Ready</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Mar 7, 2007</td></tr>
<tr><td>Finally we made it, after month by month promising, <a href="20070216.php">iLBC</a> codec is running correctly on AR1688 chip today. We will release 0.08 version of firmware after development clean up and internal testing. Hopefully we can put it on website this weekend.
<br />I was asked why we put iLBC ahead of G.729 in our development plan. The most important reason is that iLBC is royalty free. As <a href="../../../ar1688/index.html">AR1688</a> chip price does not including any royalty, it is manufacturer's responsibility to pay G.729 and G.723.1 codec royalty if user's is making use of those two famous ITU-T standard codecs. And in turn it will add to the price of the IP phone itself. Our AR1688 IP phone design goal is almost the same as IAX2 protocol itself, to make the terminal as simple as possible, so to create a good and easy to use IP phone with the cheapest price in the world, to compete the price of a normal PSTN phone. To pay various codec royalty is the last thing we like to see it happen. We will still keep working to provide G.729 and G.723.1 support in the near future, but will make it as an option, removable from standard firmware. And we will also add support for Speex, which is another royalty free codec.
<br />Of course that are other reasons to do iLBC first. G.729 is an 12 years old standard, it is originally designed for circuit switch system, to make more usage of the standard 64k pcm channel. G.729 does not consider IP network communication, while iLBC is the codec built for internet voice communication, iLBC will work better when there is IP packet lost.
<br />G.729 is used widely in trunking gateway today to exchange PSTN calls and IP calls. We fully realized this before we make decision because we know Cisco has also put iLBC support in their trunking gateway last year. However, we still received a lot of complaint about iLBC can not make call to PSTN. As a frequently <a href="20060929.php">upgrade</a> firmware developer, I certainly underestimated the difficulty of upgrade a cisco trunking gateway firmware.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
