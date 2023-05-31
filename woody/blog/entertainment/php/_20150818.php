<?php
require_once('../../../php/stock.php');
require_once('../../../php/stockhis.php');
require_once('../../../php/ui/referenceparagraph.php');
require_once('../../../php/ui/ahparagraph.php');
require_once('../../../php/ui/fundestparagraph.php');
require_once('../../../php/ui/fundhistoryparagraph.php');
require_once('../../../php/ui/fundshareparagraph.php');
require_once('../../../php/ui/smaparagraph.php');
require_once('../../../php/ui/nvclosehistoryparagraph.php');
require_once('../../../php/ui/stockhistoryparagraph.php');
require_once('_entertainment.php');

define('AB_DEMO_SYMBOL', 'SZ000488');
define('ADRH_DEMO_SYMBOL', 'TCEHY');
define('AH_DEMO_SYMBOL', 'SH600028');
define('FUND_DEMO_SYMBOL', 'SZ162411');
define('STOCK_DEMO_SYMBOL', 'XOP');

function DemoPrefetchData()
{
    StockPrefetchExtendedData(AB_DEMO_SYMBOL, ADRH_DEMO_SYMBOL, AH_DEMO_SYMBOL, FUND_DEMO_SYMBOL, STOCK_DEMO_SYMBOL);
}

function EchoNvCloseDemo($strSymbol = STOCK_DEMO_SYMBOL)
{
    $ref = new MyStockReference($strSymbol);
   	EchoNvCloseHistoryParagraph($ref);
}

function _getStockMenuLink($strItem)
{
    $ar = GetStockMenuArray();
    return GetNameLink($strItem, $ar[$strItem]);
}

function _getStockMenuTag($strItem)
{
    $ar = GetStockMenuArray();
    return GetNameTag($strItem, $ar[$strItem]);
}

function _getStockCategoryLink($strItem)
{
    $ar = GetStockCategoryArray();
    return GetNameLink($strItem, $ar[$strItem]);
}

function _getStockCategoryTag($strItem)
{
    $ar = GetStockCategoryArray();
    return GetNameTag($strItem, $ar[$strItem]);
}

function Echo20150824($strHead)
{
	$strHead = GetHeadElement($strHead);
	
    echo <<<END
	$strHead
<p>2015年8月24日
<br />每次进phpMyAdmin去看历史数据虽然不算麻烦，但是毕竟还是用自己写的网页看更有成就感！
</p>
END;

   	EchoStockHistoryParagraph(new MyStockReference(STOCK_DEMO_SYMBOL));
}

function Echo20150827($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strQDII = GetStockMenuLink('qdii');
	$strSZ159920 = GetStockLink('SZ159920', true);
	$strSH510900 = GetStockLink('SH510900', true);
	$strSH513500 = GetStockLink('SH513500', true);
	$strImage = ImgRonin();
	
    echo <<<END
	$strHead
<p>2015年8月27日
<br />整理代码最好的方式是多开发几个类似{$strQDII}。伴随最近抄底港股加入{$strSZ159920}和{$strSH510900}净值计算工具，观摩美股崩盘期间顺手加入了{$strSH513500}净值计算工具，也许日后会用上。
<br />牢记股市三大幻觉：A股要涨、美股见顶、港股便宜！
$strImage
</p>
END;
}

function Echo20160108($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strXueqiu = GetXueqiuIdLink('2091843424', '塔夫男');

    echo <<<END
	$strHead
<p>2016年1月8日
<br />在{$strXueqiu}等人的建议下，加入华宝油气基金历史表格记录每天的折价溢价情况。最近几天的直接显示在当前页面，同时增加单独显示全部历史数据的页面。
</p>
END;

	EchoFundHistoryParagraph(StockGetFundReference(FUND_DEMO_SYMBOL));
}

function Echo20160126($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strXueqiu = GetXueqiuIdLink('8907500725', 'oldwain');
	$strStockReference = GetCodeElement('StockReference');
	$strFutureReference = GetCodeElement('FutureReference');
	$strForexReference = GetCodeElement('ForexReference');

    echo <<<END
	$strHead
<p>2016年1月26日
<br />在{$strXueqiu}的建议下，在相关价格记录的时间中加入日期显示。原来版本中没有它是因为自己觉得交易日期很明显，完全没有必要出来占地方。不过既然有人觉得有问题，我就效仿白居易写诗先读给妇孺听的优良传统改了。
估计跟我从2000年开始就在美股赔钱不同，很多人还是不熟悉美国股市交易时间。而在这里，美股数据后面跟的是美东日期和时间。
<br />虽说是个小的分离数据和显示改动，但是忍不住哗啦哗啦又整理优化了一大片代码。
把原来的{$strStockReference}类作为基础类，原来期货和汇率数据读取分别改为继承自它的{$strFutureReference}类和{$strForexReference}类，达到统一数据显示格式的目的。
</p>
END;

    EchoReferenceParagraph(array(new MyStockReference(FUND_DEMO_SYMBOL)));
}

function _getLofLink()
{
	return GetNameLink('lof');
}

function Echo20160127($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strList = GetListElement(array('ETF通常都是100%仓位，而LOF一般不会超过95%的仓位。仓位上的细节会决定估值的准确度。',
								  'A股可以从6位数字代码上区分。深市ETF代码从150000到159999，深市LOF代码从160000到169999。沪市ETF代码从510000到518999，沪市LOF代码从500000到509999。SH510900就是一个沪市ETF。',
								  'A股ETF的申购门槛通常至少都是50万份或者100万份，我这种穷套利者玩不起，所以其实我到现在也没搞清楚具体到底是50万还是100万。在美股市场，ETF的申赎基本上都是由做市商完成的。可以看出，A股从制度上来说其实有利于套利群体。',
								  'ETF的申赎会比同类型LOF早一个交易日确认。对有钱的套利者来说，就可以少担一个交易日的风险。'));
	$strQuote = GetBlockquoteElement('夜深忽梦少年事 梦啼妆泪红阑干');

    echo <<<END
	$strHead
<p>2016年1月27日
<br />不知不觉在前面写了很多QDII。其实QDII和华宝油气这个名称里后面的LOF，绝大多数的美国人都不会认识。
<br />把Google设置成显示英文结果，然后查QDII，百度百科的中文页面显示在搜索结果的第2位，第3位是Wiki。听过一个笑话，一个腹黑的HR问程序员求职者碰到问题怎么办，回答去查百度的都会被默默的拒掉，因此我就不去看它了。
Wiki的QDII词条下显示了它是Qualified Domestic Institutional Investor的简称，同时用简体和繁体标注了合格境内机构投资者。
<br />跟QDII一样，LOF也是一个出生和仅用于中国的英文简写。它更惨，英文的Google完全没有收录它的中国用途：Listed Open-Ended Fund的简写，意思是上市型开放式基金。
<br />跟QDII和LOF不同，ETF是个货真价实的英文简写。常出现的XOP就是美股的ETF。对我来说，A股的ETF和LOF的区别按重要性排列如下：
</p>
	$strList
	$strQuote
END;
}

function Echo20160222($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	$strStockHistory = GetNameLink('stockhistory', STOCK_HISTORY_DISPLAY);
	$strNavHistoryLink = GetNavHistoryLink(FUND_DEMO_SYMBOL);
	
    echo <<<END
	$strHead
<p>2016年2月22日
<br />有人跟我指出{$strFundHistory}中净值的日期显示早了一天，我差点一口鲜血吐在了键盘上。用脚趾头想想，要计算华宝油气当天的交易溢价，肯定是要跟前一天的净值比较啊。当天的净值要等当晚美股收盘后才出来，否则的话我写这个净值估算有什么意义呢。
<br />把当天的交易价格跟前一天的净值放在一起比较，其实也正是我平时最为推崇的不同数据显示方式引导不同思维模式的举措。 
不过为了避免以后还有人搞混淆，我干脆另外加了一个单独的{$strNavHistoryLink}显示页面，算上最开始的{$strStockHistory}，现在总共有3个历史数据页面了。  
</p>
END;
}

