<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Interactive Voice Response</title>
<meta name="description" content="AR1688 IVR development details. PCMU format voice data can be stored in the same program flash space as Chinese font data.">
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>Interactive Voice Response</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 7, 2011</td></tr>
<tr><td>Last week an <a href="../../../ar1688/index.html">AR1688</a> developer asked if he can add more functions in the phone to read out different voice messages. I added ivr.c today and uploaded 0.51.002 software API to <a href="../../../ar1688/software/sw051.html">0.51</a> test software web page.
Based on those, he can do the following complicated steps to make out more from our fading 8-bit system.
<br />1. Record raw PCM voice data using software like CoolEdit, with single channel, 8k sampling, 16-bit format. Current IP address original PCM data can be download from <a href="../../../pa1688/index.html">PA1688</a> page <a href="../../../pa1688/download/misc/ivr.rar">here</a>.
<br />2. Edit each word to 0.58 seconds precisely and save in separate file using CoolEdit. Those data downloaded from PA1688 page need to be edited too, as PA1688 used IVR differently with AR1688.
<br />3. Convert those 0.58 seconds files into G711 mu law (PCMU) format using CoolEdit, each file size now should be 4640 bytes. 
<br />4. Copy those files into one file in the order defined in sdcc\include\ar168.h SYSTEM_IVR_XXXX_OFFSET macros.
<br />5. Using sdcc\bin\convert -v to convert step 4 output file into sdcc\src\res\ivr_xx.dat. If the total words number is more than 14, convert.exe need to be changed and <a href="20100818.php">recompiled</a>. Search for IVR_FILE_SIZE in sdcc\tool\convert\ source files to find out where to change. 
<br />6. IVR data shares flash spaces with Chinese font data, and can be <a href="20070605.php">updated</a> same as font. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
