<?php include('php/_sendemail.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Send Email</title>
<link href="../common/style.css" rel="stylesheet" type="text/css" />
<script src="../js/filetype.js"></script>
<script src="../js/copyright.js"></script>
<script src="../js/nav.js"></script>
<script src="../palmmicro.js"></script>
<script src="account.js"></script>
<script src="../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">AccountMenu();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>


<table>
<tr><td class=THead><B>Send Email</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
</table>

<form id="emailForm" name="emailForm" method="post" action="php/_sendemail.php">
  <table width="640" border="0" align="left" cellpadding="2" cellspacing="0">
    <tr><td><input name="subject" value="<?php echo $strSubject; ?>" type="text" size="64" maxlength="128" class="textfield" /></td></tr>
    <tr><td><textarea name="contents" rows="16" cols="75" id="contents"><?php echo $strContents; ?></textarea></td></tr>
    <tr><td><input type="submit" name="submit" value="Send Email" /></td></tr>
	<tr><td><input type="hidden" name="id" value="<?php echo $strId; ?>" /></td></tr>
  </table>
</form>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