function Echo20160325($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSH518800 = GetStockLink('SH518800', true);
	$strSH518880 = GetStockLink('SH518880', true);
	$strSZ159934 = GetStockLink('SZ159934', true);
	$strSZ159937 = GetStockLink('SZ159937', true);
	$strGoldSilver = GetStockMenuLink('goldsilver');
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	$strQdiiAccount = GetCodeElement('QdiiAccount');
	$strGoldSilverAccount = GetCodeElement('GoldSilverAccount');
	$strFundReference = GetCodeElement('FundReference');
	$strSMA = GetNameLink('sma');
	$strLof = _getLofLink();
	$strSZ160719 = GetStockLink('SZ160719', true);
	$strSZ161116 = GetStockLink('SZ161116', true);
	$strSZ164701 = GetStockLink('SZ164701', true);
	$strMobileDetect = GetNameLink('mobiledetect', 'Mobile-Detect');
	$strIniFile = GetExternalLink('http://px.sklar.com/code.html?id=142&fmt=pl', 'INIFile');
	
    echo <<<END
	$strHead
<p>2016年3月25日
<br />趁复活节假日的空挡为{$strSH518800}、{$strSH518880}、{$strSZ159934}和{$strSZ159937}增加{$strGoldSilver}页面。
<br />一直有用户建议我在华宝油气等QDII的{$strFundHistory}表格上加入预估净值比较栏目。除了不愿意直接打自己嘴巴外的心理因素外，我迟迟没有加上它的原因主要是估值是跟着美股交易实时变化的，一直想不清楚这个时间上的对应关系。
<br />在QDII的代码中，单独的预估净值变量原本放在{$strQdiiAccount}类中，而在新的{$strGoldSilverAccount}类中又再次用到了{$strFundReference}类。
自然而然的，我把预估净值的变量挪到了{$strFundReference}类中。当预估净值和当日净值的变量排列在一起后，突然之间数据结构引导思维方式的例子再次爆发，没有比在记录当日净值的时候同时记录预估净值更合理的了！
同时记录和显示估值的时间，这样当看到估值时间落在美股交易结束前，那么有误差就是天经地义的事情，而不是我的算法有问题。计算估值是由用户访问页面的动作驱动的，如果某页面没有用户经常访问，那么就会出现这种异常时间估值。
<br />由于在股票交易日的净值系列页面访问量已经稳定在了1000左右，最高的一天有接近1700，我一直在琢磨如何优化页面应对以后可能的更大的访问量高峰。
把只会每天变化一次的{$strSMA}计算结果保存下来是很容易想到的，但是之前一直没有做。写完这4个黄金ETF的页面后，我意识到同一个GLD的SMA要在包括黄金{$strLof}的{$strSZ160719}、{$strSZ161116}和{$strSZ164701}共7个页面各算一遍，觉得不能再忍下去了。
<br />基于之前在网上找{$strMobileDetect}代码的经验，我极大的低估了找一个现成的读写配置文件的PHP类的难度。比较容易找到的是一个要收费5美元的，号称同时支持文件和MySQL读写配置。而我就是不想多搞MySQL的表才想用文件存的，不免觉得这5美元有点浪费。
最后好不容易才翻到免费的{$strIniFile}。这个类原本只支持在已经存在的配置文件上修改，让我这个PHP新手折腾改了好几个小时才顺利用上。
END;
}

function _getQdiiLink()
{
	return GetNameLink('qdii');
}

function Echo20160818($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strJisilu = GetJisiluQdiiLink();
	$strNav = GetTableColumnNav();
	
	$offical_col = new TableColumnOfficalEst();
	$strOfficalEst = $offical_col->GetDisplay();
	
	$fair_col = new TableColumnFairEst();
	$strFairEst = $fair_col->GetDisplay();
	
	$realtime_col = new TableColumnRealtimeEst();
	$strRealtimeEst = $realtime_col->GetDisplay();
	
	$strEstList = GetListElement(array('要使用^SPSIOP或者XOP的净值，而不是XOP的交易价，两者通常并不一致。',
								  '要使用'.GetLinkElement('美元人民币中间价', '20160615cn.php').'，而不是新浪的美元汇率实时交易价格，更不是离岸人民币价格。',
								  _getLofLink().'基金要按95%仓位的处理，而不是ETF基金的100%。'));
	$strFairEstCode = GetCodeElement('FairEst');
	$strImage = ImgWinMan(); 
	$strUsageList = GetListElement(array('验证估值算法准确程度和测算申购赎回的成本，看'.$strOfficalEst.'。',
								  '按溢价折价决定当日是否套利和做跟XOP配对交易的，看'.$strFairEst.'。折价不申购，溢价不赎回。此外A股或者美股休市的日子里也应该看它。',
								  '做跟美油期货CL配对交易的，看'.$strRealtimeEst.'。'));
	
    echo <<<END
	$strHead
<p>2016年8月18日
<br />发现有人的Excel计算表格中有这一项，我也就顺应潮流把它加上了。大概是沿用{$strJisilu}的叫法，把已经公布的净值称为T-1、把估算的官方将要公布的下一日净值称为T、而把考虑了当日美油期货CL变动的称为T+1估值，大致意思是用白天CL的变动预测晚上XOP的变动。
按我的看法，拉长到一年看CL和XOP对应关系可能是不错，但是具体到每一天就未必了，所以在自己的套利交易中目前是不考虑这个T+1估值的。当然需要进行期货交易也是我不做它的一个重要因素，怕不小心杠杆赌大了把自己搞破产。一手CL是1000桶，目前每桶油价大约50美元，也就是说每次要交易五万美元的货值。
<br />因为特立独行的原因，我不喜欢T-1/T/T+1这种叫法。于是我在网页中把T-1直接写成了{$strNav}，T日估值称为{$strOfficalEst}，而把T+1估值称为{$strRealtimeEst}。另外还有一个{$strFairEst}，接下来解释一下这些看上去混乱的估值名称。
<br />{$strFairEst}和{$strRealtimeEst}的区别仅仅是用不用CL的实时交易数据。{$strRealtimeEst}假定SZ162411和CL关联程度是100%，XOP和USO关联程度也是按照100%估算。由于估值依赖CL和USO在美股交易时段的自动校准，而期货总是免不了升水贴水，每个月20日左右CL期货换月的当天{$strRealtimeEst}是不准确的。
另外因为CL期货的每日结算价格通常跟收盘价不同，CL期货收盘比美股晚一个小时的收盘价也不同于我在估值中实际用来参考的美股收盘时的CL价格，有可能出现CL价格的显示高(或低)于上一日，而{$strFairEst}低(或高)于{$strRealtimeEst}的情况。
<br />先说明一下如何把华宝油气{$strOfficalEst}精确到0.001元。说实在话，刚开始我也不可能想到花了整整一年时间才做到这一点。
</p>
	$strEstList
END;

	EchoFundArrayEstParagraph(array(StockGetFundReference(FUND_DEMO_SYMBOL)));
	EchoTableParagraphBegin(array(new TableColumn('估值因素', 140), $offical_col, $fair_col, $realtime_col), 'estcompare');
	EchoTableColumn(array('T日美股交易',		'XOP净值',	'XOP净值',	'XOP净值'));
	EchoTableColumn(array('CL期货',			'否',		'否',		'是'));
	EchoTableColumn(array('美元人民币中间价',	'T日',		'T/T+1日',	'T/T+1日'));
    EchoTableParagraphEnd();

    echo <<<END2
<p>相对于{$strOfficalEst}，当美元人民币中间价波动比较大的时候{$strFairEst}就值得关注了，此外在A股或者美股休市的日子里, 它也比{$strOfficalEst}更能反映实际的净值。
至于为什么叫它{$strFairEst}，那是因为我也不知道给它取什么名字好。事实上，在英文版本和软件代码中我给它取名为{$strFairEstCode}，意思是一个公平的估值。
<br />在A股开市日期的美股交易时段，这三个估值通常都是完全一致的，{$strFairEst}因此不会显示出来。如果偶尔出现{$strOfficalEst}和{$strRealtimeEst}不同，那是因为CL和USO的数据没能在同一分钟内自动校准或者软件改出了新BUG。
显然在美股交易时段是没有T+1的美元人民币中间价的，此时的{$strRealtimeEst}用的只能是T日的美元人民币中间价。此时所有的估值和校准都是为美股结束后的{$strFairEst}和{$strRealtimeEst}做准备，用户只需要看{$strOfficalEst}即可。
<br />在美股交易结束后，这3个估值就开始分道扬镳了。T日{$strOfficalEst}不会再变化。CL通常会在美股收盘后继续多交易一个小时，此时{$strRealtimeEst}也就会随之变化。
等到第二天，软件会去自动拿通常在9点15分发布的T+1日美元人民币中间价，{$strFairEst}会因此改变固定在新值上，{$strRealtimeEst}也会在这时候开始用T+1日美元人民币中间价。
	$strImage
<br />写了这么多细节，最后着重列一下大家最关心的：
</p>
	$strUsageList
END2;
}

function Echo20161006($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSZ162411 = GetCalibrationHistoryLink(FUND_DEMO_SYMBOL, true).CALIBRATION_HISTORY_DISPLAY;
	$strUSO = GetCalibrationHistoryLink('USO', true).CALIBRATION_HISTORY_DISPLAY;
	$strQDII = _getQdiiLink();
	
    echo <<<END
	$strHead
<p>2016年10月6日
<br />在华宝油气估值的时候，每次拿到官方发布的净值后都会根据净值当天的美股数据和美元人民币中间价做一次自动校准，从现在开始全部在{$strSZ162411}页面记录下来，方便观察长期趋势。校准时间就是拿到新的官方净值后第一次访问的时间。
类似的版面上还有CL和{$strUSO}，用在{$strQDII}基金的实时估值上。
<br />碰到XOP分红除权的日子，就需要进行手工校准。否则的话要等下一次自动校准后，估值结果才会再次正确。
</p>
END;
}

