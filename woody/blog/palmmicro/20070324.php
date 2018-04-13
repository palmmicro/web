<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Our Business Model</title>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="palmmicro.js"></script>
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
<script type="text/javascript">NavigatePalmmicro();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>Our Business Model</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>March 24, 2007</td></tr>
<tr><td>AR1688 IP phone <a href="../ar1688/20061014.php">solution</a> has been in the market for over half a year now. I have personally answered quite a lot of business model related emails since that time. This article is the collection of all those questions and answers.
<br />We are not part-time open source software developers. Our income comes from the sales of <a href="../../../ar1688/index.html">AR1688</a> chip and related design fees.
<br />We use open source SDCC compiler to build the software and release software <a href="../ar1688/20061211.php">API</a> under GPL license, in the hope of helping end users make more out of their IP phones. For me, it is fun to modify the software and see it working immediately, and I believe it is true for others too. When everyone can modify something with his or her own IP phone, we also hope that this will reduce our supporting work of customizations. And most important, with so many gifted programmers keeping an eye on our software and make improvements, we are more likely to do a better job than keep all the coding to ourselves.
<br />We have not included everything in the free distributed API source code. <a href="../ar1688/20070216.php">DSP</a> part are provided in binary .dat file and low-level register control, ethernet mac layer, IP layer and basic UDP and TCP connection implementations are provided in SDCC object .o files. We will be glad to provide all those source code with reasonable price, if some big guy really believes it is necessary.
<br />It is true that we do not charge any design fee for basic IP phone reference designs. In the case of <a href="../ar1688/20061213.php">AR168F</a> IP phone design, it is provided with any chip purchase. Pay us 76 RMB (about 10 USD) for a single chip and we will provide everything, including free shipping in China. This policy is used to help manufacturers to pick up IP phone business with almost no investment. In this way, we hope to encourage as many manufacturers as possible into this business, making IP phone cheap enough to compete with PSTN phones.
<br />However, AR168F IP phone hardware reference design is for turn-key IP phone production only. It is not very possible for hardware developers to add or modify something based on it, and we will also not support those kind of development. We will charge extra design fees for request like dial-up, GSM module, FXS/FXO, LCD change. I will try to make it more clear by telling the birth story of AR168G IP phone below.
<br />Originally in mp3/mp4 business, Digitmat is new to VoIP. It does not like our AR168F design mostly because of the poor 2x16 character LCD. In mp3 business, it has been a long time to use dot-matrix displays. So Digitmat paid development fee to us for none-exclusive support of dot-matrix display. Today, <a href="../ar1688/20070127.php">AR168G</a> IP phone hardware reference design with 132x64 display support is also for every manufacturer, with the request of 80,000 RMB (about 10,336 USD) upfront design fees.
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
