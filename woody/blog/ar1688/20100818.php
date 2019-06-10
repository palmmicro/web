<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>AR1688 Windows Tools Compiled with VC2008</title>
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
<tr><td class=THead><B>AR1688 Windows Tools Compiled with VC2008</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Aug 18, 2010</td></tr>
<tr><td>I replaced my 3.5 year old Sony PCG-K23 with current Sony VGN-FW235J 20 months ago,
but I still kept the old system updated as I need <a href="../entertainment/20100529.php">Visual C++</a> 6.0 to compile AR1688 and <a href="../../../pa1688/index.html">PA1688</a> Windows tools.
During the period the MS automatic updating had successfully made it slow enough even when running VC6 as the only application, I had to switch AR1688 tools to compile with VC2008 finally. 
<br>After I started the work, I found that someone else had already done the switch before, all tools can be compiled successfully with multi-byte character set, but most obviously Manager.exe debug output becomes strange on my 64-bit Vista system.
<br>I decided to compile everything with the new default unicode option. This task took much more time than I expected. The mixed using of memcpy/strcmp and CString caused a lot of problems in unicode. 
<br>The test result looks ok so far. The most interesting part is, all of the command line tools like hex2bin.exe are about 30% smaller than before with multi-byte compile, and reduced 10% more in size with unicode. GUI based Manager.exe is also a little smaller than before. And the total zipped software API package reduced about 10% in size, from 2.4M bytes to 2.2M bytes.
<br>I tried to upgrade <a href="20090329.php">SDCC 2.9.0</a> from VC6 to VC2008 in the next step, but after several hours I gave up. It ends with a mess, neither multi-byte nor unicode configuration can compile it successfully. We can only use VC6 compiled SDCC at this time, fortunately we do not have to change it frequently. We would have to use mingw and gcc to compile SDCC 3.0.0 when it is ready in the near future.
<br>We are announcing 0.47.021 as <a href="../../../ar1688/index.html">AR1688</a> 0.48 software release candidate 1, the API can now be <a href="../../../ar1688/software/snapshot.html">downloaded</a> from our website. The <a href="../../../ar1688/software/sw048.html">0.48</a> version is scheduled to release on Oct 1.
<br>As those AR1688 tools are now compiled with Microsoft Visual Studio 2008 (VC9) and Windows SDK v7.1, users might need to download and install related VC9 redistributable package from <a href="http://www.microsoft.com/downloads/details.aspx?FamilyID=9b2da534-3e03-4391-8a4d-074b9f2bc1bf&displaylang=en" target=_blank>Microsoft</a> first. It is 1.8M bytes, much smaller than the 5M bytes Microsoft Visual Studio 2010 (VC10) redistributable package, but much larger than my familiar MFC42.dll.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