function _getWeixinLink()
{
	return GetNameLink('weixin', '微信公众号');
}

function Echo20161014($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strFlyingpig33 = GetQuoteElement('flyingpig33');
	$strWeixinLink = GetWeixinLink();
	$strError = GetFontElement('Token验证失败');
	$str162411 = GetQuoteElement('162411');
	$str162411cn = GetQuoteElement('华宝油气');
	$str1 = GetQuoteElement('1');
	$strPA3288 = GetLinkElement('PA3288', '../../../pa3288/indexcn.html');
	$strSz162411 = GetQuoteElement('sz162411');
	$strImage = ImgPalmmicroWeixin();
	
    echo <<<END
	$strHead
<p>2016年10月14日
<br />作为一个搞了16年互联网产品的公司，Palmmicro居然一直没有开发自己的手机App。世界变化快，现在貌似也不用自己开发App，大多数的需求用微信公众号就足够满足。
<br />因为一年多前做华宝油气净值估算页面的时候就跟提供QDII基金估值的公众号小飞猪{$strFlyingpig33}学习过，我一直觉得加公众号是件非常简单的事情，没想到在启用{$strWeixinLink}开发模式消息接口的时候就碰到了问题。
采用几乎是一目了然的微信示例PHP程序，我在设置服务器链接的时候不断被提示{$strError}，反复调试一整晚后才意识到是因为Yahoo网站服务在我的每个页面后都加了一段javascript统计代码。 
<br />因为我早就在用Google Analytics做网站统计，其实我一直觉得Yahoo前两年加的这个功能是个累赘，没有提供什么新功能，反而拖累了网页反应速度。这下我就有了充分理由去掉它了。在Yahoo Small Business的新网站Aabaco Small Business里面又找了好半天，终于关闭了它。
<br />接下来增加功能，现在最直接的需求就是用微信查华宝油气净值。采用对话方式，在消息中用语音或者键盘输入{$str162411}或者{$str162411cn}等获取它的各种估值以及具体估值的时间。
<br />用户如果只输入{$str1}，会匹配到大量的结果。受微信消息长度2048字节的限制，只会显示匹配靠前的一部分出来。如果直接用微信语音的话，微信自带的语音识别貌似要小小的训练一下。例如，如果一开始就说{$str162411}，识别的结果可能不如人意，但是如果先用键盘输入一次{$str162411}，以后的语音识别就畅通无阻了。 
<br />开发过程中碰到了一个问题，微信消息有必须在5秒之内返回的限制。而根据Google Analytics对过去30天5934次对华宝油气估值页面的Page Timings统计，平均反应时间是10秒，这样大概率会超过微信的5秒限制，导致消息回应失败。反应时间慢的主要原因是估值前可能需要先访问新浪股票数据和美元人民币中间价等不同网站。
只好挽起袖子搞优化，尽可能的多在本地存数据，减少每次查询中对外部网站的访问。最后勉强把最长的回应时间控制在了4228毫秒，总算满足了要求。
<br />回到公司的产品上来，这个微信公众号和本网站一起作为一个具体应用实例，为开发中的{$strPA3288}物联网IoT模块提供一个数据采集、存储和查询的总体解决方案。在这个基础上，我们可以提供全套的产品和软硬件技术，帮助客户建立自己的物联网数据管理分析应用系统。
<br />虽然目前还没有多少功能，大家已经可以扫描下面的二维码添加Palmmicro微信公众订阅号。选用{$strSz162411}作为微信号既符合目前提供的数据，又是个没有办法的选择，因为我太喜欢用palmmicro这个名字，以至于它早早就被我自己的私人晒娃微信号占用了。 
$strImage
</p>
END;
}

function _getUpdateChinaStockLink($strNode, $strDisplay)
{
	return DebugIsAdmin() ? GetInternalLink('/php/test/updatechinastock.php?node='.$strNode, $strDisplay) : '';
}

function Echo20161020($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strQuote = GetQuoteElement('交通银行');
	
	$strNodeA = 'hs_a';
	$strChinaStock = GetExternalLink(GetSinaChinaStockListUrl($strNodeA));
	$strUpdateChinaStock = _getUpdateChinaStockLink($strNodeA, '更新A股数据');
	
	$strNodeS = 'hs_s';
	$strChinaIndex = GetExternalLink(GetSinaChinaStockListUrl($strNodeS));
	$strUpdateChinaIndex = _getUpdateChinaStockLink($strNodeS, '更新指数');
	
	$strUsStock = GetExternalLink(GetSinaUsStockListUrl());
	$strUpdateUsStock = DebugIsAdmin() ? GetInternalLink('/php/test/updateusstock.php', '更新美股数据') : '';
	
    echo <<<END
	$strHead
<p>2016年10月20日
<br />今天发现有个{$strWeixin}用户用语音查询{$strQuote}，没查到因为数据库中根本没有它。不过因此刺激了我给加上查询所有股票交易数据的功能。
<br />首先我要把A股3000多只股票都加到数据库中。开始我想直接开个大循环从000001到699999从新浪拿数据，后来觉得太蠢了，还担心新浪的数据接口把我列入黑名单。不过接下来我从{$strChinaStock}找到了所有A股数据。$strUpdateChinaStock
<br />还有数量上几乎跟股票同一个量级的指数{$strChinaIndex}。$strUpdateChinaIndex
<br />继续给数据库中加美股代码，希望{$strUsStock}这个不完整的美股单子能满足绝大多数中国用户的查询。$strUpdateUsStock
</p>
END;
}

function Echo20161028($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strQuote = GetQuoteElement('159915');
	$strChinaFund = GetExternalLink(GetSinaChinaStockListUrl('open_fund'));
	$strLof = _getLofLink();
	$strUpdateChinaETF = _getUpdateChinaStockLink('etf_hq_fund', '更新A股ETF数据');
	$strUpdateChinaLOF = _getUpdateChinaStockLink('lof_hq_fund', '更新A股LOF数据');
	
    echo <<<END
	$strHead
<p>2016年10月28日
<br />昨天让我广发证券网上开户的经理帮忙宣传一下{$strWeixin}查股票数据，随即加进来2个人。其中一个上来就查{$strQuote}，发现没有数据后立马取消了订阅，又刺激了我给数据库加上所有A股基金数据。
<br />从{$strChinaFund}找到了基金列表，没想到全市场居然有上万基金。然后继续写代码加入了其中可以场内交易ETF和{$strLof}，从此应该不怕被查。$strUpdateChinaETF $strUpdateChinaLOF
</p>
END;
}

function Echo20170128($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	
	$strNodeHk = 'qbgg_hk';
	$strHkStock = GetExternalLink(GetSinaChinaStockListUrl($strNodeHk));
	$strUpdateHkStock = _getUpdateChinaStockLink($strNodeHk, '更新港股数据');
	
	$str162411 = GetQuoteElement('162411');
	$str600028 = GetQuoteElement('600028');
	$str000001 = GetQuoteElement('000001');
	$str162411cn = GetQuoteElement('华宝油气');
	$strSz162411 = GetQuoteElement('sz162411');
	$strList = GetListElement(array('输入刚好是6位数字并且数值大于等于1000时，直接按照按照A股代码规律扩展后寻找唯一匹配。例如'.$str162411.'匹配SZ162411，'.$str600028.'匹配SH600028。',
								  '输入刚好是6位数字并且数值小于1000时，寻找可能的沪市指数和深市股票最多2个匹配。例如'.$str000001.'匹配上证指数SH000001和平安银行SZ000001。',
								  '当输入有非ASCII字符，比如中文'.$str162411cn.'时，不查找代码，而是只在名称字段寻找可能的最多32个匹配。',
								  '其它情况如'.$strSz162411.'同时在代码和名称字段寻找可能的最多32个匹配。',
								  ));
	
	$strHbyq = GetQuoteElement('hbyq');

	$strNodeAh = 'aplush';
	$strAhStock = GetExternalLink(GetSinaChinaStockListUrl($strNodeAh));
	$strUpdateAhStock = _getUpdateChinaStockLink($strNodeAh, '更新AH股数据');
	
	$str00386 = GetQuoteElement('00386');
	
    echo <<<END
	$strHead
<p>2017年1月28日
<br />为了有效配合今年的打新计划，我打算扩大中国石化外的门票范围。但是同时沿用AH股价格比较的思路，只选取A股价格低于H股的作为门票。
<br />{$strWeixin}搞了几个月，使用者寥寥。不过开发的过程中有个意外收获，帮助我彻底区分了净值计算和用户显示界面的代码。为了充分利用这个好处，我打算把AH比较也包括在查询结果中，结果又牵扯出不少一开始未曾想到的改动。
<br />首先要加入港股数据{$strHkStock}。$strUpdateHkStock 面对跟A股差不多一样多的港股，我犹豫了，担心会进一步拖累消息回应时间。然后我又打起了优化的主意：
</p>
	$strList
<p>这样一来，输入{$str162411}永远会反应最快，{$str162411cn}第二，{$strSz162411}最慢。至于想输入{$strHbyq}拼音简称的，则什么都查不到！
<br />AH数据来源：{$strAhStock} {$strUpdateAhStock}
<br />现在可以输入{$str600028}或者{$str00386}试试看，同时增加个对比页面：
</p>
END;

   	EchoAhParagraph(array(new AhPairReference(AH_DEMO_SYMBOL)));
}

