<?php require("../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro Software API Guide - Using T_LIST Functions</title>
<meta name="keywords" content="Palmmicro API, T_LIST Functions">
<meta name="description" content="Introduce T_LIST related data structure and function in Palmmicro software API. Including T_BUF_LIST, F_LIST_ITERATE, ListIterate, ListRemoveItem etc.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
<script src="../../js/filetype.js"></script>
<script src="../../js/copyright.js"></script>
<script src="../../js/nav.js"></script>
<script src="../../palmmicro.js"></script>
<script src="apiguide.js"></script>
<script src="../../js/analytics.js"></script>
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<table width=100% height=105 order=0 cellpadding=0 cellspacing=0 bgcolor=#049ACC>
<tr>
<td width=780 height=105 align=left valign=top><a href="/"><img src=../../image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
<td align=left valign=top></td>
</tr>
</table>

<table width=900 height=85% border=0 cellpadding=0 cellspacing=0>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=120 valign=top bgcolor=#66CC66>
<TABLE width=120 border=0 cellPadding=5 cellSpacing=0>
<script type="text/javascript">NavigateApiGuide();</script>
</TABLE>
</TD>
<td width=30 valign=top bgcolor=#66CC66>&nbsp;</td>
<td width=50 valign=top bgcolor=#ffffff>&nbsp;</td>
<td valign=top>
	
	
<table>
<tr><td class=THead><B>Palmmicro Software API Guide - Using T_LIST Functions</B></td></tr>
<tr><td>&nbsp;
<br /><font color=grey>Overview</font>
<br /><font color=olive>T_LIST</font> related data structures and funtions are used extensively in Palmmicro TCP/IP implementation. This description is to help API users to use them in more places.
<br /><font color=olive>T_LIST</font> data structure is defined in include\<b>p_list.h</b>.
<font color=olive>T_LIST</font> works as the base type of all <font color=olive>T_XXXX_LIST</font> struct where ptNext is the first element, and the struct itself is malloced from heap.
<br />Related <i>ListXyyy</i> functions are in list\<b>list.c</b> and include\<b>p_list.h</b>.
<br /><font color=olive>T_BUF_LIST</font> with list\<b>buflist.c</b> is the most direct example of using <font color=olive>T_LIST</font> functions.
<br />&nbsp;
<br /><font color=grey>Details</font>
<br /><i>ListIterate</i> runs every list item with <font color=olive>F_LIST_ITERATE</font> <i>f</i> function, <i>f</i> returns TRUE to abort iteration, the stopped list ptr is returned by <i>ListIterate</i>,
or NULL if <i>f</i> always returns FALSE. 
<br /><i>ListRemoveItem</i> can be safely called in <font color=olive>F_LIST_ITERATER</font> function to remove an item.
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
