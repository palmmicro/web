<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Mistakes I Made on Last Sunday</title>
<?php EchoInsideHead(); ?>
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
<tr><td class=THead><B>Mistakes I Made on Last Sunday</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Dec 15, 2009</td></tr>
<tr><td>It was a bad day, I spent almost two hours on MSN with a <a href="../../../pa1688/index.html">PA1688</a> user in Georgia (Country, not state in US) and ended up with destroying his last ATA. I feel so bad with the result that I have been thinking of those mistakes I made in the past few days.
<br />1. Must see real device pictures from both outside and inside (with PCB images) before deciding which PA1688 software to use. When I asked to see a picture of the device, he showed me a picture in a user's guide. On the user's guide it is an <a href="../../../pa1688/user/ag168v.html">ATCOM PA168V</a> (with 2 RJ11 ports). But what is actually there is an ATCOM PA168Q (with 1 RJ11 port). I have forgot how similar those two look like except for the RJ11 difference and failed to warn the possibility.
<br />2. Must check PA1688 device 'debug' option before upgrade. Too many PA1688 manufacturers and users prefer to set 'debug' option to "<a href="../ar1688/20061014.php">no check</a>", and prevent any check on the upgrade files as this one.
<br />3. Must double check if option changes can work after upgrade software. This is an effective way to confirm the right upgrade file to use. But I failed to ask the user to do this.
<br />4. Must not upgrade page0 <a href="../pa6488/20090927.php">safe mode</a> under any panic situations. When the user told me there is no dial-tone after upgrade, I did not realize it was because of wrong software. Instead, I was hoping everything will be ok by very <a href="20070607.php">tiny chance</a> of luck after page0 safe mode upgrade! I gave him PA168V page0 file to upgrade and lost the chance of safe mode recovery.
<br />PA168V and PA168Q used different program flash. This is why PA168V software will destroy PA168Q. This lead me to another <a href="../../../pa1688/user/pa168s.html#flash">mistake</a> we made back in 2005. Why we spent time to change program flash in PA1688 hardware reference design? The program flash supply shortage in 2004 was part of the reason. But it was a big mistake, we should have spent more time on real new products development instead of minor changes on an old design. 
</td></tr>
<tr><td><img src=../../../pa1688/user/ag168v/1s.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
