<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Too Late Good News</title>
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
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
<tr><td class=THead><B>Too Late Good News</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>June 7, 2007</td></tr>
<tr><td>I feel rather sad today after a very small <a href="../../../pa1688/index.html">PA1688</a> manufacturer reported that their ALC202A problem finally fixed with 1.58.003 firmware. Although it is good news, it is really too late, we should have fixed this at least 3 years ago.
<br />PA1688 uses AC97 interface to work with external analog audio codec. We used WM9703 from Wolfson in the first FPGA board. Later WM9703 was replaced by WM9707. During all those years we had been searching for other compatible AC97 chip to replace it. ALC202A from Realtek was one of them, and the one most close to success.
<br />The bug was actually very simple. The customer's engineer noticed a signal abnormal during reset. We were using GPIO to reset AC97. And then he noticed the signal was correct when using external reset signal to reset ALC202A instead of GPIO.  I checked the software, and found the software GPIO reset was done after AC97 interface clock enabled. After moving GPIO reset before AC97 interface clock enabled, everything ok.
<br />We had begun ALC201/2A at least 3 years go, As AC97 chip from Realtek is only about half the price of WM9707. Besides us, many of our large customers had also build sample phones based on ALC202A. None was able to solve the unsteady problem. I can not keep wondering what if we found and solved this problem 3 years ago. Now it is really too late, after PA1688 is discontinued for more than 1 year.
</td></tr>
<tr><td><img src=../../../pa1688/user/pb35/wm9707.jpg></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
