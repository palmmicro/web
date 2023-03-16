<?php require_once('php/_20150818.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>华宝油气净值估算的PHP程序</title>
<meta name="description" content="根据SPDR标普油气开采指数ETF(XOP)、标普油气开采指数(^SPSIOP)和美元对人民币的汇率计算QDII基金华宝油气(SZ162411)净值的PHP程序的开发过程记录。">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<?php DemoPrefetchData(); ?>

<div>
<h1>华宝油气净值估算的PHP程序</h1>
<p>2015年8月18日
<br />眼看Qualcomm收购CSR<?php echo GetLinkElement('股票', '20141016cn.php'); ?>的现金快要到账，最近我在琢磨在A股中国特色的QDII基金华宝油气和美股XOP之间套利。每天看Yahoo新浪等网站的股票行情，时不时还要用鼠标点开计算器算算转换价格，时间长了后有点烦。
<br />后来我想起来5年前学习的<?php echo GetLinkElement('PHP', '20100905cn.php'); ?>，于是打算写我的第二个PHP程序，统一把套利需要常看的行情显示在一起。
同时根据SPDR标普油气开采指数ETF(XOP)、标普油气开采指数(^SPSIOP)、以及美元对人民币的汇率计算<?php echo GetStockLink('SZ162411'); ?>净值。今天出了第一版，记录下相关开发过程以备日后查阅。A股的QDII基金缺乏及时的信息更新，希望这里能够补上这个生态位空缺。
<br />谢谢<?php EchoXueqieId('6188729918', 'abkoooo'); ?>帮助提供了新浪实时美股数据接口的格式。
美股、A股、期货和汇率都用新浪实时的数据接口：<?php EchoSinaQuotesLink('gb_xop,sz162411,hf_CL,USDCNY'); ?>
<br />一开始发现无论怎么弄<?php echo GetCodeElement('fopen'); ?>打开这些链接都会失败，估计是我用的Yahoo网站服务不支持<?php echo GetCodeElement('allow_url_fopen'); ?>。 
在网上找解决方法，发现应该用早就有的curl。抄了2段curl代码，仿照<?php echo GetCodeElement('file_get_contents'); ?>函数的名字加了个<?php echo GetCodeElement('url_get_contents'); ?>函数。
<br />为提高页面反应速度，使用2个文件<?php EchoSinaDebugLink('gb_xop'); ?>和<?php EchoSinaDebugLink('sz162411'); ?>分别保存最后更新的股票数据，同时实施以下优化：
</p>
<?php echo GetListElement(array('跟文件时间在同一分钟内的页面请求直接使用原来文件内的数据。',
								  '美股盘后交易结束后的页面请求直接使用gb_xop.txt内的美股数据。',
								  'A股闭市后的页面请求直接使用sz162411.txt内的A股数据。'));
?>
<p>类似的，原油期货数据缓存在文件<?php EchoSinaDebugLink('hf_cl'); ?>，美元人民币汇率数据在usdcny.txt。
<br /><?php echo GetQuoteElement('所有的代码最终都会烂到无法维护，成功的项目就是在烂掉之前发布出去的。'); ?>
</p>

<h3><a name="sma">SMA</a></h3>
<p>2015年8月20日
<br />为严格交易规则, 套利过程中我打算简单的在均线上下单买卖XOP. 这个版本加入下一个交易日XOP预计的常用SMA均线值,
以及当前成交价格相对于华宝油气对应净值的溢价.
<br />作为一个懒人, 我给自己预定的交易模式是盘前下单, 交易时间不盯盘. 关注过新浪等网站提供的均线指标的都知道, 这些值是随着当天的交易一直在变动的. 
因此我需要在盘前下单时先算出一个不动点用于买卖.
<br />从最简单的5日线说起:
<br />A5 = (X0 + X1 + X2 + X3 + X4) / 5;
<br />其中X0是当天交易价, X1-X4是前4个交易日的收盘价. 为方便起见, 可以把 (X1 + X2 + X3 + X4) 写成 ∑X4. 按这个模式, 任意日的简单均线SMA可以表示成:
<br />An = (X0 + ∑Xm) / n; 其中m =  n - 1;
<br />在什么时候会有一个不动点可以用于买卖呢? 显然是An = X0的时候, 这样An = (An + ∑Xm) / n, 从这个简单的一元一次方程可以解出An不依赖于X0的表达式:
<br />An = ∑Xm / (n - 1); 或者 An = ∑Xm / m;
<br />这样就很清楚了, 当我说5日线的时候, 我实际算的是前4个交易日收盘价的平均值. 当我说20周线的时候, 我实际算的是前19周每周最后一个交易日收盘价的平均值.
这样算出来的不动点是极限值, 所以我整天装神弄鬼说XOP过了什么什么均线算强势, 没过什么什么均线算弱势. 而这些装神弄鬼的背后, 其实用到的都是小学数学.
<br />XOP历史数据每天只需要更新一次, 采用Yahoo股票历史数据: <?php EchoExternalLink(YahooStockHistoryGetUrl('XOP')); ?>,
<br />同样每天只需要更新一次的还有华宝油气基金官方净值, 来自于<?php EchoSinaQuotesLink('f_162411'); ?>,
使用文件<?php EchoSinaDebugLink('f_162411'); ?>缓存, 因为不知道什么时候更新当日数据, 只好采用一个小时更新一次的笨办法.
<br />增加调试文件<?php EchoFileLink(DebugGetFile()); ?>用于临时查看数据.
</p>

<h3><a name="mobiledetect">检测手机</a></h3>
<p>2015年8月21日
<br />发了这个工具小软件链接后, 昨天翻墙出去看了一下<a href="20110509cn.php">Google</a> Analytics的统计. 上线3天, 总共289个IP访问了584次.
跟<a href="../palmmicro/20080326cn.php">Palmmicro</a>通常的客户访问网站极大不同的是, 访问这个工具的有1/3用的是手机. 于是匆忙加上为手机用户优化显示界面的代码.
<br />使用<?php EchoExternalLink('http://mobiledetect.net/'); ?>判断是否手机用户访问, 代码从github复制下来按照原开发者的建议单独放在/php/class/<b>Mobile_Detect.php</b>中.
</p>

<h3>增加<?php EchoNameTag('stockhistory', STOCK_HISTORY_DISPLAY); ?>页面</h3>
<p>2015年8月24日
<br />每次进<?php EchoExternalLink('https://palmmicro.com/apps/phpMyAdmin/'); ?>去看历史数据虽然不算麻烦, 但是毕竟还是用自己写的网页看更有成就感!
</p>
<?php EchoStockHistoryDemo(); ?>

<?php
	Echo20150827('扩大规模到'.GetNameTag('qdiihk', QDII_HK_DISPLAY));
?>

<h3>股票<a name="transaction">交易</a>记录</h3>
<p>2015年9月13日
<br />跟我的第一个PHP程序结合起来, 用户登录后可以输入相关股票交易记录. 根据交易记录计算华宝油气和XOP对冲交易策略和数据.
<br />交易记录的输入和处理分别在文件/woody/res/php/<b>_edittransactionform.php</b>和/woody/res/php/<b>_submittransaction.php</b>. 
同时修改<a href="20100529cn.php">Visual C++</a>的Woody的网站工具对_editXXXform.php名字格式的自动生成对应的_submitXXX.php文件. 
</p>

<h3>开始自己写PHP的class类</h3>
<p>2015年11月7日
<br />分离数据和用户界面代码，把QDII用到的股票数据部分放到<font color=olive>StockReference</font>类中，用在<font color=olive>_QdiiAccount</font>类中。
<br />继续整理代码，为热心吃螃蟹的用户们增加<a href="../../res/sh513100cn.php">纳指ETF</a>、<a href="../../res/sz160717cn.php">恒生H股</a>、<a href="../../res/sz160216cn.php">国泰商品</a>、<a href="../../res/sz160416cn.php">石油基金</a>、 
<a href="../../res/sz163208cn.php">诺安油气</a>和<a href="../../res/sz165510cn.php">信诚四国</a>等页面.
</p>

<h3>增加<?php EchoNameTag('fundhistory', FUND_HISTORY_DISPLAY); ?>页面</h3>
<p>2016年1月8日
<br />在<?php EchoXueqieId('2091843424', '塔夫男'); ?>等人的建议下, 加入华宝油气基金历史表格记录每天的折价溢价情况. 最近几天的直接显示在当前页面, 同时增加单独显示全部历史数据的页面.
</p>
<?php EchoFundHistoryDemo(); ?>

<h3>统一数据显示格式</h3>
<p>2016年1月26日
<br />在<?php EchoXueqieId('8907500725', 'oldwain'); ?>的建议下，在相关价格记录的时间中加入日期显示。原来版本中没有它是因为自己觉得交易日期很明显，完全没有必要出来占地方。不过既然有人觉得有问题，我就效仿白居易写诗先读给妇孺听的优良传统改了。
估计跟我从2000年开始就在美股赔钱不同，很多人还是不熟悉美国股市交易时间。而在这里，美股数据后面跟的是美东日期和时间。
<br />虽说是个小的分离数据和显示改动，但是忍不住哗啦哗啦又整理优化了一大片代码。
把原来的<?php echo GetCodeElement('StockReference'); ?>类作为基础类，原来期货和汇率数据读取分别改为继承自它的<?php echo GetCodeElement('FutureReference'); ?>类和<?php echo GetCodeElement('ForexReference'); ?>类，达到统一数据显示格式的目的。
</p>
<?php EchoReferenceDemo(); ?>
<p>华宝油气这个名称里的中文基本上大家都认识，而括号内的那些英文字母，绝大多数的美国人都不会认识。
<br />把Google设置成显示英文结果，然后查QDII，百度百科的中文页面显示在搜索结果的第2位，第3位是Wiki。听过一个笑话，一个腹黑的HR问程序员求职者碰到问题怎么办，回答去查百度的都会被默默的拒掉，因此我就不去看它了。
Wiki的QDII词条下显示了它是Qualified Domestic Institutional Investor的简称，同时用简体和繁体标注了合格境内机构投资者。
<br />跟QDII一样，<?php EchoNameTag('lof'); ?>也是一个出生和仅用于中国的英文简写。它更惨，英文的Google完全没有收录它的中国用途：Listed Open-Ended Fund的简写，意思是上市型开放式基金。
<br />跟QDII和LOF不同，ETF是个货真价实的英文简写。常出现的XOP就是美股的ETF。对我来说，A股的ETF和LOF的区别按重要性排列如下：
</p>
<?php echo GetListElement(array('ETF通常都是100%仓位，而LOF一般不会超过95%的仓位。仓位上的细节会决定估值的准确度。',
								  'A股ETF和LOF可以从6位数字代码上区分。深市ETF代码从150000到159999，深市LOF代码从160000到169999。沪市ETF代码从510000到518999，沪市LOF代码从500000到509999。SH510900就是一个沪市ETF。',
								  'A股ETF的申购门槛通常至少都是50万份或者100万份，我这种穷套利者玩不起，所以其实我到现在也没搞清楚具体到底是50万还是100万。在美股市场，ETF的申赎基本上都是由做市商完成的。可以看出，A股从制度上来说其实有利于套利群体。',
								  'ETF的申赎会比同类型LOF早一个交易日确认。对有钱的套利者来说，就可以少担一个交易日的风险。'));
	EchoParagraph(GetQuoteElement('夜深忽梦少年事 梦啼妆泪红阑干'));
?>

<?php
	Echo20160222('增加'.GetNameTag('netvaluehistory', NETVALUE_HISTORY_DISPLAY).'页面');
?>

<h3>周期3意味着<a name="chaos">混沌</a></h3>
<p>2016年2月26日
<br />华宝油气持续溢价10%已经成了常态, 最近最高甚至到了17%, 华宝油气和XOP套利没法做了.
<br />继续整理同类代码, 这次下手目标是MySQL相关部分. 加入<font color=olive>MysqlReference</font>类继承自<font color=olive>StockReference</font>类. 集中代码处理历史记录和净值校准等数据库内容.
再加入<font color=olive>MyStockReference</font>类继承自<font color=olive>MysqlReference</font>, 从此代替<font color=olive>StockReference</font>类作为股票数据实例.
<font color=olive>FundReference</font>, <font color=olive>FutureReference</font>和<font color=olive>ForexReference</font>同时也改为继承自<font color=olive>MysqlReference</font>.
从<font color=olive>MysqlReference</font>开始调用了数据库相关函数.
</p>

<h3>美国<a name="daylightsavingbegin">夏令时开始</a></h3>
<p>2016年3月14日
<br />美国进入夏令时, 发现一个bug: <font color=gray><code>date_default_timezone_set('EST')</code></font>是没有夏令时的, 
要用<font color=gray><code>date_default_timezone_set('America/New_York')</code></font>或者<font color=gray><code>date_default_timezone_set('EDT')</code></font>.
</p>

<h3><?php EchoNameTag('goldsilver', GOLD_SILVER_DISPLAY); ?></h3>
<p>2016年3月25日
<br />趁复活节假日黄金期货GC停止交易, 校准</a>A股<a href="../../res/goldsilvercn.php">黄金白银</a>系列的净值计算工具. 目前包括<a href="../../res/sh518800cn.php">国泰黄金ETF</a>,
<a href="../../res/sh518880cn.php">华安黄金ETF</a>, <a href="../../res/sz159934cn.php">易方达黄金ETF</a>, <a href="../../res/sz159937cn.php">博时黄金ETF</a>, <a href="../../res/sz164701cn.php">添富贵金LOF</a>, 
<a href="../../res/sz160719cn.php">嘉实黄金LOF</a>和<a href="../../res/sz161116cn.php">易方达黄金LOF</a>.
<br />一直有用户建议我在华宝油气等QDII的<?php EchoFundHistoryLink(); ?>表格上加入预估净值比较栏目. 除了不愿意直接打自己嘴巴外的心理因素外, 我迟迟没有加上它的原因主要是估值是实时变化的.
我一直想不清楚是该加在美股收盘后的预估净值还是A股收盘后的.
<br />在QDII的代码中, 单独的预估净值变量原本放在<font color=olive>_QdiiAccount</font>类中. 而在新的黄金白银<font color=olive>_GoldSilverAccount</font>类中又用到了<font color=olive>FundReference</font>类. 
自然而然的, 我把预估净值的变量挪到了<font color=olive>FundReference</font>类中. 当预估净值和当日净值的变量排列在一起后, 突然之间数据结构引导思维方式的例子再次爆发, 没有比在记录当日净值的时候同时记录预估净值更合理的了!
<br />由于在股票交易日的净值系列页面访问量已经稳定在了1000左右, 最高的一天有接近1700, 我一直在琢磨如何优化页面应对以后可能的更大的访问量高峰.
把只会每天变化一次的<a href="#sma">SMA</a>计算结果保存下来是很容易想到的, 但是之前一直没有做. 在搞完7个黄金基金的校准后, 我意识到同一个GLD要在包括GC黄金期货的8个页面各算一遍, 觉得不能再忍下去了.
<br />基于之前在网上找<a href="#mobiledetect">Mobile-Detect</a>代码的经验, 我极大的低估了找一个现成的读写配置文件的php类的难度. 比较容易找到的是一个要收费5美元的, 号称同时支持文件和mysql读写配置.
而我就是不想多搞mysql的表才想用文件存的, 不免觉得这5美元有点浪费. 最后好不容易才翻到免费的<a href="http://px.sklar.com/code.html?id=142&fmt=pl" target=_blank>INIFile</a>.
这个类原本只支持在已经存在的配置文件上修改, 让我这个PHP新手折腾改了好几个小时才顺利用上.
</p>

<h3>新浪实时港股数据</h3>
<p>2016年4月23日
<br />在<?php EchoXueqieId('5174320624', '均金无忌'); ?>的帮助下使用新浪实时港股数据(<?php EchoSinaQuotesLink('rt_hk02828'); ?>),
替代原来延迟15分钟的<a href="20151225cn.php">新浪股票数据</a>.
<br />刚过去的周4净值页面系列的当日总访问量创纪录的超过了2200, 激励我继续优化页面反应速度.
</p>

<h3>近几年来最低级的bug</h3>
<p>2016年5月15日
<br />上周人民币又开始贬值, 让华宝油气估值暴露出一个新bug, 到了13号周5的时候, 我的估值居然比官方数据高了差不多一个百分点了.
周末开始查问题, 发现最后一次自动校准还是12号晚上拿到11号的官方净值后, 而本应该在13号晚上拿到12号官方净值后的自动校准居然没有做. 也就是说, 在过去的一段时间内, 自动校准都不知不觉的晚了一天,
只不过在汇率平稳的情况下这个问题暴露不出来而已.
<br />找到问题并不难, 春节后为了用最简单的方法解决中美轮流休市导致的估值问题, 因为只有港股QDII会出现QDII净值数据比ETF新的情况, 我按照是否港股QDII重新整理了部分代码,
对美股QDII就不考虑根据今天的QDII净值和昨天ETF价格校准的情况了. 结果无意改了个其实无关的代码,
把<font color=gray><code>$iHours = STOCK_HOUR_END + ($this->usdhkd_ref ? 0 : 24);</code></font>写成了<font color=gray><code>$iHours = STOCK_HOUR_END + ($this->usdhkd_ref) ? 0 : 24;</code></font>
<br />不过这个bug严重打击了我的自信心. 这一次我没法用自己是个6年的PHP<font color=red>新手</font>来自嘲了, 在我自豪的写了25年的C语言中, 这同样是个超级低级的错误!
</p>

<h3><?php EchoNameTag('myportfolio', MY_PORTFOLIO_DISPLAY); ?></h3>
<p>2016年6月5日
<br />王小波总是不忘记唠叨他写了自己用的编辑软件，在20年前我是暗自嘲笑的。没想到过了这么些年以后，我也开始写自己用的炒股软件了。不同的年龄段心态是完全不同的。
<br /><?php echo GetMyPortfolioLink('email=woody@palmmicro.com'); ?>功能刚完成的时候页面出来得奇慢无比，而接下来刷新就会快很多。因为对自己的MySQL水平没有自信心，我一头扎进了优化数据库的工作中。
优化了一些明显的问题，例如扩展了stockgroupitem表的内容，把stocktransaction表中groupitem_id相同的交易预先统计好存在stockgroupitem表中，避免每次都重新查询stocktransaction表然后重新计算一次。
不过折腾了一大圈后并没有明显的改善，倒是在这个过程中理清了原来闭着眼睛写的代码的内在逻辑，看出来了问题的根源。
<br />在按member_id查询<?php EchoNameTag('mystockgroup', TABLE_STOCK_GROUP); ?>表找到这个人所有的<?php echo GetMyStockGroupLink('email=woody@palmmicro.com'); ?>后，我会对每个stockgroup直接构造<?php echo GetCodeElement('MyStockGroup'); ?>类，
在它原来的构造函数代码中，会马上对该stockgroup中的每个stock构建一个<?php echo GetCodeElement('MyStockTransaction'); ?>类, 而<?php echo GetCodeElement('MyStockTransaction'); ?>的构造函数又需要这个stock的<?php echo GetCodeElement('MyStockReference'); ?>类作为参数,
如果没有现成的实例可用，就会新构造一个。结果就是在首次统计持仓盈利的过程中，我会把几乎所有股票的数据都去新浪拿一遍，难怪那么慢。 
<br />找到问题就好办了，首先判断stockgroup中stock对应的groupitem_id到底有没有交易记录，没有的话就不去构造<?php echo GetCodeElement('MyStockTransaction'); ?>类。另外预先统计好有交易记录的stock，统一去预取一下新浪数据。
<br />随后我把预取数据的思路用在了所有需要读取新浪数据的地方，包括华宝油气净值计算在内，所有的页面反应速度都有不同程度的提升。原来我说因为网站服务器在美国所以访问慢的理由看来并不是那么准确的！
<?php echo QuoteImgElement('pig.jpg', '一头特立独行的猪：趴在墙头看人杀猪。'); ?>
</p> 

<h3><?php EchoNameTag('qdii', QDII_DISPLAY); ?>中考虑当日CL交易情况后的T+1估值</h3>
<p>2016年8月18日
<br />发现有人的Excel计算表格中有这一项，我也就顺应潮流把它加上了。大概是沿用<?php echo GetJisiluQdiiLink(); ?>的叫法，把已经公布的净值称为T-1、把估算的官方将要公布的下一日净值称为T、而把考虑了当日美油期货CL变动的称为T+1估值，大致意思是用白天CL的变动预测晚上XOP的变动。
按我自己的看法，拉长到1年看CL和XOP对应关系可能是不错，但是具体到每一天就未必了，所以在我自己的套利交易中目前是不考虑这个T+1估值的。当然需要进行期货交易也是我不做它的一个重要因素，怕不小心杠杆赌大了把自己搞破产。一手CL是1000桶，目前每桶油价大约45美元，也就是说每次要交易45000美元的货值。
<br />这个T+1估值假定SZ162411和CL关联程度是100%，XOP和USO关联程度也是按照100%估算。由于估值依赖CL和USO在美股交易时段的自动校准，每个月20日左右CL期货换月的当天估值是不准确的。
另外因为CL期货的每日结算价格通常跟收盘价不同，也不同于我在估值中实际用来参考的美股收盘时的CL价格，有可能出现CL参考价格的显示高于上一日，而T+1估值低于T估值的情况。
<br />因为特立独行的原因，我不喜欢T-1/T/T+1这种叫法。于是我在网页中把T-1直接写成了净值，T日估值称为官方估值，而把T+1估值称为实时估值。另外还有一个参考估值，接下来解释一下这些看上去混乱的估值名称。
<br />先说明一下如何把华宝油气估值精确到0.0001元。说实在话，一开始我也不可能想到花了整整1年时间才做到这一点。
</p>
<?php echo GetListElement(array('要使用^SPSIOP或者XOP的净值，而不是XOP的交易价，2者通常收盘并不一致。',
								  '要使用'.GetLinkElement('美元人民币中间价', '20160615cn.php').'，而不是新浪的美元汇率实时交易价格。',
								  GetNameLink('lof').'基金要按95%仓位的处理，而不是ETF基金的100%。'));
	EchoFundEstTables();
?>
<p>从上表可以看出，参考估值和实时估值的区别仅仅是用不用CL的实时交易数据。相对于官方估值，当美元人民币中间价波动比较大的时候参考估值就值得关注了，此外在A股或者美股休市的日子里, 它也比官方估值更能反映实际的净值。
至于为什么叫它参考估值，那是因为我也不知道给它取什么名字好。事实上，在英文版本和软件代码中我给它取名为<?php echo GetCodeElement('FairEst'); ?>，意思是一个公平的估值。
<br />在A股开市日期的美股交易时段，这3个估值通常都是完全一致的，参考估值因此不会显示出来。如果偶尔出现官方估值和实时估值不同，那是因为CL和USO的数据没能在同一分钟内自动校准或者软件出了未知BUG。显然在美股交易时段是没有T+1的美元人民币中间价的，此时的实时估值用的只能是T日的美元人民币中间价。
此时所有的估值和校准都是为美股结束后的参考估值和实时估值做准备，用户只需要看官方估值即可。
<br />在美股交易结束后，这3个估值就开始分道扬镳了。T日官方估值不会再变化。CL通常会在美股收盘后继续多交易一个小时，此时实时估值也就会随之变化。等到第2天，软件会去自动拿通常在9点15分发布的T+1日美元人民币中间价，参考估值会因此改变固定在新值上，实时估值也会在这时候开始用T+1日美元人民币中间价。
<?php echo ImgWinMan(); ?>
<br />写了这么多细节，最后着重列一下大家最关心的：
</p>
<?php echo GetListElement(array('验证估值准确程度和测算申购赎回的成本，看官方估值。',
								  '按溢价折价决定当日是否套利和做跟XOP配对交易的，看参考估值。折价不申购，溢价不赎回。',
								  '做跟美油期货CL配对交易的，看实时估值。'));
?>

<h3><?php EchoNameTag('thanousparadox', THANOUS_PARADOX_DISPLAY); ?></h3>
<p>2016年9月18日
<br />不知不觉中宣传和实践华宝油气和XOP跨市场套利已经快2年了. 期间碰到过<?php EchoXueqieId('4389829893', 'LIFEFORCE'); ?>这种自己动手回测验证一下能赚钱就果断开干的, 
也有<?php EchoXueqieId('8871221437', '老孙'); ?>这种数学爱好者回测验证一下能赚个年化10%后就袖手旁观的,
还有常胜将军<?php EchoXueqieId('1980527278', 'Billyye'); ?>这种觉得华宝油气可以看成无非是XOP延长了的盘前盘后交易没有多少套利意义的. 
最气人的是thanous这种, 总是喜欢说大资金如何牛, 如果白天华宝油气在大交易量下溢价, 晚上XOP必然是要涨的, 彻底否定套利的根基.
<br />最近几个月华宝油气折价多溢价少, 经历了几次溢价的情况后, 发现<?php EchoXueqieId('5421738073', 'thanous'); ?>的说法基本靠谱, 我于是开始按他的名字命名为小心愿定律. 中秋节前最后一个交易日华宝油气又溢价了, 
<?php EchoXueqieId('6900406005', '大熊宝宝--林某人'); ?>建议我实际测算一下, 正好放假闲着也是闲着, 就削尖铅笔搞了个新页面测试<?php echo GetThanousParadoxLink(FUND_DEMO_SYMBOL); ?>.
我网站记录了从去年底以来所有的华宝油气数据, 跑了下从去年底到现在的统计结果没有觉得小心愿定律能成立, 于是改名为小心愿佯谬. 但是去掉春节前后华宝油气因为停止申购导致的长期溢价的影响, 只考虑最近100个交易日的情况后, 
有趣的结果出现了:
<br /><img src=../photo/20160918.jpg alt="Screen shot of test Thanous Law on Sep 18, 2016" />
<br />这里只统计了94个数据, 因为美股休市没有交易的日子被忽略了. 在华宝油气折价交易的情况下, 当晚XOP依旧是涨跌互现没有什么规律. 但是在平价和溢价的时候, 小心愿定律的确是明显大概率成立的!
<br />说白了, 如果你发现了什么交易上的规律, 只是因为交易得不够多而已.
</p>

<?php
	Echo20161006('增加'.GetNameTag('calibrationhistory', CALIBRATION_HISTORY_DISPLAY).'页面');
	Echo20161020('用微信公众号查询A股交易数据');
	Echo20170128('增加'.GetNameTag('ahcompare', AH_COMPARE_DISPLAY).'页面');
?>

<h3><a name="bollinger">布林</a>线</h3>
<p>2017年4月2日
<br /><a href="#sma">SMA</a>均线交易XOP很有效, 但是有时候会在价格突破所有均线后失去用武之地, 因此我把布林线也加入进了交易系统, 跟SMA放同一个表格中显示.
<br />同样为避免半夜盯盘, 我还是需要一个不动的布林线交易点. 这时候小学数学就不够了, 要用到一点初中数学知识. 沿用上面的SMA表达方式, 布林线的出发点依然是简单均线SMA, 可以换个符号写成:
<br />B = An = (X0 + ∑Xm) / n; 其中m = n - 1;
<br />在计算出B后, 继续计算标准差σ:
<br />σ² = ((X0 - B)² + (X1 - B)² + (X2 - B)² + ... + (Xm - B)²) / n;
<br />B和σ都计算出来后, 布林上轨是B + 2 * σ; 布林下轨是B - 2 * σ;
<br />现在来计算用来交易的不动点, 为简化起见, 先只考虑布林下轨, 就是说当天交易价格X0刚好到布林下轨的情况, 用这个价格计算对应的布林值. 写成条件是:
<br />X0 = B - 2 * σ;
<br />带入到上面计算B的公式后得到:
<br />B = (B - 2 * σ + ∑Xm) / n
<br />从而解出σ = (∑Xm - (n - 1) * B) / 2; 或者 σ = (∑Xm - m * B) / 2;
<br />再把条件 X0 = B - 2 * σ; 带入到计算σ的公式后得到:
<br />σ² = (4 * σ² + (X1 - B)² + (X2 - B)² + ... + (Xm - B)²) / n;
<br />定义∑Xm² = X1² + X2² + ... Xm²; 上面可以写成:
<br />(n - 4) * σ² = ∑Xm² - 2 * ∑Xm * B + m * B²;
<br />带入上面解出的σ = (∑Xm - m * B) / 2; 最后得到一个B的一元二次方程:
<br />(n - 4) * (∑Xm - m * B)² = 4 * ∑Xm² - 8 * ∑Xm * B + 4 * m * B²;
<br />令 k = n - 4; 写成标准的ax²+bx+c=0的格式:
<br />a = k * m² - 4 * m;
<br />b = (8 - 2 * k * m) * ∑Xm;
<br />c = k * (∑Xm)² - 4 * ∑Xm²;
<br /><img src=../photo/root.jpg alt="The roots of quadratic equation with one unknown" />
<br />做计算机最擅长的事情, 解出这个方程的2个根得到2个不同B值. 
然后数学的神奇魅力出现了, 虽然列方程的时候只考虑了布林下轨, 解出B的2个值以及对应的σ后, 却同时得到了不依赖于当天交易价X0的布林上轨和布林下轨值.
<br />实际应用中我采用大家都用的20天布林线, 也就是说n = 20, 而我是用前19个交易日的收盘价算的当日不动点的布林上轨和布林下轨, 作为交易价格.
不像简单均线SMA的不动点, 可以从一元一次方程中解出一个很容易理解的表述: 20天的SMA不动点就是前19天收盘价的平均值.
解布林线一元二次方程得到的结果就没有一个类似的容易理解的表述了, 很难说它是什么, 但是可以很简单的说它不是什么, 它不是只算19天的布林上轨和布林下轨.
事实上, 因为考虑的都是极限因素, 20天布林上下轨不动点的开口要比只算前19天的布林上下轨大, 就是说, 下轨更低一点而上轨更高一点.
<br /><img src=../photo/20170402.jpg alt="Script for bollinger quadratic equation with one unknown" />
<br />感觉好久没做这么复杂的数学了, 把计算过程拍了个照片留念一下.
<br /><font color=gray>你永远比你想象中更勇敢 -- 相信梦想</font>
</p>

<?php
	Echo20171001('200日和50日'.GetNameTag('ema').'均线');
	Echo20180327('走火入魔的'.GetNameTag('nextsma', 'T+1').'均线');
	Echo20180404('增加'.GetNameTag('adrhcompare', ADRH_COMPARE_DISPLAY).'页面');
	Echo20180405('增加'.GetNameTag('abcompare', AB_COMPARE_DISPLAY).'页面');
	Echo20180410('人民币汇率');
?>

<h3><?php EchoNameTag('nvclosehistory', NVCLOSE_HISTORY_DISPLAY); ?></h3>
<p>2018年5月3日
<br />交易了几年XOP下来, 发现它的收盘价经常跟净值有个1分2分的偏差, 不知道这其中是否有套利机会.
</p>
<?php EchoNvCloseDemo(); ?>
<p>增加这个页面倒是让我突然下了决心删除英文版本. 压死骆驼的最后一根稻草是这行代码, 混在其中的中文冒号让我恶向胆边生, 彻底放弃了本来就几乎没有什么浏览量的英文版本股票软件.
</p>
<blockquote><code>echo UrlGetQueryDisplay('symbol').($bChinese ? '净值和收盘价比较' :  ' NetValue Close History Compare');</code></blockquote>
<p>从软件开发的角度来说, 遍布我PHP代码的1000多个$bChinese肯定意味着某种代码结构缺陷, 希望这次代码清理完成后能让我醒悟过来.
<br />冷静下来后仔细想想, 发现自己早有停止英文版的意图背后其实有个更深层的原因. 三年来的各种跨市场套利经历, 让我深深体会到了对手盘的重要性和A股韭菜的可贵, 从而不愿意留个英文版让外面的世界进来抢着割这么嫩的韭菜.
<br /><font color=gray>If you've been playing poker for half an hour and you still don't know who the patsy is, you're the patsy. — Warren Buffett</font>
<?php echo ImgBuffettCards(); ?>
</p>

<h3><?php EchoNameTag('chinaindex', CHINA_INDEX_DISPLAY); ?></h3>
<p>2018年6月20日
<br />配合抄底<a href="../../res/chinaindexcn.php">A股指数</a>加入<a href="../../res/sh510300cn.php">300ETF</a>页面, 根据沪深300指数SH000300估算SH510300和ASHR的净值, 看看有没有华宝油气和XOP这种跨市场套利的机会.
<br />为了避免原有代码进一步走向<a href="#chaos">混沌</a>, 不想从原有的<font color=olive>FundReference</font>类扩展这种新估值模式, 从<font color=olive>MysqlReference</font>类继承了一个新的<font color=olive>FundPairReference</font>.
</p>

<?php
	Echo20190601('微信流量主');
	Echo20190713('微信公众号不提供查询的数据');
?>

<h3>用线性回归的方法在华宝油气溢价套利时进行<?php EchoNameTag('fundaccount', FUND_ACCOUNT_DISPLAY); ?></h3>
<p>2019年9月20日
<br />在使用Cramer法则<?php EchoNameLink('cramersrule', ACCOUNT_TOOL_CRAMER_CN, '20100905cn.php'); ?>得到华宝油气场内和场外申购账户数后, 其实真正有帮助的结论只是场外申购账户比场内申购账户少一个数量级. 
因为其中我只区分了折价和溢价2种情况进行数据分析, 但是实际上不同溢价时申购账户的区别其实是很大的.
<br />因为场外账户远少于场内账户, 我可以放心的忽略2者在申购不同日期下不同净值等细节, 把所有申购都假设成为场内申购计算. 把限购1000人民币以来所有溢价申购日期数据统一做线性回归, 可以得到下面的结果:
<br /><?php echo GetFundAccountLink(FUND_DEMO_SYMBOL); ?>
<br />顺便做一个通用一元<?php EchoLinearRegressionLink(); ?>工具.
<?php echo ImgLinearRegression(); ?>
</p>

<?php
	Echo20191025('增加'.GetNameTag('fundposition', FUND_POSITION_DISPLAY).'页面');
	Echo20191107('美国夏令时结束带来的软件BUG');
	Echo20200113('华宝油气的C类份额');
	Echo20200326('国泰商品已经只剩大半桶油');
	Echo20210227('增加'.GetNameTag('telegram', '电报').'机器人');
	Echo20210320('微信公众号剩余群发次数为0');
	Echo20210613('微信公众平台进去后显示白板');
	Echo20210624('增加'.GetNameTag('holdings', HOLDINGS_DISPLAY).'页面');
	Echo20210714('增加'.GetNameTag('fundshare', FUND_SHARE_DISPLAY).'页面');
	Echo20210728('为'.GetNameTag('chinainternet', '中丐互怜').'增加'.QDII_MIX_DISPLAY.'工具系列');
	Echo20211129(GetNameTag('endwechat', '放弃微信').'公众号文章');
	Echo20220914('为'.GetNameTag('qdiimix', QDII_MIX_DISPLAY).'补充A股成分股的持仓处理');
?>

</div>

<?php _LayoutBottom(); ?>

</body>
</html>
