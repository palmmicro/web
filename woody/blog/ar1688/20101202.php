<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Writing Program Flash</title>
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
<tr><td class=THead><B>Writing Program Flash</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 2, 2010</td></tr>
<tr><td>A GP1266 user and an AR168MS <a href="../../../ar1688/module.html">VoIP module</a> manufacturer are both asking how they can write the program flash on their devices, I am writing this blog as a simple guide, 
all files mentioned here can be downloaded from AR1688 <a href="../../../ar1688/software/sw049.html">0.49</a> test software page.
<br />The <a href="../../../ar1688/user/gp1266.html">GP1266</a> phone with the user can not boot and can not enter safe mode, I must say that it is the first time I heard this kind of problem, usually <a href="../pa6488/20090927.php">safe mode</a> will always work. 
He planed to remove the program flash, write it on an external programmer and solder it back to the phone. And here are the steps:
<br />1. Download the zipped <a href="../../../ar1688/software/049/gp1266_sip_us_049016_all.zip">gp1266_sip_us_049016_all.bin</a>, and write it on an general programmer for MT28F016S5 program flash, solder it back to phone. 
If everything is ok, the phone will boot up with MAC address 00-18-1f-00-00-00
<br />2. Download other zipped files <a href="../../../ar1688/software/049/gp1266_sip_us_049016.zip">gp1266_sip_us_049016.bin</a>, <a href="../../../ar1688/software/049/gp1266_sip_us_mac_049016.zip">gp1266_sip_us_mac_049016.bin</a> and 
<a href="../../../ar1688/software/049/gp1266_none_us_049016.zip">gp1266_none_us_049016.bin</a>, change MAC address described <a href="20070827.php">here</a>. This step must be done, not only to change the MAC address in settings, 
but also to generate the MAC checksum in <a href="20070605.php">page0</a>. General programmer can only change MAC address but when checksum failed, user may get error debug message like "hardware check failed"
<br />For the manufacturer, although they can perform the steps above too, step 2 will be too much trouble for quantity production. Instead, we sent them an AR168DS programmer based on <a href="../../../ar1688/index.html">AR1688</a> chip, 
which we made specially to write SST39VF1681 and MX29LV160CB program flash. We also had AR168D programmer for manufacturers with MT28F016S5 flash.
<br />Below is the AR168DS <a href="../../../ar1688/programmer.html">programmer</a> I am using to write this guide.
</td></tr>
<tr><td><img src=../photo/20101202.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
