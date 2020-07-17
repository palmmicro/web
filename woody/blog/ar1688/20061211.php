<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Software API Contents</title>
<meta name="description" content="Same as PA1688, We provide software API for AR1688 customers. Here is the description of detail contents by directory.">
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>Software API Contents</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 11, 2006</td></tr>
<tr><td>We provide software API for all <a href="../../../ar1688/index.html">AR1688</a> IP phone manufacturers and end users. The API includes part of source codes and part of object files.
Based on the API, users can make their own customized upgrade binary files for their IP phones.
We do not provide fully open source software because we do not encourage those implementations to be transferred to another chip to compete with AR1688.
DSP part are provided in binary .dat file and low-level register control, ethernet mac layer, IP layer and basic UDP and TCP connection implementations are provided in SDCC object .o files. 
<br />We use open source SDCC compiler to build the software and release software API under GPL license, in the hope of helping end users make more out of their IP phones. 
For me, it is fun to modify the software and see it working immediately, and I believe it is true for others too. 
When everyone can modify something with his or her own IP phone, we also hope that this will reduce our supporting work of customizations. 
And most important, with so many gifted programmers keeping an eye on our software and make improvements, we are more likely to do a better job than keep all the coding to ourselves.
<br />The API is provided as SDCC.rar file. It will decompress SDCC directory and files. We assume SDCC directory is decompressed to drive D:. If it is not, you will need to change the first line of sdcc\src\<b>makefile</b>.
<br />Currently there are following 5 directories under SDCC:
<br />1. bin - <a href="../../../res/index.html#sdcc">SDCC</a> open source compiler binary files and our own special tools binary files. We are using SDCC 2.6.0 steady version. You can also download those files directly from SDCC official website.
The <b>SDCC.exe</b> is smaller than the official website one because we only compiled Z80 part in the .exe file. GNU <b>make.exe</b> utility is also here. 
<br />2. include - .h files. We only use SDCC compiler, do not use any include and library files from the official SDCC. All .h files are written by ourselves, there might be small difference of parameters compared with standard c runtime routines.
And not all c runtime routines are included, only those needed are there. We are doing this for performance.
<br />3. lib - It is not actually <i>library</i> file, instead, there are object files in this directory, those object files are compiled from source files which are not in API source code, and are to be linked together with other files in link stage.
Same as in include, there are no standard SDCC library used in our project.
<br />4. src - Source files, including <b>makefile</b> and batch files to generate upgrade binary file. All UI related and VoIP protocol related implementations are provided in source code. Measured in source code size, over 80% are open source in this API.
<br />5. tool - Full source code of those special tools in bin directory, in a MS Visual C++ 6.0 project.
<br />&nbsp;
<br /><font color=magenta>Updated on May 14, 2007</font>
<br />SDCC decompress to drive C: since version <a href="20070405.php#20070514">0.12</a>.
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 18, 2010</font>
<br />Compiler of tools in SDCC\bin upgraded to VC2008 since version <a href="20100818.php">0.48</a>.
<br />&nbsp;
<br /><font color=magenta>Updated on June 15, 2014</font>
<br />Compiler of tools in SDCC\bin upgraded to <a href="../entertainment/20140615.php">Visual Studio</a> 2013.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
