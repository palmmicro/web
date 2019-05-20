<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688 Programming Lesson 101</title>
<meta name="description" content="AR1688 programming lession 101: how to change display string, add a c source file, add G.729 IVR support.">
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
<tr><td class=THead><B>AR1688 Programming Lesson 101</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 31, 2011</td></tr>
<tr><td>I know it is too late to write AR1688 lesson 101 after it is in market over 4 years. But late is better than never. 
Every now and then there are people asking <font color=grey>How can I change that <a href="20070903.php">GP1266</a> LCD display to my own string</font>?
I started this article because I read an email asking it again just now.
<br />Actually this article is to be very short. In software <a href="../pa6488/20090811.php">API</a> sdcc\src\<B>ui_str.c</B>, there is a <i>LoadString</i> function,
and there are already several <a href="../pa6488/20090816.php">OEM_XXXX</a> changes made to display different strings. 
<br />Change <i>LoadString</i> will not only change the LCD display, but will change SIP <b>User-Agent</b> head as well.
<br />&nbsp;
</td></tr>

<tr><td class=Update>Update on Jan 7, 2012</td></tr>
<tr><td>Many users need to add their own UDP or <a href="../../../ar1688/faq.html#tcp">TCP</a> connection.
Each connection implementation is in a separate file with AR1688 software. This lesson is about how to add a file to AR1688 software <a href="20061211.php">API</a>. Detail steps:
<ol>
  <li>Decide which <a href="20080706.php">bank</a> the new file is going to be located. We recommend to put TCP connection in bank 3 and UDP in bank 2.</li>
  <li>Modify the two .c file related locations in sdcc\src\<a href="20070609.php">makefile</a>.</li>
  <li>Add the new .rel file to sdcc\src\<b>linkmain.lnk</b>. Do NOT put it in the end of the file, MUST put it together with other .rel files in the same bank,
      otherwise compile message like <font color=red>Error: banked code exceeded bank 7 end (default 0xe000)</font> will occur. Or worse, the error message do not occur but we get wrong link results.</li>
  <li>Do NOT do any global var initialization like <font color=grey>UDP_SOCKET _pTestSocket = NULL;</font> in the new file (and do NOT add any in old files as well),
      do var initialization in functions like <i>SntpInit</i>. Otherwise compile message like <font color=red>Error: sram code exceeded code end (default 0x2000)</font> will occur.
      <a href="20101123.php">SDCC</a> can not put the initialization code in (correct) address we need with our banked software structure.</li>
</ol>
<br />&nbsp;
</td></tr>

<tr><td class=Update>Update on Feb 26, 2012</td></tr>
<tr><td>PCMU <a href="20110307.php">IVR</a> was designed to read out IP address, providing an easy way to know the IP of an AR1688 device when LCD is not used.
In recent months there were increasing interest of adding interactive voice response during a call according to what kind of key user pressed among <a href="../../../ar1688/module.html">AR168M</a> VoIP module customers.
And one of them was actively developing <a href="../pa6488/20101213.php">G.729</a> IVR function during the past week. The contents of this lesson were generated along with the supporting work for this customer.
<br />First we need to prepare compressed G.729 data, this work can be done by <a href="../../../pa1688/software/palmtool.html">PalmTool</a>,
and the complete source code of PalmTool can be found in PA1688 software API, the latest version was <a href="../../../pa1688/software/sw168.html">1.68</a>.
The G.729 source code used in PalmTool was downloaded from <a href="http://www.itu.int/ITU-T/" target=_blank>ITU-T</a>.
<br />In the demo code of software <a href="../../../ar1688/software/sw057.html">0.57</a>.006, we used a simple way to get G.729 compressed data.
PA1688 <a href="../../../pa1688/ring.html">ring tone</a> is the combination of G.723.1 and G.729 compressed data, the first 2/5 is G.723.1 and the rest 3/5 is in G.729 format.
I downloaded PA1688 ring tone <b>alice.dat</b>, renamed it to <b>font_alice.dat</b> and saved it to sdcc\src\res.
<br />Next we need to save the G.729 data to flash. Same as PCMU, we still use the <a href="20070605.php">font page</a> of 8-11.
To make things simple, now we support command line like <font color=grey>tftp -i xxx.xxx.xxx.xxx put font_alice.dat</font> to upgrade font and IVR directly.
<br />Then we need to read the G.729 data and send to peer during a call. As the data is stored on flash, the code to read it needs to run on <a href="20080706.php">SRAM</a> instead of flash,
<B>main.c</B> is a good choice for it. We also need an easy way to send the data periodically, as <i>TaskOutgoingData</i> function in <B>main.c</B> is usually called by DSP at regular intervals,
it is a good point to replace the DSP compressed G.729 data with our data read from flash. The demo code is grouped with <B><i>SYS_IVR_G729</i></B> define,
which is included when compile with newly added <B><i>OEM_IVRG729</i></B> or existing <a href="20120213.php">OEM_ROIP</a> options.
<br />Finally I have to say that the demo code still need a lot more improvement before it can be actually used in a real product.
For example, need to check if current using CODEC is G.729 or not before we replace data.
And with RoIP application when <a href="20090416.php">VAD</a> is used, <i>TaskOutgoingData</i> may not be called because of no voice activity,
and the send data work will need to be done in <i>_10msCounter</i> function in <B>isr_gpio.c</B>. Also more banking access code is needed when total G.729 data is over 32k bytes. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
