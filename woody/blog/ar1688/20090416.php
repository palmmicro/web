<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Voice Activity Detection</title>
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
<tr><td class=THead><B>Voice Activity Detection</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 16, 2009</td></tr>
<tr><td>The concept of VAD is widely accepted after ITU G.729B and G.723.1 included it as part of the voice encode and decode algorithm. Cisco had used the idea a little earlier before the G.729B standard. In Cisco systems, voice is first sent to a pre-process VAD system before passing to standard voice codec like G.711 and G.729. The open source <a href="20071031.php">Speex</a> works in the Cisco way, its VAD part is actually independent of Speex codec itself.
<br />Now it is more than 13 years after the publish of G.729B and G.723.1. We gradually find that VAD is less and less useful in today's IP phone. We do not need it to save <a href="20071110.php">bandwidth</a> any more. And we care much less of the power consumption it can possibly save too. Instead, none codec related VAD algorithm can always have bad effect on voice quality and network jitter buffer handling. There is no reason to keep a VAD option in the phone if G.723.1 and G.729B is not used.
<br />Actually we are not alone. GIPS has not included a VAD part in its open source <a href="20070307.php">iLBC</a> internet voice codec. And VAD is also not a part in GIPS' VoiceEngine product neither. What important today is AGC, AEC and PLC with dynamic jitter buffer handling.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
