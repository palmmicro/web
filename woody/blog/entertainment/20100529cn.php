<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>我的第一个Visual C++ 2008程序</title>
<meta name="description" content="我的第一个Visual C++ 2008程序Woody's Web Tool, 用于palmmicro网站开发. 顺便记录一下从1992年以来使用Turbo C, Borland C++, Visual C ++ 4.2, VC6和Microsoft Visual Studio 2008(VC9)的开发历程.">
<link rel="canonical" href="<?php EchoCanonical(); ?>" />
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>我的第一个Visual C++ 2008<a name="webtool">程序</a></h1>
<p>2010年5月29日
<br />为避免标题党的嫌疑, 这篇的名字没有写成<font color=gray>我的第一个苹果手机程序</font>或者<font color=gray>我的第一个Android程序</font>. 
<br />从1992年开始用Turbo C写PC上的程序开始, 直到1996年我还在用Borland C++. 但是在1997年终于投降了Visual C ++ 4.2. 1999我紧跟微软脚步升级到了VC6, 这一下用了10年.
<br />2009年初我改用新的<a href="../pa6488/20090808cn.php">Sony VGN-FW235J</a>后, 终于要面对Windows Vista不支持VC6的现实了. 我被迫安装了这个VC9(Visual C++ 2008), 不过接下来的一年中基本上只是当个编辑器在用.
<br />今年年初我开始给公司网站从<a href="../palmmicro/20100330cn.php">palmmicro.com.cn</a>搬家到<a href="../palmmicro/20080326cn.php">Palmmicro</a>.com,
我开始写这第一个程序, 名字叫做<b>Woody的网站工具</b>, 主要作用是把重复的拷贝粘贴和上传的工作自动完成. 现在网站搬家结束, 程序也宣告完成.
<br />在开发过程中, 我几次考虑要不要升级到Visual C++ 2010. 上个月碰了一个专业软件公司的程序员, 得知人家依然在用VC9, 这样我就不考虑升级了. 
<br />跟VC6比较, VC9给我印象深的有以下几点:
</p>
<ol>
  <li>尽管我在本地硬盘上安装了全部文档, 实际使用中从来都是从网上看文档打开更快.</li>
  <li>重复使用老的VC6代码的时候, 因为严格的unicode检查被迫在字符串上加了很多_T().</li>
  <li>新CHtmlView类让浏览网页文件很方便.</li>
  <li>新CFtpConnection类同样让上传文件到FTP服务器相当容易.</li>
</ol>
<p><img src=../photo/20100529.jpg alt="Screen shot of My First Visual C++ 2008 Application Woody's Web Tool" />
<br />费曼在曼哈顿计划结束后到康奈尔大学教物理, 中间有一段时间他觉得整天都很累, 没有精力搞他后来得了诺贝尔奖的理论物理研究.
晚年的时候他回顾说, 其实一部分原因是当时他低估了教大学生物理所耗费的精力. 康奈尔的努力延续到了加州理工, 我们今天才能幸运的读到经典的三大本费曼物理学讲义. 但在当时, 却是对一个小盘子的转动方式的关注把他从低谷中拉了起来.
</p>
<blockquote><font color=gray>I still remember going to Hans Bethe and saying, "Hey, Hans! I noticed something interesting.
Here the plate goes around so, and the reason it's two to one is . . ." and I showed him the accelerations.
<br />He says, "Feynman, that's pretty interesting, but what's the importance of it? Why are you doing it?"
<br />"Hah!" I say. "There's no importance whatsoever. I'm just doing it for the fun of it." His reaction didn't discourage me; I had made up my mind I was going to enjoy physics and do whatever I liked.
<br />Page 67 -- Surely You're Joking, Mr. Feynman!</font>
</blockquote>

<h3>从FTP到<a name="ftps">FTPS</a></h3>
<p>2013年2月19日
<br />王田可能是我认识的人中唯一一个跟我一样把编程序当成娱乐的. 几年前当他还在微软工作的时候, 有一天他突然跟我说, 他刚刚写了自己的第一个C#程序, 感觉很好.
<br />跟通常一样我总是后知后觉. 尽管我在网上读了不少, 而且听过王田感觉很好的亲身经历, 在2010年我开始写<b>Woody的网站工具</b>的时候我完全没有考虑C#.
而是用了我熟悉的MFC, 沾沾自喜的使用CFtpConnection类上传文件到我的网站.
<br />Yahoo网站服务从去年开始不断提示我它要转换成只支持FTPS, 最后期限就是今天. 从那时开始, 我就一直在琢磨怎么简单的把我的程序改成FTPS.
其实答案很简单, 早在Microsoft .NET Framework 2.0中就已经有了FtpWebRequest的支持.
<br />但是, FtpWebRequest是基于C#的. 我于是花了很多时间学习如何在我的<a href="../ar1688/20070609cn.php">MFC</a>程序中调用它, 包括修改了一大堆VC2008的编译器选项.
终于在今天及时让我的FTPS工作了起来, 留下了一大堆没有处理的程序异常.
<br />同时, 我删除了工具中所有的中文资源. 因为终于意识到了我会是这个工具唯一的使用者, 就没有必要保留额外的中文资源支持工作了.
<br /><img src=../photo/20130219.jpg alt="Screen shot of Woody's Web Tool with FTPS encryption settings Require explicit FTP over TLS" />
</p> 

<h3>调用<a name="winscp">WinSCP</a></h3>
<p>2018年1月18日
<br />去年的某一天, C#的FtpWebRequest突然罢工了. 它前一次罢工的时候, 我通过升级Windows系统和编译器解决了问题. 但是这一次, 最新的Windows 10和<a href="20140615cn.php">Visual Studio</a> 2017都没能帮上忙.
<br />那段时间刚好Yahoo的FTP也特别慢, 无奈之下我在腾讯云弄了个<a href="20120719cn.php">Linux</a>虚拟主机方便调试<a href="20100905cn.php">PHP</a>代码, 于是开始使用WinSCP开始用SCP协议跟虚拟主机同步文件.
<br />上周WinSCP提示我有更新, 正巧更新又特别慢, 无聊之下我第一次扫了一眼它的文档, 结果发现竟然可以从命令行调用它. 这下我的问题解决了, 赶快削尖铅笔在我的工具中直接调用WinSCP完成FTP的工作.
</p> 

<h3>无法打开文件MSCOREE.lib</h3>
<p>2020年7月11日
<br />Sony退出笔记本电脑市场后我失去了品牌忠诚度, 先后买了一台17寸的HP, 一台14寸的DELL和一台17寸的联想. 6月份端午假期期间, 最新的联想和DELL居然同时屏幕坏了. 被迫应急买了一台24寸的DELL一体机.
多年来第一次用中文版本的WINDOWS, 发现调用<a href="#winscp">WinSCP</a>后LOG文件中<b>Upload successful</b>变成了<b>上传成功</b>, 必须修改判断重新编译<a href="#webtool">Woody的网站工具</a>.
<br />在一体机上新装了Visual Studio 2019, 结果VS2017下能编译的网站工具罢工了, 提示无法打开文件MSCOREE.lib. 百度了一下, 碰到这个问题的人不少, 满屏都是如何找老文件的解决方案, 实在蠢得不能忍.
用bing的国际版查了一下英文社区, 同样很多人碰到了这个问题, 不过解决方案靠谱多了, 原来安装时缺省是不装C++/CLI模块的, 补充安装一下就好.
<br /><img src=../photo/20200711.jpg alt="My broken DELL hand LENOVO notebook, original photo taken on Jun 14, 2019" />
</p> 

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
