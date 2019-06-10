<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>我的第一个PHP程序</title>
<meta name="description" content="Palmmicro PA6488开发的副产品. 我的第一个PHP程序: 用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除).">
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>我的第一个PHP程序</h1>
<p>2010年9月5日
<br />第一次听到PHP是从一个<a href="../../../ar1688/indexcn.html">AR1688</a>开发者那里. 他告诉我他在网页界面中写了些PHP代码自动计算网页总字节大小, 这样可以避免AR1688网页界面因为超过大小限制而静悄悄的自动罢工.
不过我现在知道他有关PHP的部分并不正确, 也许他想说的是Javascript的代码. 
<br />隔了段时间, <a href="../../../res/translationcn.html#webhosting">Yahoo网站服务</a>提示我把这个网站从PHP4升级到PHP5. 这是第二次, 我意识到了PHP就在我身边. 
<br />两个月前我知道了一个做电子商务的创业公司, 询问他们用什么语言开发, 结果在答案中又听到了PHP. 当时我很高兴, 觉得自己之前已经听说过两次了, 应该对它不再是一无所知. 
<br />由于我已经有了这么多PHP知识, 当<a href="../../../pa6488/indexcn.html">PA6488</a>摄像头管理器软件<a href="../../../pa6488/software/cammancn.html">CamMan</a>需要用户管理功能的时候, 我马上开始了在公司网站的PHP开发.
现在用户已经可以在<a href="../../../account/registercn.php">这里</a>注册帐号测试. 由于基于PA6488的摄像头还没有面世, 用户可以先在这个网络日志上测试评论功能. 只有注册用户才能发表评论. 
<br />这就是我的第一个PHP程序: 用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除). 
</p> 
<blockquote><font color=grey>女神: 你能让这个论坛的人都吵起来, 我今晚就跟你走. 
<br />程序猿: PHP语言是最好的语言!
<br />论坛炸锅了, 各种吵架. 
<br />女神: 服了你了, 我们走吧, 你想干啥都行. 
<br />程序猿: 今天不行, 我一定要说服他们, PHP语言是最好的语言. 
</font>
</blockquote>

<h3>查询公网<a name="ip">IP</a>地址</h3>
<p>2017年4月1日
<br />十多年前当我在<a href="../../../pa1688/indexcn.html">PA1688</a>上做H.323的时候, 曾经费尽心力从<?php EchoLink('https://www.whatismyip.com'); ?>这种类似网站查询PA1688所在的公网IP地址, 留下了很坎坷的回忆.
<br />而今天在处理完<a href="20170309cn.php">网络爬虫</a>的问题后, 我突然意识到查询公网IP已经成了现成的副产品, 激动之余写了这个<a href="../../../account/ipcn.php">IP地址数据</a>的工具.
</p>

<h3>临时<a name="editinput">测试</a>用户界面</h3>
<p>2017年4月10日
<br />做完<a href="#ip">IP地址</a>这个最简单的单行输入然后把输入显示出来的用户界面后, 发现自己无意中实现了一个副产品.
一直有人用各种参数试探攻击我的网页, 所以我早就想解码这些%3A%2F%2F然后显示出来看看到底是些什么参数, 没想到这个界面调用urldecode后就直接实现了这个<a href="../../../account/editinputcn.php">功能</a>.
</p>

<h3>个人常用<a name="commonphrase">短语</a></h3>
<p>2017年12月26日
<br />记得2000年刚到硅谷工作, 去电影院的时候总会在正片播放前看到一段让我自我感觉膨胀的广告. 大意是如果你知道一个等号和两个等号的区别, 就可以在我们这里找份工作了!
写PHP还需要知道三个等号跟前两个的区别. 事实上对习惯了C语言的人来说是个坑, 我今天就不幸踩了一个.
<br />在修改用来方便<a href="20141016cn.php">股票</a>交易记录的<a href="../../../account/commonphrasecn.php">输入</a>代码的时候, 我无意中在<?php EchoLink('https://www.php.net/'); ?>上看到有关<i>strstr</i>的一个信息:
<br /><font color=gray>如果你仅仅想确定needle是否存在于haystack中, 请使用速度更快, 耗费内存更少的<i>strpos</i>函数.</font>
<br />我马上如获至宝当即改用了几十个<i>strpos</i>, 却发现有些像<font color=gray><code>if (strpos($str, 'www.'))</code></font>的代码变得不工作了. 
原因是<i>strpos</i>会返回位置0, 这时候要写成<font color=gray><code>if (strpos($str, 'www.') !== false)</code></font>, 才跟原来<font color=gray><code>if (strstr($str, 'www.'))</code></font>的代码效果一致.
<br />不过这不是我碰到的最深的PHP坑. 最坑人的PHP函数是<i>array_merge</i>, 它在全数字下标的时候居然会把所有数字下标从头开始排序!
这时候要把<font color=gray><code>$ar = array_merge($arA, $arH, $arUS);</code></font>简单的写成<font color=gray><code>$ar = $arA + $arH + $arUS;</code></font>
</p>

