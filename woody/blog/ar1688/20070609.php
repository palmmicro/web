<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>How to Compile AR1688 API with Linux</title>
<meta name="description" content="Since the first day we provided AR1688 software API, customers bagan to ask if it can be compiled with Linux. Alex Vangelov finally finished the work.">
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
<tr><td class=THead><B>How to Compile AR1688 API with Linux</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>June 9, 2007</td></tr>
<tr><td>This is one of the frequently asked questions of AR1688 software <a href="20061211.php">API</a>. The answer is possible, but with some extra work. 
Please check the makefile in SDCC\src, there are 4 tools used:
<br />AZ80 = $(PATH_SDCC)BIN\as-z80
<br />CZ80 = $(PATH_SDCC)BIN\sdcc
<br />LZ80 = $(PATH_SDCC)BIN\link-z80
<br />HEX2BIN = $(PATH_SDCC)BIN\hex2bin
<br />The first 3 are from SDCC itself, user can download SDCC Linux build and replace those files. We are using current steady version 2.7.0 at this time. 
<br />The last tool, hex2bin, is written by ourselves. Its source code is in SDCC\tool\hex2bin. It is a command line tool written in Windows MFC style with heavy usage of CFile and CString.
Linux user need to change the source code and compile it again.
<br />Besides compile with Linux, user may need to debug with Linux. The only way to debug is output debug message in UDP broadcast.PalmTool from PA1688 API is used to receive and display those messages, 
user need to port <a href="../../../pa1688/software/palmtool.html">PalmTool</a> to Linux too if some really serious development work is going to be done. 
<br />There are also some command line tools used for function like phone settings, user need to port SDCC\tool\convert to Linux. However, it is possibly not necessary because web pages can do those work all.
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 11, 2008</font>
<br />PalmTool is not used for debug since AR1688 <a href="20080811.php">0.37</a>, use SDCC\bin\<b>manager.exe</b> instead.
<br />&nbsp;
<br /><font color=magenta>Updated on Nov 23, 2010</font>
<br />Z80 compiler and linker names changed to <b>sdasz80.exe</b> and <b>sdld.exe</b> since SDCC <a href="20101123.php">3.0.0</a>.
<br />&nbsp;
<br /><font color=magenta>Updated on Mar 10, 2013</font>
<br />After nearly 6 years, recently this work was finally done by Alex Vangelov,
who had the same thought about programming and wrote in his email starting with <font color=grey>Just for fun</font>.
<br />As I am new to <a href="../entertainment/20120719.php">Linux</a> programming, I took special interest in merging it into our AR1688 software code base, and kept a few notes:
<br />1) <font color=grey>Ne2000.h is renamed to ne2000.h, unix is case sensitive.</font> Also changed are many <b>stdafx.h</b> related files in sdcc\tool.
Although I can not remember why <b>Ne2000.h</b> was the only file with mixed case letter in sdcc\include,
I know very clearly that <a href="20100818.php">Visual Studio</a> generated all those <b>StdAfx.h</b> automatically and included them in source files as <b>stdafx.h</b>. 
Looks like a way of Microsoft to show its difference from Unix.
<br />2) <font color=grey>Path notation changed from "\\" to "/" in some files for compatibility.</font> This is obviously another way to show Microsoft's difference. 
The result is, not only cross platform compilers like <a href="20101123.php">SDCC</a> knows how to handle the mess, VC2008 can do it as well.
During my debug, I even found that the VC2008 can handle file path and name like C:\sdcc\src/settings/<b>default_sip.txt</b> correctly!
<br />3) File <b>mfc2std.h</b> is added in sdcc\tool\common, to replace those heavily used MFC class like CString. Although I do not think I will write my next PC application using ansi C only for compatibility,
I will definitely remember to put all MFC related code in separate places.
<br />4) <font color=grey>relink tool generates linkmain_unix.lnk with linux paths, instead rewriting the existing file.</font>
<br />5) <font color=grey>Tested on Fedora and Gentoo linux with sdcc version 3.2.0.</font> Be <font color=red>CAREFUL</font> here! As SDCC 3.2.0 has known hidden <a href="20111007.php#20120813">bugs</a>!
<br />So the good news is, we <a href="../../../ar1688/software/sw061.html">now</a> have the house tools to compile AR1688 API with Linux. And the bad news is, we do not have the right SDCC to do it!
The <a href="20101123.php#20101208">3.0.1 #6078</a> version we are using now is a different from 3.0.0, but we did not keep the source file at that time, so we can not compile a Linux version to use today.
And both 3.1.0 and 3.2.0 have hidden bugs. I had to begin to debug the current SDCC snapshot again, in the hope of a new workable version. I filed my 23rd bug report on SDCC web site last Friday.
<br />&nbsp;
<br /><font color=magenta>Updated on March 11, 2013</font>
<br />Alex pointed out that #6078 source code was available on SourceForge svn, and modified sdcc\<b>Makefile</b> again to include the download and compile of SDCC #6078.
<br /><font color=grey>attached modified Makefile with new action "make sdcc",
that downloads sdcc revision #6078 from https://sdcc.svn.sourceforge.net/svnroot/sdcc/trunk/sdcc (only z80 related files) in folder ./sdcc_6078.
executes configure && make and creates symbolic links of compiled sdcc tools in ./bin folder
<br />* svn command required
<br />result:
<br />SDCC : z80 3.0.1 #6078 (Mar 11 2013) (Linux)
<br />to use local version of sdcc with mk command: in src/Makefile at line 17
<br />AZ80 = ../bin/sdasz80
<br />CZ80 = ../bin/sdcc
<br />LZ80 = ../bin/sdld
<br />* "make sdcc" is optional and not included in "make all"
</font>
<br />To make sure, I downloaded #6078 <a href="../../../ar1688/download/misc/sdcc6078.tar.gz">tarball</a> and put it on our own web site!
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
