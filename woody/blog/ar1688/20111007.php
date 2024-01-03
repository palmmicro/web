<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Stupid is as Stupid Does</title>
<meta name="description" content="Works on SDCC bugs tracking after version 3.0.1 #6078, so far we have not been able to locate a new working version yet!">
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
<tr><td class=THead><B>Stupid is as Stupid Does</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Oct 7, 2011</td></tr>
<tr><td>We started <a href="../../../pa6488/index.html">PA6488</a> solution development in early 2009. Since then, the major development on AR1688 had stopped.
However, even when the whole world include us at <a href="../palmmicro/20080326.php">Palmmicro</a> believe 8-bit controller can not go any where further, the <a href="../../../res/index.html#sdcc">SDCC</a> compiler development team never stopped.
So the compiler update information had become an important part of our software release note and my AR1688 blog post.
<br />Philipp, the current major SDCC Z80 developer, announced a new register allocator design to reduce <a href="20081202.php">Z80</a> code size early this year. After several month he finished it.
I always believe smaller code size is better for all AR1688 users. I began to test it in June, after several bug reports and fixes, in July I was able to compiler our AR1688 code with the new register allocator.
However, while it still had code generating bugs, the most annoying about the new version was the compilation time.
The total AR1688 software compilation time had increased from 2 minutes to about 30 minutes on my Sony <a href="../pa6488/20090808.php">VGN-FW235J</a> with 4G RAM.
<br />In Sep, Borut announced the 64-bit SDCC support on 64-bit Windows. I tested it as the first reported-result user, hoping it can reduce the compilation time.
But the result was disappointing, the 32-bit and 64-bit SDCC actually had no obvious performance changes on my 64-bit Windows Vista.
<br />In SDCC mailing list I asked what was the good for the 64-bit?
Philipp suggested <font color=gray>Try --max-allocs-per-node 100000000 (recommended: At least 64 GB of RAM) or even just --max-allocs-per-node 8000000 (recommended: At least 6GB of RAM). It won't work with the 32-bit version unless you use PAE.</font>
<br />Then I asked how much recommended <font color=blue>--max-allocs-per-node</font> with 4GB RAM for my own computer, this time Philipp did not reply as fast as he usually does.
During the dream of that night, I realized that I asked a <a href="20110826.php">stupid</a> question, because 4G RAM is the max of 32-bit system can support, there is no difference too.
<br />&nbsp;
<br /><font color=magenta>Updated on Oct 17, 2011</font>
<br />Yesterday Borut announced that SDCC 3.1.0 release was planned on 2011-11-26, and this release is dedicated to memory of Dennis M. Ritchie, father of the C programming language.
I realized that I must start my SDCC bugs tracking work again in order to keep up with those developers.
<br />I usually introduce myself as a software engineer, but actually I am more of a test engineer for AR1688 and SDCC in this recent year. However, the test work is even more difficult than the PA6488 solution development.
<br />After spending 10 continuous hours to track and report compiler bug 3424436, I finally found the function <i>SipCallStep1</i> which SDCC compiled wrong was actually the same function I report in bug 3122620 almost a year ago.
<br />Actually it was not the first time the same function compiled wrong, some code are born to be different and hard to compile. I reported <i>_DspLoadFile</i> function compiled wrong (in a different way) with both bug 3381400 and 3407632.
To avoid another 10 hours of bug tracking, I will round up the usual suspects first next time!
<br />&nbsp;
<br /><font color=magenta>Updated on March 17, 2012</font>
<br />Last year SDCC team released 3.1.0 version. However, after nearly 5 months, it is still a mess when compiling AR1688 software.
<br />We did not have much problem when SDCC <a href="20090329.php">2.9.0</a> released on 2009. When SDCC 3.0.0 was released on 2010, it took us about 2 weeks to catch up with the new version.
With today's <a href="../../../ar1688/software/sw057.html">0.57</a> test software, we are still using <font color=gray>SDCC 3.0.1 #6078 (Dec 7 2010) (MINGW32)</font>.
<br />It had a bad start as SDCC 3.1.0 was released with the 4th of my filed <font color=blue>--max-allocs-per-node</font> bug open.
Although I like the feature of <font color=gray>new register allocator in the z80 and gbz80 ports (optimal when using --opt-code-size and a sufficiently high value for --max-allocs-per-node for the z80 port)</font>,
I was haunted by <font color=red>Caught signal 11: SIGSEGV</font> crash all the time.
I read <font color=gray>Almost all signal 11 crashes (segment faults) are caused by a reference to the object of a null pointer</font> somewhere else, and I guess there must be some more hidden bugs in the new register allocator implementation.
<br />Philipp provided another option <font color=blue>--oldralloc</font> to use the old register allocator. After so many times of disappointment of the new one, I turned to test 3.1.0 with old allocator. However there were bugs too.
After Philipp fixed the 2 <font color=blue>--oldralloc</font> bugs I filed, I guessed that I had finally found a way to live with 3.1.0.
<br />Yesterday I began to build all my AR1688 binary files, and was shocked to find that all our source files with GB2312 coded Chinese characters can not be compiled any more!
<br />&nbsp;
<br /><font color=magenta>Updated on <a name="20120813">Aug 13, 2012</a></font>
<br />With suggestion from Philipp, SDCC team released 3.2.0 earlier than usual this year in the hope of a steady version. I was busy learning <a href="../entertainment/20120719.php">Linux</a> programming when it was released.
After I finished the test of AR1688 software release <a href="../../../ar1688/software/sw058.html">0.58</a> last week, the first thing in my mind was to test the new SDCC version.
<br />At first I was very happy, the 2 annoying bugs in 3.1.0, <font color=red>Caught signal 11: SIGSEGV</font> and <font color=blue>--max-allocs-per-node</font>, were gone. But more tests with different AR1688 devices showed at least 3 more bugs.
Seems that we have to continue to use old <a href="20101123.php#20101208">3.0.1 #6078</a> for quite some time.
<br />The table below summarizes the test results. Code size and compile time results are generated with command line <font color=gray>mk ar168g sip us</font> and standard compiler option <font color=blue>-mz80 -c --std-c99</font>.  
</td></tr>
</table>

<TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="table1">
       <tr>
        <td class=c1 width=100 align=center>SDCC version</td>
        <td class=c1 width=100 align=center>Extra compile option</td>
        <td class=c1 width=100 align=center>Code size (bytes)</td>
        <td class=c1 width=100 align=center>Compile time (minutes)</td>
        <td class=c1 width=240 align=center>Known problem</td>
      </tr>
      <tr>
        <td class=c1 align="center">3.0.1 #6078</td>
        <td class=c1 align="center"></td>
        <td class=c1 align="center">158073</td>
        <td class=c1 align="center">2</td>
        <td class=c1 align="center"></td>
      </tr>
      <tr>
        <td class=c1 align="center">3.2.1 #8062</td>
        <td class=c1 align="center"></td>
        <td class=c1 align="center">156413</td>
        <td class=c1 align="center">6</td>
        <td class=c1 align="center"><a href="../../../ar1688/module.html">AR168M</a> UART error</td>
      </tr>
      <tr>
        <td class=c1 align="center">3.2.1 #8062</td>
        <td class=c1 align="center"><font color=blue>--oldralloc</font></td>
        <td class=c1 align="center">154871</td>
        <td class=c1 align="center">3</td>
        <td class=c1 align="center"><a href="../../../ar1688/user/gp1266.html">AR168G</a> keypad error</td>
      </tr>
      <tr>
        <td class=c1 align="center">3.2.1 #8062</td>
        <td class=c1 align="center"><font color=blue>--max-allocs-per-node 10000</font></td>
        <td class=c1 align="center">152552</td>
        <td class=c1 align="center">13</td>
        <td class=c1 align="center"><a href="../../../ar1688/roip.html">AR168R</a> SIP message error with <a href="../../../res/voiptalk.html">VoIPtalk</a></td>
      </tr>
</TABLE>

<table>
<tr><td>The above compile time were all measured on my old Sony VGN-FW235J with Intel(R) Core(TM)2 Duo CPU T5800 @ 2.00GHz, 4GB DDR2 RAM and 64-bits Windows Vista.
When I tried the slowest one on my new Sony VPCEG with Intel(R) Core(TM) i5-2450M CPU @ 2.50GHz, 6GB DDR3 RAM and 64-bits Windows 7, the total time reduced to 6 minutes from 13 minutes.
I had not realized that my new computer was so much faster than the old one in the past 2 months!
<br />&nbsp;
<br /><font color=magenta>Updated on Aug 14, 2012</font>
<br />Test on today showed that SDCC 3.2.0 release did not have the AR168G keypad error problem (with <font color=blue>--oldralloc</font> option). 
<br />&nbsp;
<br /><font color=magenta>Updated on Jan 26, 2014</font>
<br />Sad <a href="https://sourceforge.net/p/sdcc/discussion/1864/thread/a7cdb71e/" target=_blank>news</a> about Borut Ražem.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
