<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>How to Change MAC Address</title>
<meta name="description" content="The detail steps of how to change the MAC address of AR1688 device. It is designed to be complicated on purpose.">
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
<tr><td class=THead><B>How to Change MAC Address</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 27, 2007</td></tr>
<tr><td>The MAC address of PA1688 based device can be easily changed by <a href="../../../pa1688/software/palmtool.html">PalmTool</a>,
and we spent a lot of technical support effort to help manufacturers and end users to get rid of the duplicated MAC problem. 
When we began to design AR1688 software, we tried to avoid the problem from the beginning, the MAC address is not allowed to be changed in most situations. 
But still there is request of MAC address changing request that we feel not easy to refuse, the result is this guide.
<br />However, this is not a simple guide, and you must be an advanced user to follow this guide. If you do not know how to upgrade by TFTP, do not know how to enter safe mode, or do not know what MAC address is,
you can skip the rest.
<ol>
  <li>Make sure you have most recent AR1688 <a href="20061211.php">API</a> in hand, feel free to write <a href="mailto:support@palmmicro.com">email</a> to us for a copy if you do not have it.</li>
  <li>Also write to us saying that you need special firmware to change your MAC address.
      Please provide information like <a href="20061014.php">hardware type</a>, protocol and <a href="20070405.php">language</a> for us to send you the correct firmware.</li>
  <li>Press * while power up to set your <a href="../../../ar1688/index.html">AR1688</a> IP phone into safe mode.</li>
  <li>Use the command line tool in API SDCC\bin, <i>getopt 192.168.1.200</i>, when it finishes, an <b>options.txt</b> file will pop up.</li>
  <li>In <b>options.txt</b>, find the line like <i><b>mac_address=0x00,0x18,0x1f,0x10,0xa0,0xb8</b></i>, change whatever MAC address you like to use.</li>
  <li>Save <b>options.txt</b>, use <i>setopt 192.168.1.200</i>, the phone will reboot after change.</li>
  <li>In normal mode, use command line to upgrade the special firmware we sent in email, usually like <i>tftp -i xxx.xxx.xxx.xxx put ar168f_sip_us_mac_017037.bin</i>. The file is 640k in size.</li>
  <li>In normal mode, use command line to upgrade the safe mode firmware we sent in email, usually like <i>tftp -i xxx.xxx.xxx.xxx put ar168f_none_us_017037.bin</i>, the file is 64k in size.</li>
</ol>
<br />After those steps, you can use and upgrade normal firmware in the future with MAC address changed.
<br />&nbsp;
<br /><font color=grey>A typical PA1688 00-09-45 MAC address on an Infineon 21553 IP phone.</font>
</td></tr>
<tr><td><img src=../../../pa1688/user/jr168/2s.jpg alt="A typical PA1688 00-09-45 MAC address on an Infineon 21553 IP phone." /></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td class=Update>Updated on Nov 29, 2009</td></tr>
<tr><td>Keep hook up when enter and while in safe mode because newer software will leave <a href="../pa6488/20090927.php">safe mode</a> when hook down.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
