<?php require("../../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Using Standard SIP Protocol</title>
<meta name="description" content="Working with Asterisk, X-Lite and IMSDroid using standard SIP protocol">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa6488.js"></script>
<script src="../software.js"></script>
<script src="userguide.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateUserGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>Working with Asterisk, X-Lite and IMSDroid using standard SIP protocol</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>1 Install and setup Asterisk</B></td></tr>
<tr><td>1.1	Install linux
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">Install <a href="http://www.virtualbox.org/wiki/Downloads" target=_blank>VirtualBox</a>.
<br />Install <a href="http://www.ubuntu.com/download/ubuntu/download" target=_blank>ubuntu</a>. The install process is pretty simple. All you have to set is the password of login account(default:adminnstrator). The others can be left as default. 
<br /><img src="files/ubuntu1.jpg" alt="ubuntu">
</p></td></tr>

<tr><td>1.2	Install asterisk</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">After Linux booting, login with account and password which set during installation, switch to commond line interface and input the following command to start the asterisk system installation process:
<br /><i>sudo apt-get install asterisk</i>
<br />During installtion, you may need to set the ITU-T Telehone code. Please input "86" for user in China mainland.
</p></td></tr>
<tr><td>1.3	Cinfigure asterisk</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">
All the configuration files are located at directory: /etc/asterisk. Proper backup is suggested befor any modification.
<br />
<br />Step 1: Configure sip. The sip configuration information is in the file of sip.conf. You can modify based on the original sip.conf, or you can creat your own sip.conf. Below is a very simple example of sip.conf, which set up 3 account numbers(6001-6003), supporting both audio and video communication.
<br /><img src="files/sipconf.jpg" alt="sip config">
<br />
<br />Step 2: Configure dialplan. Add the following contents in the extensions.conf:
<br /><img src="files/dialplan.jpg" alt="dialplan">
<br />
<br />Step 3: Reload sip and dialplan.
<br />Run the following command to switch to the asterisk command line interface(CLI>):
<br /><i>sudo asterisk –r</i>
<br />
<br />Reload sip and dialplan at astersik CLI: 
<br /><i>CLI> sip reload</i>
<br /><i>CLI> dialplan reload</i>
<br />Notice: Always to reload the corresponding system after modifing their configuration.
<br />
<br />Asterisk is now ready. You can configure sip terminals properly for audio or video communication now.
</p></td></tr>


<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>2 Install and setup IMSDroid</B></td></tr>
<tr><td>2.1 Overview</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">IMSDroid is the first fully featured open source 3GPP IMS Client for Android devices (1.5 and later). The main purpose of the project is to exhibit doubango's features and to offer an IMS client to the open source community. doubango is an experimental, open source, 3GPP IMS/LTE framework for both embedded (Android, Windows Mobile, Symbian, iPhone, iPad, ...) and desktop systems (Windows XP/Vista/7, MAC OS X, Linux, ...) and is written in ANSI-C to ease portability. The framework has been carefully designed to efficiently work on embedded systems with limited memory and low computing power. For more information, please visit <A HREF=http://code.google.com/p/imsdroid/>"IMSDroid"</A>.</p></td></tr>
<tr><td>2.2 Installation</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">Download installation packet <A HREF=http://code.google.com/p/imsdroid/downloads/list>"here"</A>, and install the sofrware to your Android device. After installation, you can find a "IMSDroid" icon simillar to<img src="files/imsdroidicon.jpg" alt="IMSdroid icon"> at application interface.
<br />Notice: You can try different versions if you have any problem.
</p></td></tr>
<tr><td>2.2 Configuration</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">Click icon"IMSDroid" to enter IMSDroid home page as follows: 
<br /><img src="files/imshome.png" alt="home">
<br />Click icon"Options", then icon "Identity" at home page, you can find the identity configuration page as follows. The contents in the black color are actual settings, while the contents in blue collor are comments. Please go back to home page after finishing the settings.
<br /><img src="files/imsidentity.png" alt="identity">
<br />Click icon "Options", then icon"Network" will enter network configuration page as follows. Please set according your network environment. Go back to home page after settings.
<br /><img src="files/imsnetwork.png" alt="network">
<br />Click icon"Options" then "Codecs", you will enter codec configuration page. choice all the codec options you will use. Go back home page when finished.
<br /><img src="files/imscodec.png" alt="codec">
<br />Click icon"Sign in" to login server. You will find seven more icons at home page if login successfully. 
<br /><img src="files/imshomesignin.png" alt="signin">
</p></td></tr>
<tr><td>2.3 Start a call</td></tr>
<tr><td><p dir="ltr" style="margin-left: 20px; margin-right: 0px">Click icon "Dialer" at home page, you will find the interface as follows. Please input callee number, and click the audio or video icon to start an audio or video call.
<br /><img src="files/imscall.png" alt="call">
</p>
</td></tr>


<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>

