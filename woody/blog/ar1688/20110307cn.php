<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>语音提示</title>
<meta name="description" content="AR1688语音提示的开发. PCMU格式的语音数据可以存放在中文字库数据的程序存储器空间中, 然后在程序运行时调用播放出来. 这部分语音数据可以同样按照字库方式更新.">
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
<td width=780 height=105 align=left valign=top><a href="/woody/"><img src=../../image/image.jpg alt="Woody Home Page" /></a></td>
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
<tr><td class=THead><B>语音提示</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2011年3月7日</td></tr>
<tr><td>上周有个<a href="../../../ar1688/indexcn.html">AR1688</a>开发者问他是否能在电话中加入更多的语音提示. 今天我增加了ivr.c, 上传了0.51.002软件API到<a href="../../../ar1688/software/sw051cn.html">0.51</a>测试软件页面. 基于这些内容, 他可以按照下面复杂步骤在我们走下坡路的8位系统上增加更多功能. 
<br />1. 用类似CoolEdit的软件录制原始PCM语音数据, 使用单声道, 8k采样, 16位数据格式. 目前软件中报IP地址的原始PCM数据可以从<a href="../../../pa1688/indexcn.html">PA1688</a>的页面<a href="../../../pa1688/download/misc/ivr.rar">下载</a>. 
<br />2. 用CoolEdit把每个词编辑到正好0.58秒保存到单独文件. 从PA1688页面下载的数据也要编辑, 因为PA1688使用IVR的方式跟AR1688不同. 
<br />3. 用CoolEdit把每个0.58秒的文件转换成G711 mu律(PCMU)格式, 转换后的大小应该是4640字节. 
<br />4. 把转换后的小文件按照sdcc\include\ar168.h中SYSTEM_IVR_XXXX_OFFSET宏定义的次序拷贝到一个单独的大文件中. 
<br />5. 用sdcc\bin\convert -v转换第4步中的输出文件到sdcc\src\res\ivr_xx.dat. 如果全部词的数量大于14个, convert.exe需要重新<a href="20100818cn.php">编译</a>. 在sdcc\tool\convert\中的源文件中查IVR_FILE_SIZE找需要改变的地方. 
<br />6. IVR数据跟中文字库使用相同程序存储器空间, 可以同样按照字库方式<a href="20070605cn.php">更新</a>. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
