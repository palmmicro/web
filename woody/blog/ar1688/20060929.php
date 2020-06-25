<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Firmware Upgrade</title>
<meta name="description" content="Because of standard changes, firmware upgrade is perhaps the most important feature of an IP phone. We are using TFTP for AR1688.">
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
<tr><td class=THead><B>Firmware Upgrade</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Sep 29, 2006</td></tr>
<tr><td>What is the most important feature of an IP phone today? My answer is, upgrade feature. Why? Because Voice over IP is changing all the time and changing quickly!
H.323 is too old and not NAT friendly. MGCP is the result of telco and conflicting with internet spirit. OK, what happens to internet native SIP and open source driven IAX2?
They both lost to private protocol based Skype shamefully. So if your IP phone can not upgrade easily, how long can you expect it to last?
<br />What we have first done on <a href="../../../ar1688/index.html">AR1688</a> is the upgrade feature,
it has all old PA1688 good upgrade features and we have tried to elimilate as much of the bad PA1688 upgrade features as well.
<br />1) Whenever IP phone failed, press * key can enter safe mode. In safe mode, user can use native method to upgrade the phone again.
PA1688 need to be powered twice with * key pressed to enter 192.168.1.100 ip address. AR1688 only need to be powered once with * key pressed to enter 192.168.1.200.
Why not also 100? Because we are hoping to avoid a PA1688 and an AR1688 into safe mode at the same time.
<br />2) The possibility of phone failed is much less with AR1688. Unlike PA1688, the phone will not get failed even when power lost during upgrade process.
We have used difference program flash space for the currently running program and the currently writing new firmware.
<br />3) The native method to upgrade changed from private protocol <a href="../../../pa1688/software/palmtool.html">PalmTool</a> to TFTP.
We have been asked too many times for Linux version PalmTool in the past years. Sure Linux user will not need TFTP client program from us.
With Windows envionment, the command line for upgrade is like: <font color=gray>tftp -i xxx.xxx.xxx.xxx put ar168e_sip_cn_000543.bin</font>
<br />4) Yes, the file name used the same format as <a href="../../../pa1688/index.html">PA1688</a>,
above file name means to upgrade an AR168E IP phone with SIP protocol, Chinese resource, and 0.00.543 firmware, the current stable demo version.
<br />5) The native upgrade speed is much more faster. With PA1688, PalmTool need 68 seconds to upgrade the 960k bytes upgrade file.
With AR1688, TFTP only takes 16 seconds to upgrade the 640k bytes upgrade file.
<br />6) HTTP upgrade are available on both chips, the upgrade speed improvement is even more significent.
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 3, 2014</font>
<br />Yves pointed out that:
<br /><b>Unix (Linux, MacOSX, Solaris or any BSD) users , take care to make a TFTP Binary mode transfert, ex under linux: tftp xxx.xxx.xxx.xxx -m binary -c put ar168e_sip_cn_000543.bin</b>
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
