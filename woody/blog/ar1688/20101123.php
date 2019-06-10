<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>The Journey to SDCC 3.0.0</title>
<meta name="description" content="It is not easy for AR1688 software to upgrade from SDCC 2.9.0 to 3.0.0. We finally reached a steady version at 3.0.1 #6078.">
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
<tr><td class=THead><B>The Journey to SDCC 3.0.0</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Nov 23, 2010</td></tr>
<tr><td>It took the <a href="../../../res/index.html#sdcc">SDCC</a> team 19 months travelling from <a href="20090329.php">2.9.0</a> to 3.0.0 release on Nov 1, seems that they had done many house keeping work during this time. The items in release note directly related with our AR1688 Z80 are:
<font color=grey>
<br />* changed z80 and gb targets object file extension to .rel
<br />* special sdcc keywords which are not preceded by a double underscore are deprecated in sdcc version 3.0.0 and higher. See section ANSI-Compliance in sdccman
<br />* asxxxx / aslink renamed to sdas / sdld and synchronized with ASXXXX V2.0
</font>
<br />Obviously those changes mean lots of changes in our source code and related makefiles. Partly because of I was busy with <a href="../../../pa6488/index.html">PA6488</a> work, 
partly because of I was lazy to <a href="20100715.php">fork</a> a test version, I ignored the test phase of release candidate 1 & 2. But as soon as I started testing 3.0.0, I realized that I had made a mistake.
<br />Most other Z80 users in the world are as lazy as me! So the Z80 port was not tested as good as the 8051 port. The first problem I met was inline asm not working any more, the SDCC mailing list soon replied it was a known bug already, 
and fixed in recent snapshot. Then I met another known problem, sometimes jp instruction was optimized into jr incorrectly, this time no ready fix yet, although somebody had already posted a workaround in the bug tracking system.
<br />With hundreds changes in my code, I do not hope to change back and wait. I started to try the workaround myself, but this need to recompile SDCC. As I had tried <a href="20100818.php">VC2008</a> to compile 2.9.0 and failed, 
I started to learn other ways to compile SDCC on my Windows Vista. 
<br />At first I installed Cygwin, after several hours I got error messages <font color=red>gcc options -mno-cygwin not used any more</font>. I realized that Cygwin compile was discarded the same way as MSVC. The only way is to use MinGW on Linux now.
<br />I downloaded <a href="http://www.virtualbox.org/" target=_blank>VirtualBox</a> and installed it. It asked me for Linux install DVD when I tried to add a Linux visual machine.
Then I downloaded <a href="http://www.daemon-tools.cc/eng/products/dtLite" target=_blank>DAEMON Tools Lite</a> to simulate DVD drive and <a href="http://www.ubuntu.com/" target=_blank>ubuntu</a>-10.10-dvd-i386.iso as Linux install file.
The installation process was smoother than I expected. After another several hours time I was able to compile and try the workaround myself. Finally I used a safer workaround, which is now working together with AR1688 software 0.49.007.
<br />The result is good, SDCC 3.0.0 generated 5% less code than 2.9.0, with Z80 usually it means 5% performance improve as well. 
<br />SDCC 3.0.0 hates bad code. I added hundreds of <font color=grey>(UCHAR)</font> before const char like <font color=grey>'T'</font>, and adjusted many const string point declare.
In <b>rc4.c</b>, a line originally as <font color=grey>x = x + something</font> can not be compiled until I change it to <font color=grey>x += something</font>. 
The most fatal experience was with my own <b>crt0.s</b>, an empty call was made to a non used section, it works on 2.9.0 but 3.0.0 compiled the call to an unexpected address and destroyed <a href="../pa6488/20090927.php">safe mode</a> booting process. 
I lost 2 phones before I figured out the problem.
<br />With so many changes along with SDCC 3.0.0, we plan to release 0.50 software in the near future. Software API 0.49.007 as 0.50 release candidate 1 is available at the <a href="../../../ar1688/software/snapshot.html">snapshot</a> part now. 
Hope our customers are not so lazy as Z80 SDCC users like me. Due to lots of file names changes, I suggest to remove old API completely before extract the new <a href="20061211.php">API</a> package.
<br />The new API package is much larger than before, mostly because MinGW compiled <b>sdcc.exe</b> 3.0.0 is now 2.3M bytes, while VC6 compiled <b>sdcc.exe</b> 2.9.0 only 0.8M bytes. And other SDCC related tools in bin directory are also much larger than before.
<br />The 8051 example code to work with <a href="../../../ar1688/module.html">AR168M</a> in mcs51 directory is also updated and now compiled with SDCC 3.0.0.
<br />&nbsp;
<br /><font color=magenta>Updated on Dec 7, 2010</font>
<br />Philipp is currently the major SDCC Z80 port developer. When I found he is updating C99 <font color=olive>bool</font> with his own Z80 <a href="http://www.atariage.com/forums/topic/172020-sdcc-300-released-and-some-updates-of-my-development-tools/" target=_blank>project</a>, 
I thought it was worth to try it with AR1688.
<br />In SDCC\inc\<b>type.h</b>, we have defined <font color=olive>BOOLEAN</font> as <font color=olive>unsigned char</font> all the time.
Since SDCC 3.0.0 supports <font color=olive>bool</font> from <b>stdbool.h</b>, I changed <font color=olive>BOOLEAN</font> to <font color=olive>_Bool</font> according to it, added <font color=blue>--std-c99</font> compiler option, and compiled a SIP version. 
To my surprise, the compiled code was larger than before. Then I made test and confirmed that <font color=blue>--std-c99</font> option only related with <font color=olive>bool</font> changes. As I am willing to get faster speed for larger code size, I continue to test the speed.
<br />I wrote the test function below in <b>icmp.c</b>, called it before ICMP response, so I can get the running time using ping:
<br /><font color=olive>BOOLEAN</font> <i>TestBoolean</i>(<font color=olive>BOOLEAN</font> b1)
<br />{
<br />    <font color=olive>USHORT</font> s;
<br />    <font color=olive>BOOLEAN</font> b2;
<br />    <font color=olive>BOOLEAN</font> b3 = <i>IsHighSpeed</i>();
<br />    for (s = 0; s < 30000; s ++) b2 = b1 ? b3 : FALSE;
<br />    return b2;
<br />}
<br />When <font color=olive>BOOLEAN</font> as <font color=olive>unsigned char</font>, the running time of this function is 137ms, and code generated is less by 4 bytes.
When as <font color=olive>_Bool</font>, using bit related instructions, this function need 167ms to run. 
Again we can see that for Z80, smaller code usually means faster code. As the C99 <font color=olive>bool</font> resulted with larger code and slower speed, I decided not to use it now.
<br />Here are other updated information about SDCC 3.0.0 compared with 2 weeks ago:
<br />1. The <font color=grey>jp to jr</font> optimization bug and <b>rc4.c</b> <font color=grey>x = x + something</font> bug fixed by Philipp.
<br />2. Another active developer Borut pointed out <font color=grey>Cygwin contains both gcc-3 (the good old version with -mno-cygwin) and gcc-4. You probably installed gcc-4. You can also install both versions and switch between then using set-gcc-default-3.sh and set-gcc-default-4.sh commands.</font> 
As I am glad with the Linux virtual machine, I did not try Cygwin further more.
<br />3. I did not use MinGW strip tool when talking about <b>sdcc.exe</b> size, I ignored it because it was a coincidence that download snapshot build with all ports and my own built with Z80 and 8051 only are both 2.3M bytes. 
After strip, Z80 and 8051 build only is 1.0M bytes, just slightly larger than 2.9.0 VC6 build.
<br />&nbsp;
<br /><font color=magenta>Updated on <a name="20101208">Dec 8, 2010</a></font>
<br />Philipp added a patch in #6078 soon after I posted my <i>TestBoolean</i> function test result in SDCC user mailing list yesterday. I tested it today and find the code size is the same now, 
and with <font color=olive>BOOLEAN</font> as <font color=olive>_Bool</font>, the running time is now 133ms, 4ms faster than <font color=olive>unsigned char</font>.
<br />But with overall AR1688 software, <font color=olive>_Bool</font> still results in a little larger code size than <font color=olive>unsigned char</font>.
However Philipp suggested to keep <font color=olive>_Bool</font> and I am going to follow his expert advice. 
Starting from current 0.49.026 version, <font color=blue>--std-c99</font> option is added in all makefiles to support C99 <font color=olive>bool</font>, and <font color=olive>BOOLEAN</font> is defined as <font color=olive>_Bool</font> in <b>type.h</b>.
<br />Because there is so little users testing current 0.49 with SDCC 3.0.0, we decided to delay 0.50 software release until it is fully tested. 
Instead, I added a separate <a href="../../../ar1688/software/sw049.html">0.49</a> web page for easy access of testing software.
<br />&nbsp;
<br /><font color=magenta>Updated on July 19, 2012</font>
<br />Now VirtualBox can read .iso file directly, no more DVD simulation needed.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
