<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>The Good, the Bad and the Ugly</title>
<meta name="description" content="While trying to work out a software for eHOG 1-port FXS gateway, I sadly found out how ugly our PA1688 software was designed again.">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa1688.js"></script>
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
<script type="text/javascript">NavigatePa1688();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>The Good, the Bad and the Ugly</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 5, 2014</td></tr>
<tr><td>Inspired by the success stories of Dr Wang, nearly all <a href="../palmmicro/20080326.php">Palmmicro</a> early employees started their own businesses after leaving Centrality, <a href="../entertainment/20070813.php">SiRF</a> or <a href="../entertainment/20090219.php">CSR</a>.
Tang Rui was the latest one to join this unsuccessful road. After losing money for a whole year, he asked me one question last month: why <a href="../pa6488/20101225.php">Palm1</a> failed in the mp3 business? 
<br />I had already thought over the question a few years ago, so I can answer him immediately, it was because we wrote the software too bad.
My recent attempt to modify the Palm1/PA1688 software showed just how ugly the software structure was built by myself.
<br />An user sent us several images of his <a href="../../../pa1688/user/ehog.html">eHOG</a> and asked for upgrade software. I have never seen the device before. 
Judging from the PCB I guess it is a mix of <a href="../../../pa1688/user/dp3000.html">PA168P</a> and <a href="../../../pa1688/user/pa168v.html">PA168V</a>.
<br />I decided to add a new <a href="../ar1688/20061014.php">hardware type</a> <font color=gray>EHOG</font>. It must have been a long time since the last time I made serious changes to PA1688 software, so I fully underestimated it. 
<br />I added <b><i>VER_EHOG</i></b> in inc\<b>version.h</b> and modified other related part in the same file and began to compile it with command line <font color=gray>mk ehog sip cn</font>.
Soon I found that I also need to add <b><i>VER_EHOG</i></b> related changes in inc\<b>flags.h</b> and <font color=gray>ehog</font> related changes in <b>make_hex.bat</b>.
After those changes, no compiler error was shown, but I still can not find the upgrade binary file <b>ehog_sip_cn_169006.bin</b> supposed to be generated after compilation.
<br />After checking each steps, I found that I also need to add <font color=gray>ehog</font> to PALMTOOL\P_MERGE\<b>p_merge.cpp</b> and recompile bin\<b>p_merge.exe</b>.
The would be a huge task because <b>p_merge.exe</b> was compiled by VC6.
Considering the effort I made when I was converting AR1688 Windows tools from VC6 to <a href="../ar1688/20100818.php">VC2008</a>, I decided to give up adding hardware type <font color=gray>EHOG</font> to PA1688 software. 
<br />As a typical bad software, <b>p_merge.exe</b> will fail to merge unknown hardware type binary file silently without any warning or error output. And it kept its hardware type text strings in .exe file instead of a configuration file.  
<br />Finally I managed to get an upgrade file <a href="../../../pa1688/software/sw169.html">pa168p_sip_cn_fxo_169006.bin</a> by adding an <i><b>OEM_FXO</b></i> compile option and sent to the user.
To my dismay I was told that the new software did not work with his device. 
<br />&nbsp;
<br /><font color=gray>In pursuit of profit there is no such thing as good and evil, generosity or deviousness; everything depends on chance, and not the best wins but the luckiest. -- <i>Sergio Leone</i></font>
<br />&nbsp;
</td></tr>
<tr><td><img src=../../../pa1688/user/ehog/pcb.jpg alt="PA1688 eHOG 1-port FXS gateway internal PCB." /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
