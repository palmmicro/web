<?php require("../../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Key test</title>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../../js/filetype.js"></script>
<script src="../../../js/copyright.js"></script>
<script src="../../../js/nav.js"></script>
<script src="../../../palmmicro.js"></script>
<script src="../../pa6488.js"></script>
<script src="../software.js"></script>
<script src="userguide.js"></script>
<script src="../../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateUserGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>Key test</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>1 Overview</B></td></tr>
<tr><td>Key test is not only used in devices with real keys like PA648B. It is also used in modules with <a href="../../../woody/blog/pa6488/20110411.php">UART</a> interface like <a href="../../../woody/blog/pa6488/20090819.php">PA648C</a>. In this way we provide a control interface base on the <a href="../../../woody/blog/ar1688/20080329.php">UI protocols</a>.
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td><B>2 Details</B></td></tr>
<tr><td>All key tests are triggered by a #n*m key sequence, defined in the following.
<br />
<br />b) '#1' -- System test, if the following keys are pressed
<br />'*0' -- System restart
<br />
<br />h) '#7' -- Video in test, if the following keys are pressed
<br />'*0' -- Video in raw data test begin
<br />'*1' -- Video in test end
<br />'*2' -- Video in H.263 encode test begin
<br />'*3' -- Video in H.263 encode and send recontruction data test begin
<br />'*4' -- Video in H.264 encode test begin
<br />'*5' -- Video in H.264 encode and send recontruction data test begin
<br />
<br />i) '#8' -- <a href="../devguide/filesystem.html">File</a> test, if the following keys are pressed
<br />'*0' -- Remove G.729 test files
<br />'*1' -- Remove JPEG test files
<br />'*2' -- Remove H.263 test files
<br />'*3' -- Remove H.264 test files
<br />
<br />j) '#9' -- Algorithm test, if the following keys are pressed
<br />'*0' -- <a href="../devguide/testvectors.html">G.729</a> test
<br />'*1' -- <a href="../devguide/jpeg.html">JPEG</a> test
<br />'*2' -- <a href="../devguide/h263.html">H.263</a> test
<br />'*3' -- H.264 test
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>

