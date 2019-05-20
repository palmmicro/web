<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Redial Key as Mute Key</title>
<meta name="description" content="Based on an user's software change on his 5111PHONE, we now use redial key as mute key in standard PA1688 software.">
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
<tr><td class=THead><B>Redial Key as Mute Key</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Feb 10, 2013</td></tr>
<tr><td>I received an email last month:
<br /><font color=grey>First, let me thank you for making the pa1688 source code available.
<br />I have a few 5111PHONE units, and they've been working quite well for nearly ten years. However, I have often wished that they had a mute button.
<br />I spend a lot of time on conference calls, and I like to put them on speaker while I half-listen. It is usually a good idea to mute the microphone for obvious reasons ...
<br />... so I have assigned a mute function to the redial button. It's not likely that I will need to redial the previous number while on a call, so it seemed the logical thing to do.
<br />Diff attached. I'd appreciate it if you were to incorporate some version of the patch into your repository, so that I won't have to manually patch the source when I update the firmware.
<br />Thanks again for making the source code free.
</font>
<br />I merged the changes happily and wondered why such a good idea was not implemented in the past 10 years.
Soon I found that in our standard <a href="../../../pa1688/user/pa168s.html">PA168S</a> software, <b>Service IP</b> key was used as <b>Mute</b> key, just in the same way.
<br />As <b>Redial</b> key is much more common, and usually occupies a better position, I applied the changes into <a href="../../../pa1688/software/sw169.html">1.69</a> software for all PA1688 phones. 
<br />Then I checked <a href="../../../ar1688/index.html">AR1688</a> phones, and found that each one had a separate <b>Mute</b> key. Obviously we had made some sort of progress when we design AR1688 solution 7 years ago!
<br />&nbsp;
<br /><font color=grey>The official picture of <a href="../../../pa1688/user/5111phone.html">5111PHONE</a> provided by 5111SOFT.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/5111phone/ib_302.jpg alt="The official picture of 5111PHONE provided by 5111SOFT." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
