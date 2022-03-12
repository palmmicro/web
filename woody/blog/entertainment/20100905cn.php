<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>我的第一个PHP程序</title>
<meta name="description" content="Palmmicro PA6488开发的副产品. 我的第一个PHP程序: 用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除).">
<?php EchoInsideHead(); ?>
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
现在用户已经可以注册帐号测试. 由于基于PA6488的摄像头还没有面世, 用户可以先在这个网络日志上测试评论功能. 只有注册用户才能发表评论. 
<br />这就是我的第一个PHP程序: 用户和网络日志评论的CRUD(Create创建/Retrieve读取/Update更新/Delete删除). 
<br /><img src=../photo/phpisbest.jpg alt="PHP is the best programming language in the world!" />
</p> 
<blockquote><font color=gray>女神: 你能让这个论坛的人都吵起来, 我今晚就跟你走. 
<br />程序猿: PHP语言是最好的语言!
<br />论坛炸锅了, 各种吵架. 
<br />女神: 服了你了, 我们走吧, 你想干啥都行. 
<br />程序猿: 今天不行, 我一定要说服他们, PHP语言是最好的语言. 
</font></blockquote>

<h3>查询公网<?php EchoNameTag('ip', ACCOUNT_TOOL_IP_CN); ?></h3>
<p>2017年3月9日
<br />因为偶然注意到CL和USO自动校准的数据异乎寻常的多, 让我发现了从去年11月中旬开始, 就有一个网络爬虫从相连的2个IP地址以每秒2次的频率自动爬<a href="../../res/sz162411cn.php">华宝油气</a>等4个页面, 持续爬了快4个月了.
在惊讶之余, 我的第一反应是每个月9.99美元的跑PHP代码的Yahoo网站服务太值了, 处理如此辛勤的爬虫, 竟然没有让我这种最常用用户感觉到任何性能上的变化, 看来未来即使正常访问量提高100倍都能应付过来.
其实我估值软件每分钟才访问一次<a href="20151225cn.php">新浪股票数据</a>, 所以爬虫每秒都来爬是没有任何意义的, 每分钟来爬一次足够了.
<br />我的第二反应, 是赶快加了一个对单个IP地址访问<a href="../palmmicro/20080326cn.php">Palmmicro</a>.com的次数<a href="../../../account/visitorcn.php">统计</a>. 每当访问次数累计到1000次就强制要求登录一次.
爬虫很快就被暂时挡在了数据之外, 不过这也会在以后给正常访问的常用用户带来一点小麻烦. 
<br />同时我很清醒的认识到, 为了克服我设置的这个小障碍, 爬虫要实现自动登录其实是很容易的. 另外即使是目前这种状态, 依旧有每秒2次的访问压在登录页面上, 一样给服务器带来了不必要的额外压力.
<br />十多年前当我在<a href="../../../pa1688/indexcn.html">PA1688</a>上做H.323的时候, 曾经费尽心力从<?php EchoExternalLink('https://www.whatismyip.com'); ?>这种类似网站查询PA1688所在的公网IP地址, 留下了很坎坷的回忆.
<br />而今天在处理完网络爬虫的问题后, 我突然意识到查询公网IP已经成了现成的副产品, 激动之余写了这个<?php EchoIpAddressLink(); ?>的工具.
</p>

<h3><?php EchoNameTag(PAGE_TOOL_EDIT, ACCOUNT_TOOL_EDIT_CN); ?>用户界面</h3>
<p>2017年4月10日
<br />做完<?php EchoNameLink('ip', ACCOUNT_TOOL_IP_CN); ?>这个最简单的单行输入然后把输入显示出来的用户界面后, 发现自己无意中实现了一个副产品.
一直有人用各种参数试探攻击我的网页, 所以我早就想解码这些%3A%2F%2F然后显示出来看看到底是些什么参数, 没想到这个界面调用urldecode后就直接实现了这个<?php EchoEditInputLink(); ?>功能.
<br />另外一个我一直想解码显示的是从1970年1月1日开始所有秒数Unix的时间戳, 也顺手加了is_numeric区分后显示出来.
</p>

