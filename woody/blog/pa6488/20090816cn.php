<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>从PA1688到PA6488 - 升级软件的名字</title>
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
<td width=780 height=105 align=left valign=top><a href="/"><img src=/image/image_palmmicro.jpg alt="Palmmicro Name Logo" /></a></td>
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
<tr><td class=THead><B>从PA1688到PA6488 - 升级软件的名字</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2009年8月16日</td></tr>
<tr><td><a href="../../../pa1688/indexcn.html">PA1688</a>和<a href="../../../ar1688/indexcn.html">AR1688</a>的升级软件使用同样的名字<a href="../ar1688/20080607cn.php">规则</a>. 格式类似xxxxxx_yyyy_zz_vvvvvv.bin或者 xxxxxx_yyyy_zz_oooooo_vvvvvv.bin. 
<br />具体的名字内容来自软件API的include目录下version.h, 其中xxxxxx来自硬件板名字定义VER_XXXXXX, yyyy来自软件协议定义CALL_YYYY, zz来自ISO 3166标准的资源定义RES_ZZ, oooooo来自特殊的定义OEM_OOOOOO. 特殊的"oooooo"通常不在名字中, 除非升级软件中有特殊的内容. 
<br />在<a href="../../../pa6488/indexcn.html">PA6488</a>上, 我们把<a href="../ar1688/20060929cn.php">SIP</a>和<a href="../ar1688/20071110cn.php">IAX2</a>等协议放在同一个升级文件中. 这样 CALL_YYYY和"yyyy"就都分别从version.h和软件名字中取消了. 因为CALL_NONE在PA1688和AR1688上用于安全模式特殊软件, 我们在PA6488上增加了特殊的OEM_SAFEMODE用于区分特殊的安全模式软件文件. 这样, 名字"pa648c_us_010023.bin"代表用在PA648C视频压缩模块上的0.10.023版本英文升级软件, 而"pa648b_cn_safemode_002034.bin"代表用在PA648B开发板上的0.02.034中文特殊安全模式升级软件. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
