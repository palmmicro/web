<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>My God the LM386 in AT323 Phone is Working ALL the Time!</title>
<meta name="description" content="The LM386 in PA168S phone is working all the time, we solved the problem in PA168T. The change can be used on all PA1688 device.">
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
<tr><td class=THead><B>My God the LM386 in AT323 Phone is Working ALL the Time!</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>Apr 20, 2011</td></tr>
<tr><td>The shocking title came from an <a href="../../../pa1688/user/at323.html">AT323</a> user, who found the LM386 inside the device generating slight but consistent water-like noise during the night.
He then measured the current, it was 200mA with 11V input, which means the power consumption is about 2W when not in a call. 
<br />Fortunately he found another <a href="../../../pa1688/user/et6602.html">PA168T</a> phone did not generate the noise.
After comparing the <a href="../../../pa1688/hardware.html">hardware</a> difference, he found PA168T used PA1688 pin 53 HFPOW_CTL signal,
together with extra S9014+S8550 amplifier, to control on/off of LM386. After applying the same circuit to his AT323, problem solved and the working current reduced to 170mA.
<br />Actually he was not the first to find the LM386 problem. Customers pointed the same <a href="../../../pa1688/user/pa168s.html">PA168S</a> design problem back in 2003,
and we made the change with PA168T design in 2004.
I have almost forgot this typical <a href="../palmmicro/20080326.php">Palmmicro</a> customer-driven product story until this hardware expert brought out the question and solution during the past a few days.
</td></tr>
<tr><td><img src=../../../pa1688/user/at323/whitepcb_s.jpg alt="ATCOM IP PHONE AT323 internal PCB image" /></td></tr>
<tr><td>LM386 is the 8-pin chip right above the <b>E</b> of <b>ATCOM IP PHONE</b> string. <a href="../../../pa1688/user/at323/whitepcb.jpg" target=_blank>Large View</a></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
