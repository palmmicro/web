<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Debug FAQ</title>
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
<tr><td class=THead><B>Debug FAQ</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>July 4, 2007</td></tr>
<tr><td>We are ready to support customers in many ways, including phone, MSN and email. Phone calls work well as long as it is made in Chinese. But most of us speak English not as good as American or Indians. 
I got a few calls from India yesterday, more than half of the time I was guessing what the other side is talking about, and the other half time, I guess the other side was guessing what was my idea too! 
I like MSN because I grow up with Microsoft software, but I can see many others hate M$ every time my suggestion of using MSN is turned down. 
How lucky we are, still have email as an effective communication tool, please feel free to send <a href="mailto:support@palmmicro.com">email</a> as much as possible.
<br />Please include the following in all debug email request:
<br />1. <a href="20061014.php">Hardware type</a>, like <a href="../../../ar1688/user/gp1266.html">GP1260/1266</a> from Digitmat, <a href="../../../ar1688/user/gf302.html">GF302</a> from High-link, <a href="../../../ar1688/user/ywh201.html">YWH201</a>/601 from Yuxin
<br />2. Software version, we have 0.16 as most recent steady version at present
<br />3. Protocol, SIP or IAX2
<br />4. <a href="20070405.php">Language</a>, cn, us, fr, it and many others
<br />5. OEM tag, if the phone has an OEM tag
<br />6. Phone settings in .html format. Users can use their internet browser's "Save As" function to save web settings into a .html file. The file saved may not be able to view in whole by web browser because of security reason, but we can read it in html edit tools like Microsoft Word
<br />7. Detail problem description and best with test accounts for us to repeat the problem
<br />8. Other software and hardware used in the test. Please send us any software used in test as possible to help us repeat the problem
<br />9. Ethernet packet captured in any format
<br />10. <a href="../../../pa1688/software/palmtool.html">PalmTool</a> debug message output. Must enable <a href="../../../ar1688/index.html">AR1688</a> setting's debug option. Send to us in plain text. 
<br />11. In some special case, we will request users to run the following command and sent the files page0.dat and page1.dat to us:
<br /> tftp -i xxx.xxx.xxx.xxx get page0.dat
<br /> tftp -i xxx.xxx.xxx.xxx get page1.dat
<br /> 
<br />Firmware 0.16 Debug FAQ:
<br />1. No audio in call: Check CODEC options and make sure G.723.1 and Speex are not selected
<br />2. No outgoing audio in call:
<br /> a. Check RTP port setting to be none-zero, change protocol from <a href="20060929.php">IAX2</a> to SIP will set RTP port to 0
<br /> b. Check "Frames per TX" value between 1-7
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 11, 2008</font>
<br />PalmTool is not used for debug since <a href="20080811.php">0.37</a>, use SDCC\bin\manager.exe instead.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
