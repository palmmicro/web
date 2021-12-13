<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>JPEG Story</title>
<meta name="description" content="When JPEG was needed in PA6488 voice and video over IP solution, I was reminded how the Rie Miyazawa files educated my software development since 1992.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../woody.js"></script>
<script src="../blog.js"></script>
<script src="pa6488.js"></script>
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
<script type="text/javascript">NavigatePa6488();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>JPEG Story</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>May 16, 2011</td></tr>
<tr><td>It was in 1992, one day Denvor told me very excitedly about a new technology named JPEG. He had just converted his Rie Miyazawa collection from BMP to JPG and saved a lot of floppy disks.
He was also a little worried that the compression was lossy and the file displayed not so fast on Mo Jun's 286 PC. This was the first time I met JPEG.
<br />The first time I got my hands on JPEG source code was in 1997. Dr Jia and I wrote a CMOS sensor bayer pattern interpolation algorithm test application. I used <a href="http://www.ijg.org/" target=_blank>IJG JPEG</a> version "6a 7-Feb-96" source code for JPG file read and write.
A screen snapshot from the application is displayed below. I used Rie Miyazawa pictures extensively in the test.
<br />When PA6488 <a href="20100109.php">web interface</a> need JPEG file support, I grabbed version "8b 16-May-2010" from IJG and quickly put it <a href="../../../pa6488/software/devguide/jpeg.html">working</a>.
JPEG is only occasionally used and not critical for performance, so we did not optimize much of the code as we are doing with H.264.
<br />Last month I noticed by chance that IJG had moved to version "8c 16-Jan-2011". Although the changes do not affect our <a href="../../../pa6488/index.html">PA6488</a> solution, I merged the update last week for the peace of mind.
</td></tr>
<tr><td><img src=../photo/20110516.jpg alt="test interpolation algorithm with Rie Miyazawa Santa Fe JPEG file" /></td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>

