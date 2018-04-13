<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>The Logical Steps to Rescue a PA168Q</title>
<meta name="keywords" content="PA168Q Rescue">
<meta name="description" content="How to rescue a second-hand PA168Q. Hopefully this can help some impatient new users of Palmmicro old products.">
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
<tr><td class=THead><B>The Logical Steps to Rescue a PA168Q</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 14, 2011</td></tr>
<tr><td>After several casual emails with a new user who had a second-hand dead <a href="../../../pa1688/user/pa168q.html">PA168Q</a> last week, he finally wrote:
<font color=grey>Where is the start point and the end point? How am I supposed to find my way in all these links?? Which one is relevant to my case and which is not?
Then, How to send the bin file to the device. I appreciate the help, but it needs to be logical.</font>
<br />I felt frustrated of my PA1688 web work at first, then I realized there must be other new users with second-hand PA1688 devices feeling the same like him.
According to Google <a href="../entertainment/20101107.php">Analytics</a>, the new visitors percentage in our web site rose from 61.01% to 74.07% in the past 5 months (see image below).
<br />If I were new to PA1688, maybe the logical steps should be:
<br />1. Find a Windows PC, connect PC and PA168Q to a same local network which has DHCP server as 192.168.1.1, and make sure 192.168.1.100 IP address is not used.
<br />2. Download the software API and PA168Q upgrade file, current release version is <a href="../../../pa1688/software/sw166.html">1.66</a>.
Decompress software API package to C:\Palmh323 and PA168Q upgrade file <b>pa168q_sip_us_166000.bin</b> to C:\Palmh323\bin.
<br />3. Run <a href="../../../pa1688/software/palmtool.html">PalmTool</a> from C:\Palmh323\bin, click <font color=blue>Start Debug</font> button to start UDP debug output window,
fill 192.168.1.100 to <font color=blue>IP Address in Chip</font> control.
<br />4. Press and hold the only key on PA168Q while power up, do it at least twice until it enters <a href="../pa6488/20090927.php">safe mode</a>.
After entering safe mode, depending on software version, there might be different output in the debug window, and PC can ping PA168Q at 192.168.1.100 with <a href="../palmmicro/20091114.php">MAC</a> address 00-09-45-00-00-00.
<br />5. Use PalmTool to upgrade from safe mode, click <font color=blue>Update Program</font> and select <b>pa168q_sip_us_166000.bin</b>.
<br />After the above steps, PA168Q will reboot. If we are lucky, it might working now. Pick up the handset of the PSTN phone which connected to PA168Q, press the only key on PA168Q, the IP address will be played out in the handset speaker.
<br />There is a known caller ID problem with PA168Q and all other PA1688 based gateway using outside China, perhaps the <a href="http://web.textfiles.com/phreak/caller-id.txt" target=_blank>CID</a> function only work with Chinese standard.
We are unable to fix this and all other DSP related problems because we have no PA1688 DSP developer now.
</td></tr>
<tr><td><img src=../photo/20110814.jpg alt="Palmmicro.com visitor overview from Google Analytics on Aug 12, 2011.0" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
