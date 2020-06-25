<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR168M VoIP Module High Level UI Protocols</title>
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
<tr><td class=THead><B>AR168M VoIP Module High Level UI Protocols</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 29, 2008</td></tr>
<tr><td>With the release of recent 0.30 software, our <a href="../../../ar1688/module.html">AR168M</a> VoIP Module is fully ready in both hardware and software. We can ship it in small quantity now.
<br />To test the <a href="20080225.php">module</a>, we have used an external 8051 controller to work with the module to build a complete IP phone reference design.
The 8051 hardware schematics is available with all other standard <a href="../../../ar1688/index.html">AR1688</a> hardware designs.
And the software is open source too, located in SDCC\mcs51, and is also compiled with SDCC.
Software <a href="20061211.php">API</a> users can use the same SDCC\bin\sdcc.exe to compile both the AR1688 software and 8051 software.
<br />To complete the 8051 based IP phone reference design, we have to define high level <a href="../../../ar1688/software/devguide/uiprotocol.html">UI protocols</a> over the original <a href="20071119.php">UART</a> implementations.
The well organized 8051 source code is a good point to start with this article, most of the detail UI handling is located in SDCC\mcs51\ui.c.
<br />Welcome to comment and make changes, we are open for all suggestions.
<br />&nbsp;
<br /><font color=magenta>Updated on Dec 18, 2011</font>
<br />Although our VoIP module UI protocols were just for demo purpose at the beginning, they are actually being used in multiple real products now.
Last week a Chinese user asked us to add a "logon ok" status indication by UART. He told us that he only used the standard AR168M software.
So I added status report command STAT in our demo protocols yesterday.
<br />&nbsp;
<br /><font color=magenta>Updated on Sep 12, 2012</font>
<br />Recently we received a customer's request to add text exchanging function in our <a href="../../../ar1688/roip.html">RoIP</a> software.
So we added the 7th "TEXT" command in our demo protocols.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
