<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Regional and Language Options</title>
<meta name="description" content="Same as PA1688, AR1688 customers around the world helped us to add multiple language support based on our software API.">
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
<tr><td class=THead><B>Regional and Language Options</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 5, 2007</td></tr>
<tr><td>With <a href="../../../pa1688/index.html">PA1688</a>, we have supported over 30 different language firmware.
None of us understand language except Chinese and English, volunteers all over the world helped us to do the entire localization works.
I believe that we can do this again with <a href="../../../ar1688/index.html">AR1688</a>, hopefully even better because it is well planned from the beginning.
<br />We are going to release version 0.10 firmware today. After 0.09 finalized all SIP/<a href="20060929.php">IAX2</a> protocol implementations, in this version we have finalized all UI implementations. 
Of course we will continue to improve it and fix bugs, however, developers can do regional and language customization based on this version without worrying future huge changes.
<br />Based on 0.10 software <a href="20061211.php">API</a>, please following steps below to add your own native language support:
<br />0) All files and subdirectorys here are located in D:\SDCC\ directory.
<br />1) Starting from inc\<B>version.h</B>, find the <b><i>RES_XX</i></b> sections, check if your regional code is in the list or not.
The <b><i>XX</i></b> code is following <a href="http://www.iso.org/iso/country_codes/" target=_blank>ISO 3166</a>. If it already exists, you can jump to step 4 directly.
<br />2) Change tools\namebin project, add your regional code to <B>namebin.cpp</B> related part, re-compile bin\<b>namebin.exe</b>.
<br />3) Add your regional DTMF frequency and interval to src\<B>dtmf.c</B>, search for <B><i>RES_US</i></B> in files if you need guide for changes.
<br />4) Check src\res\web_us, translate the English web pages into your native language.
<br />5) Translate strings in src\<B>ui_str.c</B>. There is Chinese strings already in it, you might not be able to read it. Just add your own language translation in your native coding. 
With 2x16 LCD, the display will still be English, but we can add other language font display with dot-matrix LCD.
<br />6) Open src\<B>time.c</B>, change time and date display format accordingly. If your region use day light saving time, be sure to add it, or send request to us by email. 
China does not use day light saving today. Currently only USA day light saving is implemented. Make sure <font color=blue>Automatically Adjust Clock for Daylight Saving Changes</font> option is checked in settings.
<br />&nbsp;
<br /><font color=magenta>Updated on <a name="20070514">May 14, 2007</a></font>
<br />Compared with the first version six weeks ago, we have changed some directory and file names on our API. So here is the AR1688 API 0.12 updated instruction to add regional and language options.
<br />1) Default working directory has been moved from D:\SDCC to C:\SDCC. The change is because of Tang Li has got a new software developing notebook without D drive.
<br />2) Original src\res\web_us directory has changed to src\res\us, translate the English web pages into your native language.
<br />3) Still a good starting point at src\<B>ui_str.c</B>, strings originally in this file has been moved to src\res\us and other directory like src\res\cn, the new files are <B>menu.h</B> and <B>str.h</B>.
<br />4) English strings in src\<B>time.c</B> has be moved to src\res\us\<B>time.h</B>.
<br />5) Translate the 3 .h files in src\res\us into your native language. Take French as example, translate with same file names into src\res\fr directory for 2x16 character LCD which does not support accented characters,
and translate full version with accented characters into files named <B>menu_dot.h</B>, <B>str_dot.h</B> and <B>time_dot.h</B> for dot-metric display. Keep the original coding as it is.
<br />&nbsp;
<br /><font color=magenta>Updated on <a name="20080213">Feb 13, 2008</a></font>
<br />Inspired by recent Ferhat's work on Turkish support on his 4x20 character LCD with special Turkish char font data in self defined LCD CGRAM space, we improved our regional and language support features in current AR1688 0.27 test software. 
Forget all those old steps, here is all the steps to add your own native language support in AR1688 firmware, for both dot-matrix LCD and character LCD:
<br />1) Add <b><i>RES_XX</i></b> in inc\<B>version.h</B>, <b><i>XX</i></b> code based on ISO 3166. Use <B><i>RES_US</i></B> related implementations as example all the time.
<br />2) Add your regional DTMF frequency and interval to src\<B>dtmf.c</B>.
<br />3) In src\<B>time.c</B>, change time and date display format accordingly, and add day light saving time support if your region uses day light saving.
<br />4) Translate the English web pages in src\res\us into your native language, put them in the new src\res\xx directory.
<br />5) Translate src\res\us\<B>menu.h</B>, <B>time.h</B> and <B>str.h</B> into your native language, keep the original coding as it is in the file. For example, keep ISO 8859-1 coding for French special chars and ISO 8859-9 coding for Turkish special chars.
<br />6) Add necessary ISO 8859-X font in src\<B>font.c</B>, or update other <a href="20070605.php">font</a> in the 256k bytes program flash font data storage space.
<br />For users with less programming experience, only step 4 and 5 are necessary, we will do the other works after we have received the translations for step 4&5.
<br />&nbsp;
<br /><font color=magenta>Updated on March 11, 2008</font>
<br />Current AR1688 software has supported Chinese, English, French, Italian, Romanian, Russian, Spanish and Turkish. What is more, Alex also added extended char input method in Romanian and Russian version. So we have step 7 now with 0.29 test software.
<br />7) Find src\res\us\<B>inputmap.h</B>, change it to your own native language. src\res\ro\<B>inputmap.h</B> is Romanian example and src\res\ru\<B>inputmap.h</B> is Russian example.
Different <B>inputmap.h</B> is included with <b><i>RES_XX</i></b> define in src\<B>menu.c</B>. 
<br />&nbsp;
<br /><font color=magenta>Updated on <a name="20100506">May 6, 2010</a></font>
<br />A French user reported French version web and display errors many months ago. We finally figured out why recently, but we still can not solve the problem because none of us understand French.
AR1688 <a href="../../../ar1688/software/sw046.html">0.46</a> software is going to release with a broken French version, and what is worse, many other language version might be broken too.
We can only assure that English and Chinese versions are good.
<br />Those editor tools like Ultra Edit v11.00+ and MS Visual Studio 2008 running on our new development Windows Vista and Windows 7 computers caused the error.
With language for non-Unicode programs always set for Simplified Chinese, the French strings in our .c, .h, and .html source files were changed in a forced way before we knew it.
And many other language versions may suffered the same problem too. The only way to prevent this is to set non-Unicode to French when we edit French related files, and we will remember it from now on.
<br />Right now, we need users to help to test all other language versions with our coming 0.46 release.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
