<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>升级到Visual Studio 2013</title>
<meta name="description" content="把过去几年在Microsoft Visual Studio 2008 (VS2008/VC9)下开发的几个软件升级到Microsoft Visual Studio 2013 (VS2013/VC12), 包括Woody's Web Tool, CamMan, AR1688 Manager.exe和其它工具.">
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>升级到Visual Studio 2013</h1>
<p>2014年6月15日
<br />年初的时候我就计划要换掉用了5年的Sony VGN-FW235J. 但是Sony卖掉VAIO PC产品线的新闻阻止了我的立刻行动. 从2000年开始用Sony的笔记本, 我已经不知道以后要买什么了.
于是我继续使用它, 直到最近硬盘崩溃.
<br />我的VS2008/VC9也随着硬盘而崩溃了. 手头没有个VC编译器让我觉得很不舒服. 只好开始在我另外一台Sony VPCEG上开始安装VS2013/VC12. 这是我第一次从网络安装Visual Studio软件. 在终于下载完接近3G字节的安装包后,
我同样第一次选择了全部安装, 而不像以前那样只装VC编译器.
<br />12G字节的软件安装很顺利. 装完后我马上导入了<a href="20100529cn.php">Visual C++</a> 2008写的Woody的网站工具, 仅仅只是差不多10个警告而已, 从VC9到VC12的升级实在太简单了, 以至于我都没有注意到项目文件从.vcproj变成了.vcxproj.
<br />接下来我升级了<a href="20100726cn.php">原始视频播放器</a>中的CamMan. 它的.sln中的2个项目都带着差不多的10个警告一次转换成功. 我测试了常用功能, 一切正常.
<br />最后我开始升级<a href="../ar1688/20100818cn.php">AR1688 Windows下工具</a>. 因为我不清楚其中DSP开发相关项目要如何测试, 我决定一开始只转换Manager.exe.
这是个错误的决定, 所有第一次没有转换的项目文件, 以后都要手动删除老的.vcproj文件, 然后添加新的.vcxproj文件. 我认为这是个<b>Visual Studio 2013 Update 2</b>的软件缺陷.  
<br />稍后我在公司的Windows Server 2003上测试这些AR1688 Windows下工具. 一开始当<font color=red>Not a valid Win32 application</font>的错误信息弹出的时候我并不奇怪,
因为我知道自己还没有安装<a href="http://www.microsoft.com/zh-CN/download/details.aspx?id=40784" target=_blank>Visual C++ Redistributable Packages for Visual Studio 2013</a>.
但是装完VC12的运行库后还出这个错误信息就让我着实疑惑了一段时间.
最后发现是<font color=blue>Platform Toolset</font>的选项应该用<font color=blue>Visual Studio 2013 - Windows XP (v120_xp)</font>, 而不是缺省的<font color=blue>Visual Studio 2013 (v120)</font>.
微软多想不用兼容以前的Windows啊!
</p>

<h3>mfc120u.dll错误信息</h3>
<p>2014年12月6日
<br />一个<a href="../../../ar1688/indexcn.html">AR1688</a>的墨西哥用户在运行Manager.exe后看到了下面这个西班牙文的mfc120u.dll错误信息.
他使用64位的Windows 8.1并且安装了<i>Visual C++ Redistributable Packages for Visual Studio 2013</i>.
这提醒我在这里额外加个说明: 即使你使用64位系统, 也要安装32位的VC运行库版本.
<br /><img src=../photo/mfc120u.png alt="Screen shot of AR1688 Manager.exe Spanish mfc120u.dll error message." />
</p>

<h3>WinXP SP2该升级到SP3了</h3>
<p>2015年2月9日
<br />微软是铁了心逼大家升级啊. 当你看到下面这个错误信息时, 说明你的WinXP SP2该升级到SP3了. 
<br /><img src=../photo/kernel32.jpg alt="Screen shot of AR1688 Manager.exe Chinese GetLogicalProcessorInformation error message." />
</p>

<h3>AR1688编译辅助工具也要升级</h3>
<p>2015年8月3日
<br />今天有个老用户抱怨无法编译新的软件API, 让我很惭愧, 觉得自己的中文表达能力太差了. 
</p>
<blockquote><font color=gray>
我上个版本是ar168m_sip_cn_062000 . 
看了你的一大片文章, 还是不知道怎么办, 我只要编译模块能用的软件就行. 我的环境: 32位win7. 
</font></blockquote>
<p>赶快回答: 我们的PC端编译工具升级了, 要安装<i>Visual C++ Redistributable Packages for Visual Studio 2013</i>的32位版本.  
<br /><img src=../photo/mfc120u.jpg alt="Screen shot of AR1688 reversion.exe Chinese mfc120u.dll error message." />
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