<h3><?php EchoNameTag(TABLE_COMMON_PHRASE, ACCOUNT_TOOL_PHRASE_CN); ?></h3>
<p>2017年12月26日
<br />记得2000年刚到硅谷工作, 去电影院的时候总会在正片播放前看到一段让我自我感觉膨胀的广告. 大意是如果你知道一个等号和两个等号的区别, 就可以在我们这里找份工作了!
写PHP还需要知道三个等号跟前两个的区别. 事实上对习惯了C语言的人来说是个坑, 我今天就不幸踩了一个.
<br />在修改用来方便<a href="20141016cn.php">股票</a>交易记录的<?php EchoCommonPhraseLink(); ?>代码的时候, 我无意中在<?php EchoExternalLink('https://www.php.net/'); ?>上看到有关<i>strstr</i>的一个信息:
<br /><font color=gray>如果你仅仅想确定needle是否存在于haystack中, 请使用速度更快, 耗费内存更少的<i>strpos</i>函数.</font>
<br />我马上如获至宝当即改用了几十个<i>strpos</i>, 却发现有些像<font color=gray><code>if (strpos($str, 'www.'))</code></font>的代码变得不工作了. 
原因是<i>strpos</i>会返回位置0, 这时候要写成<font color=gray><code>if (strpos($str, 'www.') !== false)</code></font>, 才跟原来<font color=gray><code>if (strstr($str, 'www.'))</code></font>的代码效果一致.
<br />不过这不是我碰到的最深的PHP坑. 最坑人的PHP函数是<i>array_merge</i>, 它在全数字下标的时候居然会把所有数字下标从头开始排序!
这时候要把<font color=gray><code>$ar = array_merge($arA, $arH, $arUS);</code></font>简单的写成<font color=gray><code>$ar = $arA + $arH + $arUS;</code></font>
反过来, 加法也不能随便写, 无下标数组写加法也会出错!
</p>

<h3><?php EchoNameTag(TABLE_PRIME_NUMBER, ACCOUNT_TOOL_PRIME_CN); ?></h3>
<p>2019年4月12日
<br />昨天是王小波忌日, 让我对自己的胸闷和牙疼症状充满了警惕. 最近整理<a href="20150818cn.php">华宝油气净值</a>的软件代码真有种死去活来的感觉, 经常让我怀疑自己到底在干什么.
今天看到这个图片, 我觉得自己该做点简单的东西恢复一下信心, 就削尖铅笔写了这个<?php EchoPrimeNumberLink(); ?>的工具.
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
<br />当然还有像Pollard Rho这种效率更高的分解质因数算法, 不过看看这些有关质数的文章: <?php EchoExternalLink('https://taodaling.github.io/blog/2019/04/03/Pollard-Rho-%E5%9B%A0%E5%BC%8F%E5%88%86%E8%A7%A3/'); ?>
<br />是不是很容易觉得自己是数学白痴?
<br />不过我还是很积极的在php下新建了一个子目录tutorial, 把这个新文件<b>primenumber.php</b>放了进去. 
同时开始憧憬万一几年后我真的开始自己做软硬件课件教<a href="20141204cn.php">林近岚</a>编程序的话, 今天这些工作可以做为其中的一节软件课. 
<br /><font color=gray>做人要是没有梦想, 跟咸鱼有什么两样?</font>
</p>

<h3>用Cramer法则<?php EchoNameTag('cramersrule', ACCOUNT_TOOL_CRAMER_CN); ?></h3>
<p>2019年9月5日
<br />过去2个月XOP持续暴跌吸引了大量抄底华宝油气的, 在很短时间内耗光了华宝基金公司的外汇额度. 华宝油气从7月31日起单日单个基金账户累计申购金额上限设置为10万, 8月2日周五限额变成了1万, 8月9日限额变成1000元人民币.
就像超新星爆发给天文学家提供了难得的测距参考一样, 限购给我提供了少有的观察套利者的机会, 所以我每天都在乐此不疲的追踪相关数据.
<br />8月29日华宝油气收盘价0.387, 跟8月28日0.385的净值比溢价0.52%. 很多溢价申购套利老手都不会放弃这个蚂蚁也是肉的赚钱机会.
<br />9月5日华宝油气场内新增72万股, 由于9月2日美股休市暂停申购, 这个数据可以看成是对应8月29日场外申购后转场内的份额. 假如都是在华宝官网0.1折最低费用申购的话, 限购1000块人民币下满额申购了:
<br />720000/(998.5/0.397) = 286场外帐户
<br />再回头看一下9月3日, 华宝油气场内新增695万股. 假如这些新增都来自场内申购的话, 对应8月29日场内限购1000块人民币下满额申购了:
<br />6950000/(985/0.397) = 2801场内账户
<br />之前还有一个机会可以同样看到在同一天场外申购的账户数比场内申购的账户数小一个数量级的情形, 可以跟这个结果交叉验证.
<br />8月13日场内新增7408万股, 假定全部来自于8月6日(溢价1.78%)场外申购转场内和8月8日(溢价2.3%)的场内申购. 假定每户都是用满1万申购额度, 8月8日场内申购的净值为0.402, 场内一折券商实际使用了9850块申购, 每户实际到账2.450万股.
假定场外都是使用华宝官网0.1折, 实际使用申购金额为9998.5, 8月6日申购的净值为0.391, 每户实际到账2.557万股. 用未知数x表示场内申购的账户数, 未知数y表示场外申购转场内的账户数, 假定在我们考虑的最近一段时间这2个账户数都是固定不变的.
由此得出第一个方程:
<br />2.450 * x + 2.557 * y = 7408
<br />8月14日华宝油气场内新增810万股, 本来按上面的逻辑新增应该全部来自于8月7日(溢价1.53%)场外申购转场内和8月9日(折价0.25%)的场内申购. 
8月9日是场内申购限购1000的第一天, 不过可惜这天场内交易折价0.25%, 应该同时出现了大量不限金额的赎回. 多了一个无法定量的赎回变量, 导致8月14日的数据无法像上面那列第2个方程.
<br />8月15日场内新增1099万股, 继续按前面的假设列方程. 对应最后一天限购1万的8月8日(溢价2.3%)场外转场内, 和限购1000的8月12日(溢价1.01%)场内申购. 8日申购净值是0.402, 12日申购净值是0.393. 可以列出方程:
<br />(985/0.393/10000) * x + (9998.5/0.402/10000) * y = 1099
<br />保留4位有效数字合并常数后得到第二个方程:
<br />0.2506 * x + 2.487 * y = 1099
<br />使用Cramer法则<?php EchoCramersRuleLink(); ?>的通用工具, 得到场内申购户数 x = 2864, 场外申购户数 y = 153.
<br />原则上来说按我的假设, 任何2天的数据都可以用来联立一个2元一次方程组, 解出场内申购和场外申购的账户数. 
我一定要选择从限购1万到限购1000的变化时2天的数据来估算是出于计算精度的考虑, 为了避免2个大数字相减后得到一个跟误差范围同一数量级的小数字, 让整个结论失去意义.
<?php echo ImgCramersRule(); ?>
</p> 
<blockquote><font color=gray>And what in heaven's name brought you to Casablanca?
<br />My health. I came to Casablanca for the waters.
<br />The waters? What waters? We're in the desert.
<br />I was misinformed.
</font></blockquote>

