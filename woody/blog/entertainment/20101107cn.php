<?php require_once('php/_20101107.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>网络日志搬家 - GB18030和GB2312</title>
<meta name="description" content="记录把MSN网络日志从aredfox.spaces.live.com搬家到Palmmicro网站的过程, 从GB2312, GB18030到UTF-8的领悟, 以及后知后觉开始学习开发网站软件的经历.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>网络日志搬家 - GB18030和GB2312</h1>
<p>2010年11月7日
<br />微软宣布把MSN网络日志搬家到wordpress的时候我正好在美国, 点了几下鼠标就顺利完成了搬家工作.
等我回到北京后却发现打不开<?php EchoLink('https://woody1234.wordpress.com'); ?>的页面, 于是决定把我的MSN网络日志手工搬迁到我的Palmmicro网络日志上来.
<br />在一个月见缝插针的陆续工作后, 到今天我已经搬了37篇日志过来, 同时把<a href="../palmmicro/20080326cn.php">Palmmicro</a>.com到aredfox.spaces.live.com的链接从130个减少到了10个.
<br />今天晚上我在检查搬家效果, 发现1/5的中文日志在我64位英文版Windows Vista下用英文版IE8看的时候偶尔会有乱码, 但是同一台笔记本下运行的Firefox和Chrome都能正常浏览.
进一步测试发现如果我把IE8菜单中的Encoding改成GB2312就能正常工作, 并且即使再次改回原来的GB18030也能显示正确.
<br />在把我所有中文页面的meta部分中charset=gb18030改为charset=gb2312后, 所有3个浏览器都能正常看我全部的中文页面了.
</p>

<h3>网络日志搬家 - 翻译</h3>
<p>2010年11月10日
<br />经过过去一个月的热身, 我这3天一直在集中精力给网络日志搬家. 不过进度并不好, 虽然我已经消灭掉了最后10个Palmmicro.com到aredfox.spaces.live.com的链接, 搬家总数只从37增加到了56.
我估计还有50篇左右没有搬, 按照现在的进度还要整整8天时间.
<br />为什么会这么慢? 主要的时间耽误在了翻译上. 大多数2009前写的日志都不是我自己翻译成中文的, 或者根本没有翻译过. 结果我现在花了大量的时间翻译它们!
我甚至做了个新<a href="../../../res/translationcn.html">页面</a>记录常用词组的翻译.
<br />前些时候有人问过我先写哪个语种版本, 我回答当然是英文. 要是先写中文, 就不知道该怎么翻译成英文了!
<br />可悲的是, 从英文翻译成中文也是很不容易的, 很多中国人都跟我说他们也看不懂我的中文版本内容.
</p>

<h3>网络日志搬家 - 总结</h3>
<p>2010年11月14日
<br />在一个月的热身和连续8天集中日夜赶工后, 我终于把98篇网络日志从MSN空间搬到了Palmmicro网站. 
<br />不到10篇老日志被抛弃了, 主要是因为其中讨论的<a href="../../../ar1688/indexcn.html">AR1688</a>技术细节今天来说已经不正确. 
除了增加了很多新的翻译外, 我还在不同页面间增加了很多链接, 修改了明显的错误. 要保持原样实在太不容易了, 我现在相当能理解为什么金庸要在过去30年中翻来复去的改他那15本小说.
<br />所有原来的评论都抛弃了, 很可惜但是没有办法, 我总不能帮别人搬评论吧. 
<br />为什么不留在wordpresss.com? 答案如下:
</p>
<ol>
  <li>实际上5月份的时候我就想把MSN空间的日志搬到公司网站了. 当时我在自己主页上开始日志, 把MSN空间做为备份. 但是巨大的搬家工作量让我犹豫不前, 很高兴微软最终帮我做了选择.</li>
  <li>国内访问wordpress.com不是被封杀了就是特别慢. 而且我看不出在可以预见的将来它有什么理由不会被<a href="../palmmicro/20100427cn.php">GFW</a>封杀.</li>
  <li>自动转换到wordpress.com的效果并不像宣传的那么好. 转换后的文本中丢失了很多' ', '\0'和'''之类的字符. 另外在中文下显示的时候, wordpress会自作聪明的把很多标点符号转换成中文版本, 让整个页面看上去蠢死了.</li>
</ol>
<p><a href="../../../tangli/index.html">唐丽</a>也在把自己的MSN空间往Palmmicro网站搬. 新加了这么多页面后, 我们网站接下来的访问统计数据估计会大大增加.
下面的图片显示了过去30天中从全世界230个城市对我们的885次访问, 共浏览了6,649个页面. 
<br /><img src=../photo/20101114.jpg alt="Google Analytics reports of Palmmicro.com visitor location information on Oct, 2010." />
</p>

<h3>Palmmicro网页访问者使用的浏览器统计</h3>
<p>2011年3月28日
<br />随着IE9和Firefox4的推出, 各类浏览器的新闻再次风起云涌. 其中最令人不安的是听说360在跟<b>GFW之父</b>合作, 打算给中国用户提供安全的网络浏览器.
<br />360同时在宣称, 根据百度的统计, 有18%的客户在使用360浏览器. 我使用了Google Analytics统计对Palmmicro.com的访问. 从下图中可以看到根据Google统计的Palmmicro网页访问者使用的浏览器情况.
<br />在过去的30天中, 有1072次访问来自69个国家地区的294个城市, 总共看了6,619个页面, 跟4个月前基本上相同. 
<br /><img src=../photo/20110328.jpg alt="Google Analytics reports of Palmmicro.com visitor web browser usage on Mar, 2011." />
</p>

<h3>用UTF-8替换GB2312</h3>
<p>2012年3月8日
<br .>在<a href="../ar1688/20080216cn.php">GB2312</a>的伴随中长大, 过去2年中又被微软的双字节unicode搞得困惑不已, 我在绝大多数时间都没有重视过UTF-8.
可笑的是在2010年末的时候我还在比较GB18030和GB2312. 随着在过去的一年中我收到了越来越多iPad上发出来的用UTF-8编码的中文邮件, 考虑到苹果一直吹嘘它的产品的易用性, 我开始觉得UTF-8肯定很重要.
<br />进一步的调查让我吃惊. 在我经常访问的数十个网站中, 目前仅有<a href="http://www.newsmth.net/" target=_blank>SMTH</a>和<a href="http://tianya.cn/" target=_blank>天涯</a>的论坛部分没有使用UTF-8.
为了与时俱进,我从上周末开始把Palmmicro网站从GB2312转换到UTF-8编码.
<br />跟平常一样, 这个工作量又超过了我的预计. 我花了些时间修改<a href="20100529cn.php">Visual C++</a>写的Woody的网站工具, 以及更多的时间学习设置VC2008的编辑器来编辑UTF-8编码的文件.
这个愚蠢的编辑器永远需要手工把文件另存为UTF-8 without signature.
<br />再一次我抛弃了不少原来存成了GB2312编码的网络日志评论. 仍然还是一个<a href="20100905cn.php">PHP</a>和MySQL编程新手,
我没有找到一个类似Windows下的<i>MultiByteToWideChar</i>函数这样简单的办法转换目前MySQL数据库中的GB2312数据, 只好用这种野蛮方式草草结束工作.
</p>

<h3>用PHP把GB2312编码字符串转换成<a name="utf8">UTF-8</a></h3>
<p>2016年6月9日
<br .>最近一直在扩展<a href="20150818cn.php">华宝油气净值</a>的功能. 
陆陆续续改了这么多年网页, 原本计划的<a href="../../../pa6488/indexcn.html">PA6488</a>和<a href="../../../pa3288/indexcn.html">PA3288</a>产品都还没有用上互联网管理功能, palmmicro.com却眼看要成为业余<a href="20141016cn.php">股票</a>网站了.
<br .>随着涉及的股票越来越多, 我打算用直接采用<a href="20151225cn.php">新浪股票数据</a>中的股票名称和说明, 避免手工一个个输入. 结果四年前碰到的问题又回来了, 新浪的数据还在用GB2312编码,
而我反复折腾<i>mb_detect_encoding</i>和<i>iconv</i>等PHP函数都无法把GB2312转换成UTF-8.
<br .>不过我已经不是当年的吴下阿蒙了. 我先上网找来了GB2312和UNICODE的<a href="http://blog.csdn.net/longronglin/article/details/1355890" target=_blank>对应码表</a>, 
然后写了个转换工具, 生成了按照GB2312作为key排序后的对应数组$arGB2312, 
最后在函数<i>GbToUtf8</i>中把从$arGB2312查表得到的UNICODE调用网上找来的小函数<a href="https://segmentfault.com/a/1190000003020776" target=_blank><i>unicode_to_utf8</i></a>转换成UTF8.
整个过程耗时一个晚上一气呵成, 感觉好极了!
</p>

<h3>从MySQL表中查找<a name="gb2312">GB2312</a>对应的UNICODE</h3>
<p>2018年2月16日
<br />随着我的股票网站软件功能越来越繁多, 对网站的访问也越来越不稳定, 经常需要重新刷新一次才能正常显示页面. 很久以来我一直认为是从中国访问在美国的Yahoo网站服务不稳定造成的, 也就一直没有深究.
<br />这个春节在圣地亚哥溜娃一个月, 我很悲哀的发现, 在美国访问网站也经常需要重新刷新. 联想到Google总是利用Chrome浏览器的输入抢先一步爬一下我要访问的网页的坏习惯, 我意识到一定是程序哪里出现了执行效率问题, 不能正确回应2个几乎同时的页面请求.
庞大的$arGB2312全局数组马上成了最大的疑犯.
<br />在我把全局数组放进函数后, 情况更加恶化了. 需要重新刷新的情况看上去像是少了一点, 却出现了/php/<b>switch.php</b>文件中<b>$_SESSION['userurl']</b>这种全局数据被莫名其妙的冲掉的问题.
<br />好在经过这么多年后, 我对MySQL已经没有那么畏惧, 在溜娃间隙中削尖铅笔在/php/sql/<b>sqlgb2312.php</b>文件中增加了一个GB2312和UNICODE的对应表, 把查内存中的大数组改成了查数据库, 终于解决了这个困扰了我一年半的刷新问题.
<br />发现帮助傻瓜编程的PHP也对程序优化有要求还是挺让我兴奋的, 觉得这么多年来的优化软件经验终于又有用武之地了.
<br /><img src=../photo/mermaid.jpg alt="Feb 3, 2018. Mermaid and Sapphire in SeaWorld San Diego." />
</p>

<h3>终究躲不过去的<a name="gb18030">GB18030</a></h3>
<p>2018年4月16日
<br />在给Palmmicro<a href="../palmmicro/20161014cn.php#abcompare">微信公众号</a>增加了B股的数据后, 意外发现SZ200168股票名字中的<b>喆</b>字在GB2312转<a href="#utf8">UTF-8</a>后成了乱码.
发现了一只蟑螂就说明有一窝. 我把数据库中所有股票名字查看了一遍后, 果然发现了SZ002752和SZ300208中的<b>昇</b>字也是乱码.
<br />产生乱码的原因很明显, 这2个生僻字本身就不在只有6000多汉字的GB2312中. 这意味着我需要一个GB18030和UNICODE的对应码表来扩展我的MySQL数据表: <?php EchoLink('http://icu-project.org/repos/icu/data/trunk/charset/source/gb18030/gbkuni30.txt'); ?>.
花了差不多一天功夫做完这些几乎算是推倒重来的修补后, 我不禁又有了一种神功已成的感觉. 
<?php EchoUpdateGbUtfLink(); ?>
<br /><font color=gray>欲练神功, 必先自宫. 虽然自宫, 未必成功. 如不自宫, 也可成功.</font>
<br /><img src=../photo/solitaire.jpg alt="Jan 29, 2018. Solitaire Sapphire in LEGOLAND CALIFORNIA." />
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