function Echo20171001($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSMA = GetNameLink('sma');
	$strBollinger = GetNameLink('bollinger', '布林');
	
    echo <<<END
	$strHead
<p>2017年10月1日
<br />均线交易系统中加入美股最看重的牛熊分界线200日EMA均线和小牛熊分界线50日EMA均线。按美股标准，当50日EMA上穿200日时进入牛市，下穿则进入熊市。
<br />考虑到50日EMA在数值上其实跟10周{$strSMA}差不多，而200日EMA则大致相当于10月SMA，为避免重复加减仓位，我并不在这2个EMA数据上进行交易，而仅仅只是看它们衍生显示的牛熊状态。
依旧是出于控制仓位的目的，熊市抄底做多时我只在日{$strBollinger}下轨或更低价格的周线SMA和月线SMA上加仓，牛市做空时我也只在日布林上轨或更高价格的周线SMA和月线SMA上进一步卖空。
<br />用En表示今天的n日EMA值，其它沿用前面的符号： 
<br />En = k * X0 + (1 - k) * Em; 其中m = n - 1; k = 2 / (n + 1)
<br />不动点En = X0，得到En = Em，就是说今天的不动点就是昨天的值。所以唯一要做的就是每天收盘后算一下当天的EMA。
</p>
END;
}

function Echo20180327($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSMA = GetNameLink('sma');
	$strBollinger = GetNameLink('bollinger', '布林');
	$strEMA = GetNameLink('ema');
	
    echo <<<END
	$strHead
<p>2018年3月27日
<br />从宇宙观上来说，我是不相信历史能够预测未来的，当然也就不相信技术分析能够预测市场。但是交易XOP这4年多来，我却在技术指标上一步一步加码。从{$strSMA}均线、{$strBollinger}线到美股牛熊分界线{$strEMA}均线，我都觉得自己变成了一个神棍。
<br />现在居然搞起了T+1均线，原因是我发现XOP的SMA周线和月线经常能做出非常准的交易价格预测，但是SMA日线和和布林线就不如前2者。
而另外一方面，XOP的收盘价却经常会刚好在第2天我计算出来的SMA日线或者布林线上。这让我猜想每天交易结束前也许有人偷跑，会提前估算在第二天的均线位置上交易。
偷跑也可以解释为什么我觉得周线和月线准确，因为要在周5和月末最后一个交易日才会出现周线和月线上的偷跑，总体概率就小了。
<br />计算SMA的偷跑很简单，沿用前面SMA的表述：
<br />An = (X0 + ∑Xm) / n; 其中m =  n - 1; 改写为
<br />An = (X0 + X1 + ∑Xm) / n; 其中m =  n - 2;
<br />偷跑的情况下，不动点是An = X0 = X1，这样An = (An + An + ∑Xm) / n，从这可以解出An不依赖于X0和X1的表达式：
<br />An = ∑Xm / (n - 2); 或者 An = ∑Xm / m;
<br />这个结果可以非常简单的理解成，5日SMA偷跑的T+1结果，就是算一下前3天的SMA均线而已。
<br />再来依葫芦画瓢算布林线的偷跑：
<br />B = An = (X0 + X1 + ∑Xm) / n; 其中m = n - 2;
<br />还是先只考虑布林下轨，偷跑交易的不动点写成条件是：
<br />X0 = X1 = B - 2 * σ; 带入上面得到：
<br />B = (B - 2 * σ + B - 2 * σ + ∑Xm) / n;
<br />从而解出σ = (∑Xm - (n - 2) * B) / 4; 或者 σ = (∑Xm - m * B) / 4;
<br />在把条件X0 = X1 = B - 2 * σ; 带入标准差σ计算公式：σ² = ((X0 - B)² + (X1 - B)² + (X2 - B)² + ... + (Xm - B)²) / n; 得到：
<br />σ² = (4 * σ² + 4 * σ² + (X2 - B)² + ... + (Xm - B)²) / n;
<br />定义∑Xm² = X2² + ... Xm²; 上面可以写成：
<br />(n - 8) * σ² = ∑Xm² - 2 * ∑Xm * B + m * B²;
<br />带入上面解出的σ = (∑Xm - m * B) / 4; 最后得到一个B的一元二次方程：
<br />(n - 8) * (∑Xm - m * B)² = 16 * ∑Xm² - 32 * ∑Xm * B + 16 * m * B²;
<br />令 k = n - 8; 写成标准的ax²+bx+c=0的格式：
<br />a = k * m² - 16 * m;
<br />b = (32 - 2 * k * m) * ∑Xm;
<br />c = k * (∑Xm)² - 16 * ∑Xm²;
<br />最后解出结果。
<br />EMA设计精巧，不存在偷跑的问题，所以没有T+1估值。
</p>
END;

	EchoQdiiSmaParagraph(StockGetFundReference(FUND_DEMO_SYMBOL));
}

function Echo20180404($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strXueQiu = GetXueqiuIdLink('1955602780', '不明真相的群众');
	$strAhCompare= GetNameLink('ahcompare', AH_COMPARE_DISPLAY);
	$strWeixin = _getWeixinLink();
	$str00700 = GetQuoteElement('00700');
	$strTencent = GetQuoteElement('腾讯');
	$strSource = GetExternalLink(GetAastocksAdrUrl());
	$strUpdate = DebugIsAdmin() ? GetInternalLink('/php/test/updateadr.php', '更新H股ADR数据') : '';
	$strTableSql = GetCodeElement('TableSql');
	$strValSql = GetCodeElement('ValSql');
	$strDateSql = GetCodeElement('DateSql');
	$strIntSql = GetCodeElement('IntSql');
	$strPairSql = GetCodeElement('PairSql');
	$strStockPairSql = GetCodeElement('StockPairSql');
	$strQDII = _getQdiiLink();
	$strCalibration = GetNameLink('calibrationhistory', CALIBRATION_HISTORY_DISPLAY);
	$strQuote = GetBlockquoteElement('Life is like a snowball. The important thing is finding wet snow and a really long hill. — Warren Buffett');
	
    echo <<<END
	$strHead
<p>2018年4月4日
<br />雪球创始人方三文，自称{$strXueQiu}。平时总是苦口婆心的把盈亏同源放在嘴边，鼓动大家通过雪球资管做资产配置。但是他却认为自己对互联网企业有深刻理解，在推销自己私募的时候总是鼓吹腾讯和FB，又把盈亏同源抛在脑后了。
<br />最近2个月腾讯结束了屡创新高的行情，开始跟FB一起下跌，引发了大家抄底雪球方丈的热情。不仅港股腾讯00700每天巨量交易，就连它在美股粉单市场的ADR在雪球上都热闹非凡。
这吸引了我的注意力，然后发现港股还有其它不少股票也有美股市场的American Depositary Receipt(ADR)。于是我按照原来{$strAhCompare}的套路增加了个页面蹭一下热度。同时也加入到了{$strWeixin}的查询中：输入{$strTencent}或者{$str00700}试试看。
<br />数据来源：{$strSource}	{$strUpdate}
<br />从数据库的表格开始，{$strTableSql}是所有表格的基类，它本身也可以用在只有一个整数id的表格。
<br />{$strValSql}基于{$strTableSql}，试图包括所有一个整数id和一个val的表格，它本身可以用于id+浮点数的表格，例如基金仓位fundposition表。
<br />{$strDateSql}和{$strIntSql}都基于{$strValSql}，分别对应id+YMD日期和id+整数的表格。
<br />{$strPairSql}基于{$strIntSql}，额外为反向查询加上了索引，这样刚好用于A/H的情况：id是A股的stock_id，它对应的整数值是H股的stock_id。
<br />{$strStockPairSql}基于{$strPairSql}，额外加上了从stock_id到symbol的来回转换，ahpair表就是直接来自它。
<br />跟A股和H股总是1:1不同，每股ADR可以对应100、1或者0.5等各种不同数值的H股。因此一个自然的做法是继续从{$strStockPairSql}派生adrpair表，加上这个额外的对应数值。不过这样一来，A/H和ADR/H比较页面能共用的代码就不多了。
在{$strQDII}估值中原本就有基金仓位fundposition表，我脑洞一开，想到每股ADR对应多少股H股其实也是一种仓位上的体现，就把不是1:1的ADR/H对应数值也存到了这个表中。
<br />更妙的是，想通了比例对应仓位后，A/H和ADR/H之间的价格转换跟QDII估值比较就只差一个{$strCalibration}的概念了。具体的看，在A/H情况下，其实相当于校准值永远是1。而在ADR/H的情况下，校准值其实就是固定的(1/仓位)。
这样一来，我不仅统一了A/H和ADR/H比较页面的代码，还顺便统一了目前用到的各种价格转换计算，顿时感觉打通了任督二脉！
</p>
	$strQuote
END;

   	EchoAdrhParagraph(array(new AdrPairReference(ADRH_DEMO_SYMBOL)));
}