<h3>一元<?php EchoNameTag('linearregression', ACCOUNT_TOOL_LINEAR_CN); ?>工具</h3>
<p>2019年9月20日
<br />用<?php EchoLinearRegressionLink(); ?>计算完华宝油气限额申购下溢价套利的<?php EchoNameLink('fundaccount', FUND_ACCOUNT_DISPLAY, '20150818cn.php'); ?>后, 顺便把它做成了一个通用工具.
<?php echo ImgLinearRegression(); ?>
</p>

<h3><?php EchoNameTag('benfordslaw', ACCOUNT_TOOL_BENFORD_CN); ?></h3>
<p>2019年11月14日
<br /><?php EchoBenfordsLawLink(); ?>
<br /><img src=../photo/benfordslaw.jpg alt="Benford's Law equation" />
</p>

<h3><?php EchoNameTag('chisquaredtest', ACCOUNT_TOOL_CHI_CN); ?></h3>
<p>2019年11月15日
<br /><?php EchoChiSquaredTestLink(); ?>
<?php echo ImgChiSquared(); ?>
</p>

<h3>UTF8的双字节空格字符</h3>
<p>2021年6月22日
<br />收到来自<a href="../palmmicro/20161014cn.php">微信公众号</a>的通知邮件, 说有用户查询<font color=green>161116&nbsp;</font>没有找到匹配的信息后, 我简直不敢相信自己的眼睛.
<br />登录公众号管理系统后, 我把用户发送的内容复制到了微信PC版本的输入界面中, 显示除了161116外, 还额外换了2行, 果然这样发出去是会匹配失败的, 其中应该包含了我没想到过的未知字符.
<br />在<?php EchoNameLink(PAGE_TOOL_EDIT, ACCOUNT_TOOL_EDIT_CN); ?>用户界面加了16进制显示后, 发现161116后多了一个0x20的空格. 我猜可能因为输入控件是单行的所以换行被过滤掉了, 干脆就放弃了自己分析未知字符.
<br />目前我用的jEdit编辑器没有16进制显示的功能, 于是我去下载了一个很多年没再用过的UltraEdit, 然而它显示161116后是20 0D 0A, 这3个太正常了, 早已经在<font color=gray><code>$strText = trim($strText, " ,.\n\r\t\v\0");</code></font>中处理过.
<br />这下黔驴技穷了, 只好找用户问到底输入了什么. 被告知是从一篇微信公众号文章复制过来的, 我跑去看页面源代码, 发现原文是<font color=green>161116&amp;nbsp;</font>, 微信复制后产生了一个UTF8的双字节空格字符,
加了一句<font color=gray><code>$strText = str_replace("\xC2\xA0", '', $strText);</code></font>后终于解决问题.
</p>

<h3><?php EchoNameTag('dicecaptcha', ACCOUNT_TOOL_DICE_CN); ?></h3>
<p>2021年7月2日
<br />罗布乐思Roblox<?php EchoDiceCaptchaLink(); ?>
<?php echo ImgRobloxDice(); ?>
</p>

<h3><?php EchoNameTag('sinajs', ACCOUNT_TOOL_SINAJS_CN); ?></h3>
<p>2022年1月21日
<br />在新浪股票数据接口加上Referer检查后，不能直接用浏览器看结果了，加上<?php echo GetSinaJsLink(); ?>调试页面。
</p>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
