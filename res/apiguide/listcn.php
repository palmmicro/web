<?php require("../../php/usercomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Palmmicro软件API开发指南 - 使用T_LIST相关函数</title>
<meta name="description" content="介绍Palmmicro软件API中T_LIST相关数据结构和函数, T_BUF_LIST, F_LIST_ITERATE, ListIterate, ListRemoveItem等.">
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
<tr><td class=THead><B>Palmmicro软件API开发指南 - 使用T_LIST相关函数</B></td></tr>
<tr><td>&nbsp;
<br /><font color=grey>概述</font>
<br />Palmmicro的TCP/IP实现中大量使用了<font color=olive>T_LIST</font>相关的数据结构和函数, 这里的描述用于帮助API用户在更多其他地方使用它们. 
<br /><font color=olive>T_LIST</font>数据结构定义在include\<b>p_list.h</b>中. <font color=olive>T_LIST</font>是所有<font color=olive>T_XXXX_LIST</font>结构的基础类型.
使用相关函数的数据结构都必须把ptNext做为第一个结构成员, 并且该结构本身是用<i>malloc</i>函数分配的. 
<br />相关的<i>ListXyyy</i>函数在list\<b>list.c</b>和include\<b>p_list.h</b>中. 
<br /><font color=olive>T_BUF_LIST</font>和list\<b>buflist.c</b>是最直接的使用<font color=olive>T_LIST</font>函数的例子. 
<br />&nbsp;
<br /><font color=grey>细节</font>
<br /><i>ListIterate</i>对每个链表成员执行<font color=olive>F_LIST_ITERATE</font> <i>f</i>函数, <i>f</i>返回TRUE的时候终止循环, 终止处的链表成员指针被<i>ListIterate</i>返回. 
如果<i>f</i>始终返回FALSE, 则<i>ListIterate</i>返回NULL. 
<br /><i>ListRemoveItem</i>可以安全的在<font color=olive>F_LIST_ITERATER</font>函数中调用, 用来删除一个链表成员. 
</td></tr>
</table>

<?php UserComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplay();</script>

</body>
</html>
