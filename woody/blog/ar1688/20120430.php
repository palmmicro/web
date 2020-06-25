<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Sending PTT via RFC 2833</title>
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
<tr><td class=THead><B>Sending PTT via RFC 2833</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 30, 2012</td></tr>
<tr><td>Radio over IP was one of the most heavily used application of <a href="../../../ar1688/module.html">AR168M</a> VoIP module. It was so popular that we eventually decided to build an <a href="../../../ar1688/roip.html">AR168R</a> RoIP module last year.
<br />Having a strong desire to do everything in a <a href="20080811.php">standard</a> way, I was hesitating to choose the way to send COR/PTT signals. I hate to use a separate <a href="20110331.php">UDP/TCP</a> channel, as some of our customers did.
RFC 4354 for Push-to-Talk over Cellular (PoC) Service seems to be the most close in existing SIP protocols, but I can not find an actual way to test the interoperability, and I really doubt who will follow poor old Nokia now.
Somebody used RTCP, which was never implemented in <a href="../../../ar1688/index.html">AR1688</a> software. And somebody used RTP with a special SDP negotiation. All seems to me as strange behavior.
<br />But yesterday all of a sudden I realized that what I need to send is just key information: I hold a key to talk, and release the key after talking. Why not just use existing RFC 2833 software to send it as DTMF key?
Even when AR168R working with other SIP terminal, the other side will just understand that a key was pressed and nothing else special.
<br />Based on this simple thought, I defined KEY_COR_HIGH and KEY_COR_LOW in <b>ar168r.c</b>, when PTT is pressed, I send out KEY_COR_LOW to announce I am going to talk, and when PTT is released, I send out KEY_COR_HIGH to indicate speech finished.
<br />&nbsp;
<br /><font color=magenta>Update on Sep 19, 2013</font>
<br />Test with Asterisk MeetMe showed that PTT information via RFC 2833 was lost in the conference. 
We changed the way to exchange COR/PTT singals via <a href="20080512.php">SIP MESSAGE</a> text "COR HIGH" and "COR LOW" in <a href="../../../ar1688/software/sw063.html">0.63</a> software.
<br />&nbsp;
<br /><font color=magenta>Update on Jun 25, 2014</font>
<br />Added <b><i>OEM_JOSN</i></b> compile option to keep using RFC 2833 for RoIP COR/PTT signals exchange method.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