<h3>分解<a name="primenumber">质因数</a></h3>
<p>2019年4月12日
<br />昨天是王小波忌日, 让我对自己的胸闷和牙疼症状充满了警惕. 最近整理<a href="20150818cn.php">华宝油气</a>估值工具的软件代码真有种死去活来的感觉, 经常让我怀疑自己到底在干什么.
今天看到这个图片, 我觉得自己该做点简单的东西恢复一下信心, 就削尖铅笔写了这个<a href="../../../account/primenumbercn.php">分解质因数</a>的工具.
<br /><img src=../photo/primenumber.jpg alt="The picture that encouraged me to write this prime nnumber tool." />
<br />分解质因数可以用最直接的方式实现, 对指定的数字n, 从2开始一个个反复除到n的平方根为止就行了. 下面用数字68举个具体的例子.
</p>
<ol>
  <li>68的平方根在8和9之间, 我们从2到8都除一遍就可以了. 68/2=34, 68=2*?.</li>
  <li>因为34还是偶数, 继续来除2. 34/2=17, 68=2*2*?.</li>
  <li>17不是3的整数倍数.</li>
  <li>17不是4的整数倍数. 这里可以看到, 虽然原来68是4的整数倍数, 但是我们已经在前面处理过了.</li>
  <li>对数字5来说, 因为5*5已经比17大, 我们不用继续除下去了, 最终结果就是68=2*2*17.</li>
</ol>
<p>接下来一个最直接的优化想法, 就是先把一定范围内的已知质数算出来, 这样我们在进行上面的计算时, 就不用算17是不是4的整数倍数了.
基于<a href="20101107cn.php">GB2312</a>大数组的教训, 我这次直接把前4972个质数存到了MySQL的表中. 不过结果让我很失望, 查MySQL已知质数表的结果反而要比直接算慢很多倍.
<br />当然还有像Pollard Rho这种效率更高的分解质因数算法, 不过看看这些有关质数的文章: <?php EchoLink('https://taodaling.github.io/blog/2019/04/03/Pollard-Rho-%E5%9B%A0%E5%BC%8F%E5%88%86%E8%A7%A3/'); ?>
<br />是不是很容易觉得自己是数学白痴?
<br />不过我还是很积极的在php下新建了一个子目录tutorial, 把这个新文件<?php EchoPhpFileLink('/php/tutorial/primenumber'); ?>放了进去. 
同时开始憧憬万一几年后我真的开始自己做软硬件课件教<a href="20141204cn.php">林近岚</a>编程序的话, 今天这些工作可以做为其中的一节软件课. 
<br /><font color=grey>做人要是没有梦想, 跟咸鱼有什么两样?</font>
</p>

<h3>查询<a name="xueqiufriend">雪球关注</a>的人</h3>
<p>2019年4月24日
<br />做完<a href="#primenumber">分解质因数</a>后自我感觉很好, 所以我很快又给自己找了个新的小目标, 挽起袖子写了个<a href="../../../php/xueqiufriend.php">雪球关注工具</a>.
<br />雪球有关注人数2000的上限, 对于一个像我这样乐于相互关注的人来说, 经常会碰到想新关注一个人的时候不知道该取消关注谁的问题. 雪球上可以查看关注的人, 每页显示20个, 查看所有2000个关注需要翻页100次.
我因此写了这个软件来自动做这100次翻页, 从中挑出从来不发言的人, 除我关注外没有其它粉丝的人, 以及跟我一样有接近2000关注的人. 本来我还挑出了没有自选股的人, 不过这个数据不准, 经常点进去用户雪球页面后发现有一堆自选股, 我就放弃了.
从<a href="../palmmicro/20080326cn.php">Palmmicro</a>.com所在的Yahoo服务器跨越太平洋访问雪球, 每次要接近2秒时间, 连续100次就会慢的让人不可忍受. 
还好我有一直闲置的腾讯云<a href="20120719cn.php">Linux</a>虚拟机, 使用<?php EchoLink('http://111.230.12.222/php/xueqiufriend.php'); ?>, 大约能在40秒内返回结果, 勉强可用.
<br />其实最应该被挑出来取消关注的是没有相互关注我的人. 在没有账号登录信息的情况下, 这意味着要把我的2000个关注人的全部关注页面都再次读一遍. 当然在时间上这是不现实的, 雪球自己的页面也不会愚蠢到这么做.
事实上, 如果能在Cookie中提供一点登录信息, 雪球就会在数据中提供相互关注的信息了. 跨域名访问Cookie是严重的安全性问题, 因此这几乎不可能自动做. 要用这个工具查没有跟自己雪球账号相互关注的, 只能自己先登录雪球后, 按下图在Chrome浏览器中找到Cookie位置.
<br /><img src=../photo/xueqiu20190424.jpg alt="Apr 24, 2019. Xueqiu woody1234 page and chrome Cookie entry." />
<br />然后点进去在下图中找到xq_a_token对应的值, 肯定不会是现在显示的这个.
<br /><img src=../photo/xueqiucookie.jpg alt="Chrome Cookie settings where to find xueqiu.com xq_a_token value." />
<br />然后手工把它放在对应的输入框中即可.
<br /><font color=grey>Life is like a snowball. The important thing is finding wet snow and a really long hill. — Warren Buffett</font>
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
