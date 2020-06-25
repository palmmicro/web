<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Name Rules</title>
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
<tr><td class=THead><B>Name Rules</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>June 7, 2008</td></tr>
<tr><td>A typical upgrade file name for <a href="../../../ar1688/index.html">AR1688</a> device looks like xxxxxxxxxxxxxxx_yyyy_zz_vvvvvv.bin. In some special cases, it may be like xxxxxxxxxxxxxxx_yyyy_zz_ooooooooooooooo_vvvvvv.bin. Different part between under score '_' has different meanings.
<br />xxxxxxxxxxxxxxx: This is the hardware type, or "<a href="20061014.php">Board Name</a>" as we call it. Although based on the almost same AR1688 chip, different manufacturer has different hardware board designs, which need different software. It is true that we can do hardware detection like most PC software does, and help all different hardware boards to use the same software. However, it will be a considerable waste of code and memory spaces of the resource limited low-cost AR1688 system. Usually "AR168X" hardware type is used for standard designs for everyone. In most cases every manufacturer will likely to pick up their own hardware types because of products difference. For example, Digitmat choose "<a href="../../../ar1688/user/gp1266.html">GP1266</a>" and "GP2266" board names for their IP phones. Hardware type can be as long as 15 combination of characters and numbers. Like other parts of the file name, hardware type is NOT case sensitive, and can NOT use under score inside it. For example, "BT_2008" name need to be changed to "BT2008N", and "DX_DT" name need to be changed to "DXDT".
<br />yyyy: This is the protocol type. It is limited to 4 bytes, for example "<a href="20060929.php">SIP</a>" or "<a href="20071110.php">IAX2</a>". The string "none" is used as the indication of safe mode upgrade file, which is only 64k bytes. The size is much less than normal upgrade files.
<br />zz: This is the <a href="20070405.php">resource</a> type. It is limited to 2 bytes, for example "cn" for Chinese and "fr" for French. We are following ISO 3166 for country code. The obvious problem is that we did not consider the case of a country using multiple languages from the beginning. So it will be a little tricky for a French speaking Canadian to compile a Canada French version for IP phone.
<br />ooooooooooooooo: This is OEM type, all the name rules are the same as hardware type. Again, do NOT use under score in OEM names. OEM type is used when same hardware type product is used for different OEM customers. Special settings and feature implementations can then be included into different software binaries. We also use different OEM names for different testing purposes in our development stage.
<br />vvvvvv: This is the version part. It is always 6 numbers. The first 3 numbers are major version, and the last 3 numbers are minor version. For example, 033007 stands for 0.33 version 007 build. We will use even major version number for official release, and make minor version number all zero. As an example, 032000 is the most recent software release.
<br />We started to use those name rules a few years ago following OBWAN's advice. He was an active <a href="../../../pa1688/index.html">PA1688</a> user at that time. We are keep learning from all customers and partners, please send us your advice today!
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
