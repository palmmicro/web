<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>EFSL File System</title>
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
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
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>EFSL File System</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 25, 2010</td></tr>
<tr><td>In 1999 I wrote my first none PC software, a FAT file system to manage the SDRAM of <a href="../palmmicro/20080326.php">Palmmicro</a> Palm1, which we later called it <a href="../../../pa1688/index.html">PA1688</a>. The software used UART to exchange files with PC.
<br />Palm1 was designed for mp3 player and digital camera, this was why we need to manage and exchange files with PC. From hardware point of view Palm1 had the right architecture at least for mp3 player, 
the successful story of many later mp3 chips with the same 8-bit controller and ADSP2181 compatible DSP had proven it. The failure of Palm1 based mp3 player was due to the software weakness of us, including the clumsy software of my FAT.
<br />In the end of 2003, after the new year dinner, when only 4 of us were still on the table, <a href="../palmmicro/20061123.php">Dr Wang</a> said to Wang, Qin and me: All my successful start-up story is going to end with you. Although he seemed to be joking, 
I was surprised to hear it, but later I thought he was right. 
<br />However, it was different for me. Although the FAT software was never used in real product, it was the start point of my embedded software development, 
which lead to the <a href="../ar1688/20080615.php">RTL8019AS</a> software in year 2000 and the beginning of our VoIP business.
<br />When we need file system to manage DRAM again in <a href="../../../pa6488/index.html">PA6488</a>, I thought of my old FAT at first. However I soon believed it was a bad choice. 
I did not have much <a href="../ar1688/20080811.php">standard</a> sense at that time, the final version was a none standard FAT optimized for size and speed, and I found it was poorly organized. 
<br />At last I had decided to use the open source <a href="../../../pa6488/software/devguide/filesystem.html">EFSL file system</a>. There was also 2 choice for me, version 0.3.6 or 0.2.8, 
when I found that the document of 0.3.6 was not updated since 0.2.8, I had decided to use the steady version of 0.2.8.
<br />With standard FAT support from EFSL, we can support more future enhancement. For example, <a href="20090819.php">PA648C</a> video compression module does not have local storage at this time, 
but we can add a SD card to it and use the same EFSL library to manage it.
<br />It is said that file system is 1/3 of an OS. However, same as PA1688 and <a href="../../../ar1688/index.html">AR1688</a>, we still do not have a RTOS on PA6488.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>

