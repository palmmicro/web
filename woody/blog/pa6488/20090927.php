<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>From PA1688 to PA6488 - Safe Mode Recovery</title>
<meta name="description" content="Palmmicro products have safe mode recovery. If the device can not boot due to wrong software update, user can restore the correct software in safe mode.">
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
<tr><td class=THead><B>From PA1688 to PA6488 - Safe Mode Recovery</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Sep 27, 2009</td></tr>
<tr><td>The software upgrade for <a href="../../../pa1688/index.html">PA1688</a> devices took about 1 minute, and if power supply failed during upgrade, the devices would fail to work again.
To prevent hardware failure, we designed safe mode recovery. The software was separated in 2 parts. PA1688 would always boot from safe mode part. If * key was detected during boot up, it would stay in safe mode,
otherwise it would continue to run in the normal part software. Safe mode part of software was small, so it would take much less time to upgrade, and the chances of power supply failed would be much less too.
What is more, safe mode part of software was designed to be unnecessary to change by end users. When end users had problem with normal part software upgrade,
they could always enter safe mode and change back to what was normal.
<br />Once safe mode usage was started, we found it was especially useful in software development. We no longer worry about bad codes break the whole system as long as safe mode is there.
<br />Because of 8051 64k code limitation, special software like factory test codes were added into safe mode part of software, which did not use code bank switching.
The normal part of software need bank switching to support larger software, and there were overhead for code bank switching.
<br />In all PA1688 devices, the safe mode IP is 192.168.1.100 and MAC is 00-09-45-00-00-00. Because SDRAM data sometimes will not lost completely during short power down time,
users need to press and hold * key to power up 2 times to make sure to use the default IP and MAC.
For all PA1688 based gateways, there is a special safe mode key on the device working to be pressed and hold to enter safe mode, press * key on external PSTN phone will not work.
<br />With <a href="../../../ar1688/index.html">AR1688</a> the safe mode IP is 192.168.1.200 and <a href="../ar1688/20070827.php">MAC</a> is 00-18-1f-00-00-00.  Users only need to press and hold * key to boot 1 time to get the default IP and MAC.
Gradually we feel it is stupid to press and hold * key, as we are mostly dealing with IP phones, why not make use of the hook?
As a result, later version of AR1688 IP phones will enter and stay in <a href="../ar1688/20080624.php">safe mode</a> when hook is up, and only enter normal part of software when hook is down.
AR168M VoIP module has jumper to judge safe mode, the jumper uses the same GPIO as the hook on IP phones.
As AR1688's Z80 controller also need code bank switching, we still put factory test codes in safe mode part of software to reduce bank switching overhead.
<br />We still use 192.168.1.200 and 00-18-1f-00-00-00 as safe mode IP and MAC for <a href="../../../pa6488/index.html">PA6488</a>. And we are keeping the hook part too.
All PA6488 device will enter and stay in safe mode when power up with hook up. For PA648C analog video module which has no hook, we also put the same GPIO as a jumper.
As we finally get rid of code bank switching, we no longer put factory test codes in safe mode any more. In fact, to reduce safe mode code size, even LCD support is moved out of safe mode software.
<br />&nbsp;
<br /><font color=gray>The only 'IP' key in this <a href="../../../pa1688/user/ag168v.html">AG168V</a> back view is the key to enter the safemode of a PA1688 gateway.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/g1681/back.jpg alt="Soyo G1681 (PA168V/AG-168V) 1-port FXS gateway back view." /></td></tr>
<tr><td>
<br />&nbsp;
<br /><font color=magenta>Updated on Nov 29, 2009</font>
<br />In both AR1688 and PA1688 safe mode, #9*0 key sequence will reboot the device and leave safe mode.
As our recent changes in AR1688 and PA6488 have selected <b>hook up</b> as indication to enter safe mode while powering up,
it is natural for us to go further with the hook. When <b>hook down</b> in safe mode, AR1688 and PA6488 will reboot and leave safe mode.
<br />With this new safe mode feature, however, it may confuse old AR1688 users pressing and holding * key to enter safe mode. If the hook is down, the phone will enter safe mode and soon reboot itself and leave.
Users need to remember to keep hook up all the time if they hope to stay in safe mode.
<br />Unlike PA1688, both AR1688 and PA6488 safe mode files can not be compiled from their <a href="../ar1688/20061211.php">software API</a>. AR1688 users like to test the new feature need to request new safe mode files from us by email.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