function Echo20180405($strHead)
{
	$strHead = GetHeadElement($strHead);

	$strNode = 'hs_b';
	$strChinaStock = GetExternalLink(GetSinaChinaStockListUrl($strNode));
	$strUpdateChinaStock = _getUpdateChinaStockLink($strNode, '更新B股数据');
	
	$str000488 = GetQuoteElement('000488');
	$str200488 = GetQuoteElement('200488');
	
    echo <<<END
	$strHead
<p>2018年4月5日
<br />折腾完H股后觉得意犹未尽，一鼓作气继续加上AB股对比。其实我自己连B股账户都没有，写这个就是完全为了测试一下现有代码的可扩展性。此外，因为B股规模远小于A股，以后可以用来方便测试二者的共同代码。
<br />数据来自{$strChinaStock}。$strUpdateChinaStock 
<br />输入查{$str000488}或者{$str200488}试试看。
</p>
END;

   	EchoAbParagraph(array(new AbPairReference(AB_DEMO_SYMBOL)));
}

function Echo20180410($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strCNY = GetQuoteElement('人民币汇率');
	$strLink = GetMyStockLink('USCNY');
	$strOldUSCNY = GetQuoteElement('美元人民币中间价');
	$strUSCNY = GetQuoteElement('美元人民币汇率中间价');
	
    echo <<<END
	$strHead
<p>2018年4月10日
<br />沉寂已久的{$strWeixin}在清明假期中突然有人来查了下{$strCNY}，因为没有任何匹配，这个查询通知到了我的电子邮件中，让我感觉一下子打了鸡血，学习微信小程序开发的劲头一下子足了好多。
<br />微信订阅号中查不到用来估值的人民币汇率的确有点奇怪。原因是为了加快反应时间，向微信发的查询是不会去再去拿每天更新一次的人民币中间价数据的。
<br />当然这现在已经难不倒我了，我可以从数据库中把最近2天的中间价找出来，拼成跟其他数据类似的格式提供给用户。按惯例，又全面整理了几天代码，直到今天才完工。
<br />因为微信查找中我没有做中文分词，因此{$strCNY}这种5个字的长查询其实是很难匹配的。为了保证下次用户能查到，我还特意手工把数据库中{$strLink}的说明从{$strOldUSCNY}改成了{$strUSCNY}。
</p>
END;
}

function Echo20180620($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strChinaIndex = GetStockMenuLink('chinaindex');
	$strSH510300 = GetStockLink('SH510300', true);
	$strChaos = GetNameLink('chaos', '混沌');
	$strFundReference = GetCodeElement('FundReference');
	$strMysqlReference = GetCodeElement('MysqlReference');
	$strFundPairReference = GetCodeElement('FundPairReference');
	
    echo <<<END
	$strHead
<p>2018年6月20日
<br />配合抄底{$strChinaIndex}加入{$strSH510300}页面，根据沪深300指数SH000300估算SH510300和ASHR的净值，看看有没有华宝油气和XOP这种跨市场套利的机会。
<br />为了避免原有代码进一步走向{$strChaos}，不想从原有的{$strFundReference}类扩展这种新估值模式，从{$strMysqlReference}类继承了一个新的{$strFundPairReference}。
</p>
END;
}

function Echo20190601($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strImage = ImgTianHeng();
	
    echo <<<END
	$strHead
<p>2019年6月1日
<br />两年多过去，{$strWeixin}上现有517个用户，感觉基本上体现了目前华宝油气套利群体的规模。
<br />佛前五百罗汉，田横五百壮士；微信用户超过五百人就可以开通流量主收广告费了。
$strImage
</p>
END;
}

function Echo20190713($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strQuote = GetQuoteElement('019547');
	$strLink = GetSinaQuotesLink('sh019547');
	
    echo <<<END
	$strHead
<p>2019年7月13日
<br />昨天有人在{$strWeixin}上查{$strQuote}没有匹配。看了一下{$strLink}，发现居然是国债。软件工具有人用终归是好事情，不过以前我好像听说过资产1000万美元以下的不应该考虑债券投资，所以还是按捺住了兴奋的心情，没有再次削尖铅笔给我的数据库加上所有A股债券数据。
<br />还有一个更加深刻的原因是，因为查询时会从头到尾遍历一遍股票数据库，现在的查询速度已经快要慢到了公众号的极限，实在不能想象再加一两万条债券进去会怎么样。
<br />基于相同的原因，既拖慢速度我自己又不用，公众号也不提供场外基金的数据查询。
</p>
END;
}

