<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Digit Maps</title>
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
<tr><td class=THead><B>Digit Maps</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Mar 21, 2007</td></tr>
<tr><td>We used to support 7 different communication protocols in <a href="../../../pa1688/index.html">PA1688</a>. Many of them never bring in serious revenues. MGCP is among one of those losers. However, the work on MGCP has lead to function for other protocols. SIP and IAX2 are protocols currently supported in <a href="../../../ar1688/index.html">AR1688</a>, both have digit maps functions supported similar with MGCP.
<br />In RFC 3435 section 2.1.5, there is detail digit maps explanations. Digit maps are used to decide when user on the phone has finished dialing by matching rules defined in digit maps. In MGCP case, digit maps in IP phone are from server messages.
In our implementation of SIP and <a href="20060929.php">IAX2</a>, digit maps are stored together with settings, pre-defined by user or system, and can be automatically updated with settings in auto provision.
<br />From our <a href="20061211.php">API</a>, using "sdcc\bin\getopt.bat xxx.xxx.xxx.xxx", options.txt will pop up, with 2 different section of [settings] and [digitmap]. Digit maps are listed under [digitmap]. User can also use internet browser to view and modify digit maps by simply visiting the ip address of IP phone.
<br /><a href="../../../res/sipphone.html">SipPhone</a> is one of my most frequently tested sites. Part of test number below:
<br />**: Hear your SIPphone number repeated back to you.
<br />*0: Test your router's SIP compatibility.
<br />411: The voice activated Tellme information service.
<br />1-747-474-ECHO(1-747-474-3246): Echo Test - Repeats back whatever you say.
<br />1-747-474-5000: SIPphone welcome recording
<br />1-747-XXX-XXXX: Call any SIPphone user
<br />The corresponding digit maps for those numbers are:
<br />*x: for ** and *0.
<br />4xx: for 411.
<br />1xxxxxxxxxx: for 1-xxx-xxx-xxxx number.
<br />x.T: for other numbers.
<br />If digit maps are not used, user must press "call" key after finished dialing, just as with a mobile phone. In the early days of VoIP, many software and hardware device use '#' key for dial out. As VoIP is merging with PSTN today, because # key is heavily used in PSTN system supplementary services, it is not a good idea to use # key for "call" function any more.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
