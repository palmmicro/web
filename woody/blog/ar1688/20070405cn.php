<?php require("../../../php/blogcomments.php"); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>地区和语言选项</title>
<meta name="description" content="跟PA1688一样, 全世界的AR1688用户在我们的软件API的基础上为我们提供了多语言支持. 一切都很美好, 直到UTF-8占据了微软的PC软件市场, 让我们非UTF-8的翻译彻底乱套.">
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
<tr><td class=THead><B>地区和语言选项</B></td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<tr><td>2007年4月5日</td></tr>
<tr><td><a href="../../../pa1688/indexcn.html">PA1688</a>设备支持三十多种语言. 我们当中没有人懂中英文外的语言, 来自全世界的用户自告奋勇地协助完成了所有本地化的工作. 因为从开始就做好了计划, 我相信在<a href="../../../ar1688/indexcn.html">AR1688</a>上我们可以把多语言支持做的更好. 
<br />今天我们将发布0.10版本. 在0.09版本完成了SIP/<a href="20060929cn.php">IAX2</a>协议后, 这一版中我们完成了所有的用户界面. 虽然我们仍然会继续改进和修改程序中的问题, 但是开发人员已经可以开始在这个版本的基础上进行地区和语言定制而不用担心以后会有很大的变化. 
<br />基于0.10版本软件<a href="20061211cn.php">API</a>, 请按照以下的步骤增加你自己的语言支持: 
<br />0) 全部提到的文件和子目录都位于D:\SDCC\目录下. 
<br />1) 从inc\<B>version.h</B>开始, 找到<B><i>RES_XX</i></B>部分, 检查你的区域码是否列在其中. 其中<B><i>XX</i></B>码依据<a href="http://www.iso.org/iso/country_codes/" target=_blank>ISO 3166</a>标准. 如果它已经存在, 你可以直接跳到第4步. 
<br />2) 修改tools\namebin项目, 添加你的区域码相关部分到<B>namebin.cpp</B>, 重新编译bin\<b>namebin.exe</b>. 
<br />3) 增加DTMF频率和间隔到src\<B>dtmf.c</B>中. 在文件中查找<B><i>RES_US</i></B>作为修改代码的参考.  
<br />4) 在src\res\web_us下把英文网页翻译成你自己的母语. 
<br />5) 翻译src\<B>ui_str.c</B>中的字符串. 你可能读不了其中的中文字符串, 但是没有关系, 增加你自己的语言翻译即可. 在2x16的LCD上, 仍只显示英文, 但是我们可以用点阵LCD显示其他语言字体. 
<br />6) 打开src\<B>time.c</B>, 改变时间和日期的显示. 如果你的地区使用夏时制时间也要在这里增加它, 或把你的要求发信给我们. 中国不使用夏时制, 目前只实现了美国的夏时制计时方式, 确认<font color=blue>根据夏时制自动调节时钟</font>选项在设置中已经被选中. 
<br />&nbsp;
<br /><font color=magenta><a name="20070514">2007年5月14日</a>更新</font>
<br />跟六周前的第一版相比, 我们在API上更改了一些目录和文件名. 这里把在AR1688 API 0.12版本中增加地区和语言选项的改动列出: 
<br />1) 缺省的工作目录从D:\SDCC移动到C:\SDCC. 修改的原因是因为唐丽的新开发用笔记本电脑没有D盘. 
<br />2) 原来的src\res\web_us目录改成了src\res\us, 在这里把英文的网页翻译成你的母语. 
<br />3) 从检查src\<B>ui_str.c</B>开始, 原来在这个文件里的字符串已经移动到src\res\us和其他的目录如src\res\cn中. 新的文件是<B>menu.h</B>和<B>str.h</B>. 
<br />4) 在src\<b>time.c</b>中的英文字符串已经移动到src\res\us\<B>time.h</B>中. 
<br />5) 把src\res\us中的3个.h文件翻译成你的母语. 以法语为例, 把相同文件名的文件翻译到src\res\fr目录中, 用于不支持特殊字符(例如é è à ê)的2x16字符型LCD. 把带特殊字符的版本翻译到名为<B>menu_dot.h</B>, <B>str_dot.h</B>和<B>time_dot.h</B>文件中, 用于点阵LCD显示. 保持原来的编码不变. 
<br />&nbsp;
<br /><font color=magenta><a name="20080213">2008年2月13日</a>更新</font>
<br />Ferhat最近在他的4x20字符型LCD上利用CGRAM上自定义点阵实现了土耳其语支持. 在他的鼓舞下, AR1688 0.27测试软件上加强了地区和语言选项的支持. 彻底忘记以前的步骤吧, 下面是往AR1688软件中添加你的母语支持的具体步骤, 同时针对字符型LCD和点阵LCD: 
<br />1) 在inc\<B>version.h</B>中添加<B><i>RES_XX</i></B>, <B><i>XX</i></B>代码来自ISO 3166. 在所有步骤中都使用<B><i>RES_US</i></B>相关的代码作为参考. 
<br />2) 在src\<B>dtmf.c</B>中添加地区使用的DTMF信号频率和间隔. 
<br />3) 在src\<B>time.c</B>中修改具体的时间和日期显示格式, 如果使用夏令时的话也在这里添加. 
<br />4) 把src\res\us中的英文网页翻译成你的母语, 放在新的src\res\xx子目录下. 
<br />5) 把英文的翻译src\res\us\<B>menu.h</B>, <B>time.h</B>和<B>str.h</B>翻译成你的母语, 保留你母语的编码方式. 例如保留ISO 8859-1格式下的法语特殊字符, 保留ISO 8859-9编码下的土耳其语特殊字符. 
<br />6) 把需要的ISO 8859-X字符添加到src\<B>font.c</B>, 或者把其它<a href="20070605cn.php">字库</a>更新到程序存储器上保留的256k字节点阵字库空间. 
<br />对于没有什么编程经验的用户, 可以只翻译第4和第5步, 我们在收到翻译文件后会协助完成其它步骤的工作. 
<br />&nbsp;
<br /><font color=magenta>2008年3月11日更新</font>
<br />现在AR1688软件支持中文, 英文, 法文, 意大利文, 罗马尼亚文, 俄文, 西班牙文和土耳其文. 而且Alex在罗马尼亚文和俄文版本中还增加了扩展的字符输入方法. 这样在0.29测试软件中我们有了步骤7. 
<br />7) 找到src\res\us\<B>inputmap.h</B>, 把它改成你自己的母语. src\res\ro\<B>inputmap.h</B>是罗马尼亚文例子, src\res\ru\<B>inputmap.h</B>是俄文例子. 不同的<B>inputmap.h</B>被包含在src\<B>menu.c</B>中定义的<B><i>RES_XX</i></B>中. 
<br />&nbsp;
<br /><font color=magenta><a name="20100506">2010年5月6日</a>更新</font>
<br />有个法国客户在很多个月前报告了法语版本软件出现话机显示和网页显示混乱的问题. 最近我们终于查明了原因. 但是因为我们都不懂法语, 这个问题暂时还无法解决. AR1688 <a href="../../../ar1688/software/sw046cn.html">0.46</a>版本软件即将带着一个错误的法语版本发布. 更糟糕的是, 目前我们只能确认中文版本和英文版本正确, 而其它语言的版本都有可能有类似法语版本的问题. 
<br />在我们新的Windows Vista和Windows 7的开发机器上运行的编辑软件Ultra Edit v11.00+和MS Visual Studio 2008是错误的祸首. 平时我们的机器上给non-Unicode的程序选项都是缺省的简体中文. 我们所有.c, .h和.html源文件中的法语特殊字符串就在不知不觉中被转换成了错误的内容. 同时其它语言也可能有类似的问题. 解决方式也容易, 只要记住在编辑法语文件的时候把non-Unicode设置成法语即可. 错误已经造成, 以后一定要小心. 
<br />目前我们需要客户们帮助测试0.46版本的其它语言是否正常. 
</td></tr>
</table>

<?php BlogComments(); ?>

</td>
</table>

<script type="text/javascript">CopyRightDisplayWoody();</script>

</body>
</html>