function Echo20190905($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strCramer = GetCramersRuleLink();
	$strImage = ImgCramersRule();
	$strQuote = GetBlockquoteElement("And what in heaven's name brought you to Casablanca?
										<br />My health. I came to Casablanca for the waters.
										<br />The waters? What waters? We're in the desert.
										<br />I was misinformed.");
	
    echo <<<END
	$strHead
<p>2019年9月5日
<br />过去两个月XOP持续暴跌吸引了大量抄底华宝油气的，在很短时间内耗光了华宝基金公司的外汇额度。华宝油气从7月31日起单日单个基金账户累计申购金额上限设置为10万，8月2日周五限额变成了1万，8月9日限额变成1000元人民币。
就像超新星爆发给天文学家提供了难得的测距参考一样，限购给我提供了少有的观察套利者的机会，所以我每天都在乐此不疲的追踪相关数据。
<br />8月29日华宝油气收盘价0.387，跟8月28日0.385的净值比溢价0.52%。很多溢价申购套利老手都不会放弃这个蚂蚁也是肉的赚钱机会。
<br />9月5日华宝油气场内新增72万股，由于9月2日美股休市暂停申购，这个数据可以看成是对应8月29日场外申购后转场内的份额。假如都是在华宝官网0.1折最低费用申购的话，限购1000块人民币下满额申购了：
<br />720000/(998.5/0.397) = 286场外帐户
<br />再回头看一下9月3日，华宝油气场内新增695万股。假如这些新增都来自场内申购的话，对应8月29日场内限购1000块人民币下满额申购了：
<br />6950000/(985/0.397) = 2801场内账户
<br />之前还有一个机会可以同样看到在同一天场外申购的账户数比场内申购的账户数小一个数量级的情形，可以跟这个结果交叉验证。
<br />8月13日场内新增7408万股，假定全部来自于8月6日(溢价1.78%)场外申购转场内和8月8日(溢价2.3%)的场内申购。假定每户都是用满1万申购额度，8月8日场内申购的净值为0.402，场内一折券商实际使用了9850块申购，每户实际到账2.450万股。
假定场外都是使用华宝官网0.1折，实际使用申购金额为9998.5，8月6日申购的净值为0.391，每户实际到账2.557万股。用未知数x表示场内申购的账户数，未知数y表示场外申购转场内的账户数，假定在我们考虑的最近一段时间这2个账户数都是固定不变的。由此得出第一个方程：
<br />2.450 * x + 2.557 * y = 7408
<br />8月14日华宝油气场内新增810万股，本来按上面的逻辑新增应该全部来自于8月7日(溢价1.53%)场外申购转场内和8月9日(折价0.25%)的场内申购。8月9日是场内申购限购1000的第一天，不过可惜这天场内交易折价0.25%，应该同时出现了大量不限金额的赎回。多了一个无法定量的赎回变量，导致8月14日的数据无法像上面那列第2个方程。
<br />8月15日场内新增1099万股，继续按前面的假设列方程。对应最后一天限购1万的8月8日(溢价2.3%)场外转场内，和限购1000的8月12日(溢价1.01%)场内申购。8日申购净值是0.402，12日申购净值是0.393。可以列出方程：
<br />(985/0.393/10000) * x + (9998.5/0.402/10000) * y = 1099
<br />保留4位有效数字合并常数后得到第二个方程：
<br />0.2506 * x + 2.487 * y = 1099
<br />使用Cramer法则{$strCramer}的通用工具，得到场内申购户数 x = 2864，场外申购户数 y = 153。
<br />原则上来说按我的假设，任何两天的数据都可以用来联立一个二元一次方程组，解出场内申购和场外申购的账户数。我一定要选择从限购1万到限购1000的变化时两天的数据来估算是出于计算精度的考虑，为了避免两个大数字相减后得到一个跟误差范围同一数量级的小数字，让整个结论失去意义。
$strImage
</p>
$strQuote
END;
}

function Echo20190920($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strCramer = GetNameLink('cramersrule', ACCOUNT_TOOL_CRAMER_CN);
	$strFundAccount = GetFundAccountLink(FUND_DEMO_SYMBOL);
	$strLinear = GetLinearRegressionLink();
	$strImage = ImgLinearRegression();
	
    echo <<<END
	$strHead
<p>2019年9月20日
<br />在使用Cramer法则{$strCramer}得到华宝油气场内和场外申购账户数后，其实真正有帮助的结论只是场外申购账户比场内申购账户少一个数量级。因为其中我只区分了折价和溢价两种情况进行数据分析，但是实际上不同溢价时申购账户的区别其实是很大的。
<br />因为场外账户远少于场内账户，我可以放心的忽略二者在不同申购日期下不同净值等细节，把所有申购都假设成为场内申购计算。把限购1000人民币以来所有溢价申购日期数据统一做线性回归，可以得到结果：{$strFundAccount}
<br />顺便做一个通用一元{$strLinear}工具。
$strImage
</p>
END;
}

function Echo20191025($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strFundAccount = GetNameLink('fundaccount', FUND_ACCOUNT_DISPLAY);
	$strNavHistory = GetNameLink('netvaluehistory', NETVALUE_HISTORY_DISPLAY);
	$strNavHistoryLink = GetNavHistoryLink(FUND_DEMO_SYMBOL, 'num=0', '统计');
	$strFundPositionLink = GetFundPositionLink(FUND_DEMO_SYMBOL);
	$strSZ160216 = GetFundPositionLink('SZ160216', true);
	$strLof = _getLofLink();
	$strSH501018 = GetFundPositionLink('SH501018', true);
	$strMaster = GetXueqiuIdLink('1873146750', '惊艳大师');
	$strQDII = _getQdiiLink();
	$strElementaryTag = GetNameTag('elementary', '小学生');
	$strWei = GetXueqiuIdLink('1135063033', '魏大户');
	$strOilFundTag = GetNameTag('oilfund', OIL_GROUP_DISPLAY);
	$strImage = ImgPanicFree();
	
    echo <<<END
	$strHead
<p>2019年10月25日
<br />华宝油气在国庆假期后持续高溢价，到今天已经连续第13个交易日。吃瓜群众们充分利用华宝油气限购1000的机会，开始了新开1+6拖拉机账户溢价申购套利的狂欢之旅，从10月11号到现在测算的申购账户数一直在创历史新高。
不断新开的账户把我线性回归进行{$strFundAccount}的结果活生生搞成了非线性。
<br />10月22日那天场内新增了5766万股，对应限购1000人民币下场内满额申购了22127户，全部场内份额已经接近65亿股。好几个人看到迅速增加的份额后都问我华宝油气会不会继续把限额降到100块或者是彻底关门。
我暗自一笑，回答说你们想多了。华宝基金有对它来说更聪明应对方式，其实在8月份刚开始限额申购后的那一轮溢价申购时已经表现出来了。
<br />这个聪明方法是主动降低股票持仓仓位比例，把大家新申购的人民币拿在手里除了收管理费以外什么都不做。 
我修改了一下平时基本闲置的{$strNavHistory}页面，{$strNavHistoryLink}了过去4年来的华宝油气仓位估算结果。
可以看出在今年8月份之前，基本上都是稳定维持在基金说明书中写的95%附近；8月份降到了85%-90%，9月份经过连续11个交易日折价大量赎回后，9月底时仓位又回到了95%。
<br />为了避免一般的华宝油气官方估值的误差来源的影响，我在这里只选择了XOP当晚净值涨跌幅度大于4%的日子进行仓位估算，因为仓位回到95%以后没有这样的大波动，这样的话当前华宝油气具体仓位依然是个谜。 
下一个XOP大涨或者大跌后不出意外的话，肯定是会再次看到华宝油气上涨跟不上涨幅，下跌也跟不上跌幅的。
<br />显然华宝油气在雪球的工作人员对目前仓位降低的问题是了然于胸的。昨天我的估值软件给出10月23日的净值是0.387，而他在雪球狡猾的给出了0.386，结果公布后果然是他对了。
<br />XOP净值在10月21到23日连续每天小涨，没有一天达到了我定的4%的标准，所以我一直没能有效的测算目前的实际仓位。 
不过这3天累计的涨幅达到了5.14%，我于是灵机一动，想到了可以优化一下算法：不用拘泥于单日的涨跌，只要连续几天的累计涨幅或者跌幅超过了4%就计算一次仓位。
<br />这样我又增加了一个专门估算仓位的新页面：$strFundPositionLink
<br />加了新页面后继续脑洞大开，我又加了一行输入界面，从此可以自行设置4%的阈值。
<br />既然现在有了实测的数据，当然要把它们派上用场。不过我暂时只把SZ162411和{$strSZ160216}仓位用在了估值上，而跟SZ160216类似的{$strSH501018}仓位就一直坚持使用{$strLof}缺省的95%的不变。在估值页面上显示了实际使用的估值仓位。
<br />国泰商品跟华宝油气是2011到2012年基本上同时代的第一批QDII基金，开始几年没啥人气。2015年传说中的著名网络写手烟雨江南邱晓华卸任基金经理前，把名字上依然保持着大宗商品的SZ160216改造成了一个纯油基金，净值几乎100%跟随USO和美油期货CL。
也就是说，我可以用USO准确的给这4年以来的国泰商品估值。
<br />100%跟随CL就意味着可以套利。在CL砸向2016初的26美元那一轮中，可以抄底油价又可以套利的国泰商品跟华宝油气一样迅速成长起来，QDII场内流动性仅次于华宝油气。在华宝油气2016年1月21日因为外汇额度彻底关门后，国泰商品也在2016年2月24日彻底关门。
<br />接下来神奇的事情发生了。随着油价迅速反弹，华宝油气很快就在2016年3月25日恢复了每日10万限额的申购，到了当年4月8日更是恢复到了50万。而国泰商品却一直到2017年的5月11日才恢复每日1000的限额申购，然后2018年8月21日至今一直是每日限额1万。
民间传说是国泰基金把外汇额度挪到其它产品上去了。可能是因为关门时间太长，之前累积起来的流动性一去不复返，以至于现在连南方原油都不如。
<br />事实上，当SH501018计划在2016年中间上市的时候，我看到的套利群体是对它寄予厚望的，希望它能重复国泰商品100%跟CL的模式方便大家赚钱。可惜南方基金没采用现成的套利促进流动性的模式，所以它到现在的流动性也还是苦哈哈。
<br />因为国内监管的要求，SZ160216和SH501018这种FOF的持仓不能过于集中。SZ160216费了不少力气让自己的持仓跟USO保持100%一致。因为美股市场上没有足够多的原油ETF品种选择，它同时持有了小部分2倍日内杠杆的原油ETF和看多美元的ETF，甚至还有一点点贵金属ETF，说白了就是为了满足监管的分散要求。
而SH501018更离谱，它持仓了很大一部分欧洲市场上的原油ETF，由于市场收盘时间不同，市场假期也有差异，我用USO给它估值就不准了，反向计算出来的仓位就更加不靠谱。
<br />想给SH501018正确估值，使用SZ162411的这种单一品种参考模式是不行的。{$strMaster}计算{$strQDII}净值的Excel虽然在我的网页工具出来后落寞了许多，不过他说了，用XOP估算华宝油气净值只是{$strElementaryTag}水平，能够用实际的详细持仓明细估算南方原油净值才算初中生水平！
<br />{$strWei}在雪球和公众号上写了一系列A股大时代的故事，一直用这个封面图片。因为我今天也忍不住开始讲{$strOilFundTag}基金历史的故事，就东施效颦也放个图。
$strImage
</p>
END;
}

function Echo20191107($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strFundAccount = GetNameLink('fundaccount', FUND_ACCOUNT_DISPLAY);
	$strBegin = GetNameLink('daylightsavingbegin', '夏令时开始');
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	
    echo <<<END
	$strHead
<p>2019年11月7日
<br />没想到9月份写的{$strFundAccount}让我意外发现了一个跟{$strBegin}配对的BUG。
<br />我昨天看了一下11月4日轻微折价下的场内申购预估数量。 因为我平时做线性回归是不用折价日的申购数据的，所以特意留心了一下。结果今天发现{$strFundHistory}中11月4日的数据竟然没有显示出来。 
<br />查了半天终于找到了问题：我原来用11月1日周五的日期加上3天的秒数，期望得到11月4日的日期。却没料到赶上了11月3日结束夏令时，3天的秒数不够，结果得到的是11月3日的日期。这个问题隐藏了好几年，但是以前一直没有像现在这样每天盯着折价溢价数据看，所以一直没发现。
</p>
END;
}

function Echo20200113($strHead)
{
	$strHead = GetHeadElement($strHead);

    echo <<<END
	$strHead
<p>2020年1月13日
<br />流动性是个很神奇的东西，我一直喜欢用高速公路上的车流来比喻它。不知道什么时候原本高速行驶的车流会突然慢下来塞住，又不知道什么时候会逐步缓解直到重新一路畅通。
<br />今天收盘后，华宝基金发布了一个给我当头一棒的公告，要开始销售C类华宝油气份额。0申购费、7日后0赎回费、同时还降低管理费率的场外C类份额无疑会严重打击场内SZ162411的流动性。我感觉华宝基金在犯一个明显的错误，一旦流动性开始下降，紧跟着会下降的就是市场规模了。
</p>
END;
}

function Echo20200326($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strFundPosition = GetNameLink('fundposition', FUND_POSITION_DISPLAY);
	$strLof = _getLofLink();
	$strSZ160216 = GetFundPositionLink('SZ160216', true);
	$strSZ162719 = GetFundPositionLink('SZ162719', true);
	$strSZ163208 = GetFundPositionLink('SZ163208', true);
	
    echo <<<END
	$strHead
<p>2020年3月26日
<br />从{$strFundPosition}可以看到，之前国泰商品仓位一直中规中矩的保持在{$strLof}标准的95%附近。不过在3月6日开始的这一轮CL断崖式下跌后，它的仓位也随着断崖式下跌了。目前估算仓位59%，已经只有大半桶油。
<br />国泰商品在3月13日停止了申购，紧接着的3月16日周一广发石油也停止了申购。因为海外账户保证金不够的原因，突然的大额申购可能会让SZ160216和SZ162719这种QDII基金在随后的大约一周内出现明显的仓位降低。
可以看到{$strSZ162719}仓位在3月20日就恢复到了正常的95%附近。那么，SZ160216一直没有恢复仓位，是不是它也采用了SZ162411类似的降仓位保申购的方式，尽可能吸引流动性？要知道，早已经在2月14日再次关门后的华宝油气因为美元资产净值的大幅降低，它如今的仓位已经由基金公司恪守的80%底线被动降低到了75%。
<br />这个问题其实难于判断，因为在基金公司有意降低仓位保申购的可能性外，还有另外一个解释：在国泰商品的持仓中，能保持迅速跟上当月CL跌幅的USO只是其中之一，此外还有大量像USL这种持仓很多远期CL的，所以看上去表现就像{$strSZ160216}仓位不足了。
<br />无论是什么原因，既然表现出来的仓位已经如此之低，用CL对冲的要小心，很容易一下子多空36%的仓位，一旦油价快速反弹就亏惨。
<br />基于类似的逻辑，持有XLE、XOP和IXC等多只美股原油股票ETF的诺安油气也会显示出它相对于XLE波动的仓位区别，为避免莫名其妙的亏钱，用XLE对冲前一定要记得看一眼实际表现出来的{$strSZ163208}仓位！
</p>
END;
}

function Echo20210227($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strBtok = GetExternalLink('https://0.plus');
	$strWeb = GetExternalLink('https://web.telegram.im');
	
    echo <<<END
	$strHead
<p>2021年2月27日
<br />因为微信个人订阅号的各种限制，最近削尖铅笔基于Telegram电报API开发了机器人@palmmicrobot，把{$strWeixin}上的查询功能完全复制到了电报软件上。同时创建了@palmmicrocast频道，用来主动发布用户在各种渠道查询过程中碰到的可能需要提醒的信息。
<br />电报是开源的，而且鼓励大家把它无缝集成到各种应用场景中。墙内使用电报可以从{$strBtok}下载安装Btok手机APP，也可以使用非官方的WEB版本{$strWeb}。
<br />互联网不是法外之地，虽然墙外的电报软件能畅所欲言并且避免恶意举报，请大家记住Palmmicro的一切都是实名可以抓到我的，不要在电报中有关Palmmicro的地方乱说话！
<br />不忘初心，接下来打算写个用电报机器人管理的基于MQTT协议的IoT模块。
</p>
END;
}

function Echo20210320($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strError = GetFontElement('剩余群发次数为0');
	
    echo <<<END
	$strHead
<p>2021年3月20日
<br />{$strWeixin}发文章时出现{$strError}的错误信息后，上网搜了一圈没找到解决方案。后来发现是最近写文章太积极，在已经发出文章的19日就开始写了20日的开头，等到20日要群发时，系统还没反应过来。
<br />解决方法很简单，先保存到公众号创作管理的图文素材中，然后再重新打开编辑后发送，或者直接发送都可以。
</p>
END;
}

function Echo20210613($strHead)
{
	$strHead = GetHeadElement($strHead);
	
    echo <<<END
	$strHead
<p>2021年6月13日
<br />前几天微信公众平台进去后显示白板，隔一段时间后恢复正常，以为是临时审查工作过度繁忙导致。结果后来再次发作后一直不恢复了，等了几天后开始在网上查解决方案，发现是因为网站cookie过多，清除后解决问题。
</p>
END;
}

function Echo20210624($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strKWEB = GetHoldingsLink('KWEB', true);
	$strQDII = _getQdiiLink();
	$strSZ164906 = GetStockLink('SZ164906');
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	$strLof = _getLofLink();
	$strElementary = GetNameLink('elementary', '小学生');
	$strImage = ImgMrFox();
	
    echo <<<END
	$strHead
<p>2021年6月24日
<br />虽然原则上来说XOP也可以使用这个页面，但是它其实是为同时有港股和美股的{$strKWEB}持仓准备的。
<br />{$strQDII}基金总是越跌规模越大，流动性越好，前些年是华宝油气，而今年最热门的变成了中概互联。按SZ162411对应XOP的模式，中概互联的小弟SZ164906之前是用KWEB估值的。
不过因为中国互联有1/3的港股持仓，它的净值在港股交易时段会继续变化，所以原来的{$strSZ164906}页面其实没有什么实际用处。唯一的好处是在{$strFundHistory}中累积了几年的官方估值误差数据，帮我确认了用KWEB持仓估值中国互联的可行性。
<br />跟A股{$strLof}基金每个季度才公布一次前10大持仓不同，美股ETF每天都会公布自己的净值和详细持仓比例。因为KWEB和中国互联跟踪同一个中证海外中国互联网指数H11136，这样可以从KWEB官网下载持仓文件后，根据它的实际持仓估算出净值。然后SZ164906的参考估值也就可以跟随白天的港股交易变动了。
<br />写了快6年的估值软件终于从{$strElementary}水平进化到了初中生水平，还是有些成就感的。暑假即将来到，了不起的狐狸爸爸要开始教已经读了一年小学的娃在Roblox上编程了。
$strImage
</p>
END;
}

function Echo20210714($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strNavHistory = GetNameLink('netvaluehistory', NETVALUE_HISTORY_DISPLAY);
	$strFundLinks = GetFundLinks(FUND_DEMO_SYMBOL);
	
    echo <<<END
	$strHead
<p>2021年7月14日
<br />相对于{$strNavHistory}等其它历史数据，这个页面来得实在是比较晚，主要是之前做华宝油气套利时不需要特别关注每天的场内新增份额，反正流动性足够好。不过随着XOP一路上涨，华宝油气的上百亿场内规模只剩下了零头，失去了流动性的华宝油气和XOP跨市场套利变成了屠龙之技。
我也被迫开始关注像中国互联这种流动性不是那么好的品种，为以后的套利早做打算。
<br />历史数据页面汇总：{$strFundLinks}
</p>
END;
	
	EchoFundShareParagraph(StockGetFundReference(FUND_DEMO_SYMBOL));
}

function Echo20210728($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSH513050 = GetStockLink('SH513050');
	$strChinaInternet = GetStockCategoryLink('chinainternet');
	$strSZ159605 = GetStockLink('SZ159605');
	$strSZ159607 = GetStockLink('SZ159607');
	$strHoldings = GetNameLink('holdings', HOLDINGS_DISPLAY);
	$strQdiiMix = GetStockMenuLink('qdiimix');
	$strFundPosition = GetNameLink('fundposition', FUND_POSITION_DISPLAY);
	$strQdiiHk = _getStockMenuLink('qdiihk');
	$strQdii = _getStockMenuLink('qdii');
	$strImage = ImgHuangRong();
	
    echo <<<END
	$strHead
<p>2021年7月28日
<br />从QDII中分出来，采用跟踪成分股变化的方式对同时有美股和港股持仓的{$strSH513050}等进行净值估算。
<br />A股大妈最喜欢干的事情就是抄底。随着过去半年来中概互联一路跌成了{$strChinaInternet}，中概互联网ETF的市场规模和流动性都在暴涨，就连原来叫中国互联的SZ164906都蹭热度借增加扩位简称的机会改名成了中概互联网LOF。看得我口水流一地，忍不住想做点什么蹭蹭热点。
<br />跟SZ164906和KWEB跟踪同一个指数H11136不同，SH513050跟踪的是另外一个不同的中证海外中国互联网50指数H30533。H30533和H11136在成分股选择上基本一致，但是H30533对单一成分股最大仓位限制是30%，而H11136限制10%的最大仓位，这样导致它们俩在腾讯和阿里持仓比例上区别巨大。
在中间的是跟踪中证海外中国互联网30指数930604的{$strSZ159605}和{$strSZ159607}，限制15%的最大仓位。另外，顾名思义930604的成分股数量要少50-30=20只。
<br />SH513050的成分股和比例来自于上交所官网的ETF申购赎回清单，SZ159605和SZ159607来自深交所官网的ETF申购赎回清单，这样未来可以方便的继续扩大新成员。SZ164906的成分股和比例依旧还是来自KWEB官网公布的每日{$strHoldings}更新。
<br />把SZ164906从老QDII挪到新的{$strQdiiMix}其实是个相当痛苦的过程，原来以SZ162411为模板写的{$strFundPosition}等功能都要从QDII拓展出来，{$strQdiiHk}在这个过程中也跟着沾了光。
<br />官方估值跟原来{$strQdii}一样，不过参考估值有所不同。除了当日汇率的变化外，参考估值在港股开盘后还会反应当日港股成分股的变动对净值的影响。
$strImage
</p>
END;
}

function Echo20211129($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strChinaInternet = _getStockCategoryLink('chinainternet');
	$strImage = ImgGreatDynasty();
	
    echo <<<END
	$strHead
<p>2021年11月29日
<br />今天很不高兴，写的《{$strChinaInternet}LOF(164906)限购1000》的文章竟然几小时后就被人举报删除了。死了张屠夫，不吃有毛猪，以后还是要努力坚持做自己的网站。
<br />其实早在因为举报连续被封了八个QQ群，附带被封了用了二十多年的QQ号之后，我就预感到了微信迟早也会被封。如今离开了QQ没有关系，没有微信的话可是刷不了绿码连门都出不了，只能彻底放弃腾讯家包括公众号在内的一切公开使用了。
$strImage
</p>
END;
}

function Echo20220121($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSinaJs = GetSinaJsLink();
	
    echo <<<END
	$strHead
<p>2022年1月21日
<br />在新浪股票数据接口加上Referer检查后，不能直接用浏览器看结果了，加上{$strSinaJs}调试工具页面。
</p>
END;
}

function Echo20220914($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strWeixin = _getWeixinLink();
	$strEndWechat = GetNameLink('endweixin', '放弃微信');
	$strWoody1234 = GetXueqiuIdLink('2244868365', 'woody1234');
	$strChinaInternet = _getStockCategoryLink('chinainternet');
	$strSH513220 = GetStockLink('SH513220', true);
	$strSH513360 = GetStockLink('SH513360', true);
	$strImage = ImgRuLai();
	
    echo <<<END
	$strHead
<p>2022年9月14日
<br />在美军从越南撤退的时候，美国政府估计其中有相当大比例的染上了毒瘾。按当时的普遍研究，吸毒者复发的可能性高达90%以上，如何面对预期中几十万退伍的瘾君子成了一个严峻的问题。然后让严阵以待的社会学家们完全没有想到的是，事实上复发的比例不到5%。
于是研究者们又挖空心思搞了一个新理论出来：只要远离了原来上瘾的环境，就不容易再次上瘾。
<br />在我刚开始混雪球和搞{$strWeixin}的时候，对成为股票套利大V曾经是满怀希望的。这个希望破灭在QQ群和号被封后。我意识到套利者群体中其实不少人是满怀敌意的。而且即使不举报我，出于秘籍不能外传的心理，绝大多数套利者也不会愿意主动帮我分享，因此这条大V之路其实走不通。
<br />不幸的是，我发现我上瘾了，每天花了大量的时间搞无效的网络社交。于是开始有意的让自己远离上瘾环境。公众号在去年11月因为举报封了我一篇文章，我就不再更新文章，{$strEndWechat}上6000多的订阅者；雪球在今年2月删除了我一条宣传网站的评论，我就弃用了13000多粉丝的{$strWoody1234}帐号。从此彻底戒断大V梦想。
<br />戒断上瘾总会有副作用，对我来说，就是口头上喊着要努力专心做好自己的网站，实际上在很长时间内却再也提不起兴致，以至于经常放在嘴边自嘲的每天20行代码都断了很久。
<br />7月份的时候，我注意到{$strChinaInternet}来了个新成员{$strSH513220}，本来想简单的通过拷贝复制加上，却发现跟其它老丐帮成员不同，它居然还有A股成分股。一下子我的拖延症就犯了，一直拖到这个月才动手。
<br />既然加上了A股成分股的处理，那么把老的同样同时有美股、港股和A股成分股的{$strSH513360}加上也就成了简单的拷贝复制。剩下就看在没有网络宣传的情况下，搜索引擎们能多有效的帮助用户找到这些估值网页了。
$strImage
</p>
END;
}

function Echo20230521($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strSH513000 = GetStockLink('SH513000', true);
	$strChinaInternet = _getStockCategoryLink('chinainternet');
	$strSH513520 = GetStockLink('SH513520');
	$strSH513880 = GetStockLink('SH513880');
	$strSZ159866 = GetStockLink('SZ159866');
	$strQdiiJp = GetStockMenuLink('qdiijp');
	$strQdiiHk = _getStockMenuLink('qdiihk');
	$strNKY = GetSinaQuotesLink('znb_NKY', false);
	$strNK = GetSinaQuotesLink('hf_NK', false);
	
    echo <<<END
	$strHead
<p>2023年5月21日
<br />四个跟踪日经225的ETF上市好几年来一直不愠不火，我觉得它们流动性不好就没有去搞估值。直到19日周五收盘{$strSH513000}场内溢价拉到了20%，让我觉得不能再观望下去了！毕竟只要有人来拉溢价，流动性就可能会好起来。
<br />能够拉溢价的原因是多方面的，比如巴菲特月初开股东大会宣传增持日本五大商社，日本股市最近几天创下三十多年新高接近1990年最高水平，但是关键还是在于限购。
易方达基金公司因为{$strChinaInternet}缺QDII额度，SH513000每天限制申购50万份。而作为ETF，它又要求每次最少申购50万份，这样每天只有一个幸(kai)运(hou)儿(men)能申购到。
<br />{$strSH513520}同样因为限购总份额50万份也被拉到了接近20%的溢价，而{$strSH513880}和{$strSZ159866}则因为分别限购1500万和1亿份而基本上平价。
<br />{$strQdiiJp}跟{$strQdiiHk}的估值模式基本上是一致的。中国和日本股市都开市的日子里，用新浪日经225指数数据{$strNKY}做官方估值，日本股市北京时间下午两点收盘后官方估值就不再改变，直到晚上跟公布的实际净值比较和自动校准。
同时全天都用新浪日经225指数期货数据{$strNK}做实时估值，可以反映日本股市收盘后的变化。
</p>
END;
}

function Echo20230525($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strQDII = _getQdiiLink();
	$strQdiiJp = _getStockMenuLink('qdiijp');
	$strSH513030 = GetStockLink('SH513030', true);
	$strSH513080 = GetStockLink('SH513080', true);
	$strDAX = GetSinaQuotesLink('znb_DAX', false);
	$strCAC = GetSinaQuotesLink('znb_CAC', false);
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	
    echo <<<END
	$strHead
<p>2023年5月25日
<br />华安基金公司的{$strQDII}基金不仅有跟踪美国和日本股市的ETF，还有德国和法国的。之前我都用美股市场上的ETF给{$strSH513030}和{$strSH513080}，误差一直很大。
专门去看过它们的季报持仓，发现它们还真是在德国和法国市场上买股票，这样就像南方原油的估值一样，连收市时间都差几个小时，当然不准。
<br />在加了{$strQdiiJp}后，我意识到可以用同样的模式给这两个ETF估值，股指数据分别来自于新浪的{$strDAX}和{$strCAC}。目前德国和法国都在夏令时，北京时间下午三点开市，晚上11点半收市。
隔一段日子后到{$strFundHistory}页面看估值误差，就知道这个改动是否成功了。
</p>
END;
}

function Echo20230530($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strXueqiu = GetXueqiuIdLink('9933963417', 'Forest_g');
	$strQdiiMix = _getStockMenuLink('qdiimix');
	$strSH501225 = GetStockLink('SH501225', true);
	$strImage = ImgJensenHuang();
	$strSH501312 = GetStockLink('SH501312', true);
	
    echo <<<END
	$strHead
<p>2023年5月30日
<br />NVDA上周创历史的财报预期后，掀起了全球芯片股票的高潮，让我实在坐不住了。按{$strXueqiu}一个半月前的具体建议在{$strQdiiMix}中加上了同时持有美国和中国芯片股的{$strSH501225}估值页面。
$strImage
<br />不知道是持有多地上市股票的基金是今年的新潮流，还是只是为了躲开纳斯达克QDII基金的拥挤，华宝基金还搞了一个同时持有纳斯达克和香港科技的{$strSH501312}，顺便一并加了进来。
</p>
END;
}
?>
