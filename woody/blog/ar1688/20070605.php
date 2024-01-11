<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>How to Upgrade Font</title>
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
<tr><td class=THead><B>How to Upgrade Font</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Jun 5, 2007</td></tr>
<tr><td>All current <a href="../../../ar1688/index.html">AR1688</a> IP phone designs use 2Mx8 bits program flash, and share the same software structure. The program flash is separated in 32 different 64k space we call pages. 
For example, the first 64k is called page0, and is responsible for safe mode recovery. Phone settings and address books are in the seconds 64k space which is called page1. 
<br />Page8 to page 11 are used to store font. The size is 256k bytes in total. Just big enough to put 16x16 Chinese font for those about 6000 Chinese characters which are used most common. 
Those 4 pages of font is only used in dot-matrix LCD designs. For 2x16 character LCD, the font in LCD controller chip is used instead. 
<br />Font is not supposed to be changed, it is fixed when program flash is written for the first time. However, as I mentioned <a href="20070603.php">before</a>, we have to upgrade the font to be ISO 8859 compatible for French and other west Europe language display. 
We need to use a back door of AR1688 firmware to upgrade font in following steps (in Windows command line mode):
<br />1. Enter C:\SDCC\src\res
<br />2. Type command "copy /b holdmusic.dat + font.dat holdmusic_font.dat"
<br />3. Use command for upgrade hold music, type command "tftp -i xxx.xxx.xxx.xxx put holdmusic_font.dat"
<br />In this way, hold music and font will be all updated with those files in src\res directory, if you do not like the default hold music, you can change it back.
<br /><a href="20070328.php">Hold music</a> is stored in page5 to page7. However, current software will not check file length when upgrade in TFTP mode, so when font files are attached to a hold music file, it will continue update font.
<br />&nbsp;
<br /><font color=magenta>Updated on Feb 16, 2008</font>
<br />ISO 8859 font does not need to be upgraded separately since version <a href="20080216.php">0.28</a>.
<br />&nbsp;
<br /><font color=magenta>Updated on Jul 4, 2012</font>
<br />Font can be upgraded by using command line "tftp -i xxx.xxx.xxx.xxx put font_xxxxxxxx.dat" directly since version <a href="../../../ar1688/software/sw057.html">0.57</a>. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
