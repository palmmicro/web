<?php
require_once('_entertainment.php');
require_once('/woody/blog/php/_stockdemo.php');

function EchoCalibrationHistoryLink($strSymbol = FUND_DEMO_SYMBOL)
{
	echo GetCalibrationHistoryLink($strSymbol);
}

function EchoFundHistoryLink()
{
	EchoNameLink('fundhistory', FUND_HISTORY_DISPLAY);
}

function EchoFundEstTables()
{
	EchoFundEstDemo();

	EchoTableParagraphBegin(array(new TableColumn('估值因素', 140),
								   new TableColumnOfficalEst(),
								   new TableColumnFairEst(),
								   new TableColumnRealtimeEst()
								   ), 'estcompare');
	EchoTableColumn(array('T日美股交易',		'XOP净值',	'XOP净值',	'XOP净值'));
	EchoTableColumn(array('CL期货',			'否',		'否',		'是'));
	EchoTableColumn(array('美元人民币中间价',	'T日',		'T/T+1日',	'T/T+1日'));
    EchoTableParagraphEnd();
}

function Echo20160222($strHead)
{
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	$strStockHistory = GetNameLink('stockhistory', STOCK_HISTORY_DISPLAY);
	$strNavHistoryLink = GetNavHistoryLink(FUND_DEMO_SYMBOL);
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2016年2月22日
<br />有人跟我指出{$strFundHistory}中净值的日期显示早了一天，我差点一口鲜血吐在了键盘上。用脚趾头想想，要计算华宝油气当天的交易溢价，肯定是要跟前一天的净值比较啊。当天的净值要等当晚美股收盘后才出来，否则的话我写这个净值估算有什么意义呢。
<br />把当天的交易价格跟前一天的净值放在一起比较，其实也正是我平时最为推崇的不同数据显示方式引导不同思维模式的举措。 
不过为了避免以后还有人搞混淆，我干脆另外加了一个单独的{$strNavHistoryLink}显示页面，算上最开始的{$strStockHistory}，现在总共有3个历史数据页面了。  
</p>
END;
}

function Echo20170128($strHead)
{
	$strWeiXin = GetLinkElement('微信公众号', '../palmmicro/20161014cn.php');
	$str600028 = GetQuoteElement('600028');
	$str00386 = GetQuoteElement('00386');
	$strSource = GetExternalLink(GetAastocksUrl('ah'));
	$strUpdate = DebugIsAdmin() ? GetInternalLink('/php/test/updateah.php', '更新AH股数据') : '';
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2017年1月28日
<br />为了有效配合今年的打新计划，我打算扩大中国石化外的门票范围。但是同时沿用AH股价格比较的思路，只选取A股价格低于H股的作为门票。
<br />{$strWeiXin}搞了几个月，使用者寥寥。不过开发微信公众号的过程中有个意外收获，帮助我彻底区分了净值计算和用户显示界面的代码。为了充分利用这个好处，我马上把它也包括在了微信公众号的查询结果中。输入查询{$str600028}或者{$str00386}试试看。
<br />数据来源：{$strSource}	{$strUpdate}
<br />同时增加个对比页面：
END;

   	$ref = new AhPairReference(AH_DEMO_SYMBOL);
   	EchoAhParagraph(array($ref));
}

function Echo20191025($strHead)
{
	$strFundAccount = GetNameLink('fundaccount', FUND_ACCOUNT_DISPLAY);
	$strNavHistory = GetNameLink('netvaluehistory', NETVALUE_HISTORY_DISPLAY);
	$strNavHistoryLink = GetNavHistoryLink(FUND_DEMO_SYMBOL, 'num=0', '统计');
	$strFundPositionLink = GetFundPositionLink(FUND_DEMO_SYMBOL);
	$strSZ160216 = GetFundPositionLink('SZ160216', true);
	$strSH501018 = GetFundPositionLink('SH501018', true);
	$strMaster = GetXueqiuIdLink('1873146750', '惊艳大师');
	$strQDII = GetNameLink('qdii');
	$strElementaryTag = GetNameTag('elementary', '小学生');
	$strWei = GetXueqiuIdLink('1135063033', '魏大户');
	$strOilFundTag = GetNameTag('oilfund', OIL_GROUP_DISPLAY);
	$strImage = ImgPanicFree();
	
	$strHead = GetHeadElement($strHead);
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
<br />既然现在有了实测的数据，当然要把它们派上用场。不过我暂时只把SZ162411和{$strSZ160216}仓位用在了估值上，而跟SZ160216类似的{$strSH501018}仓位就一直坚持使用LOF缺省的95%的不变。在估值页面上显示了实际使用的估值仓位。
<br />国泰商品跟华宝油气是2011到2012年基本上同时代的第一批QDII基金，开始几年没啥人气。2015年传说中的著名网络写手烟雨江南邱晓华卸任基金经理前，把名字上依然保持着大宗商品的SZ160216改造成了一个纯油基金，净值几乎100%跟随USO和美油期货CL。
也就是说，我可以用USO准确的给这4年以来的国泰商品估值。
<br />100%跟随CL就意味着可以套利。在CL砸向2016初的26美元那一轮中，可以抄底油价又可以套利的国泰商品跟华宝油气一样迅速成长起来，QDII场内流动性仅次于华宝油气。在华宝油气2016年1月21日因为外汇额度彻底关门后，国泰商品也在2016年2月24日彻底关门。
<br />接下来神奇的事情发生了。随着油价迅速反弹，华宝油气很快就在2016年3月25日恢复了每日10万限额的申购，到了当年4月8日更是恢复到了50万。而国泰商品却一直到2017年的5月11日才恢复每日1000的限额申购，然后2018年8月21日至今一直是每日限额1万。
民间传说是国泰基金把外汇额度挪到其它产品上去了。可能是因为关门时间太长，之前累积起来的流动性一去不复返，以至于现在连南方原油都不如。
<br />事实上，当SH501018计划在2016年中间上市的时候，我看到的套利群体是对它寄予厚望的，希望它能重复国泰商品100%跟CL的模式方便大家赚钱。可惜南方基金没采用现成的套利促进流动性的模式，所以它到现在的流动性也还是苦哈哈。
<br />因为国内监管的要求，SZ160216和SH501018这种FOF的持仓不能过于集中。SZ160216费了不少力气让自己的持仓跟USO保持100%一致。因为美股市场上没有足够多的原油ETF品种选择，它同时持有了小部分2倍日内杠杆的原油ETF和看多美元的ETF，甚至还有一点点贵金属ETF，说白了就是为了满足监管的分散要求。
而SH501018更离谱，它持仓了很大一部分欧洲市场上的原油ETF，由于市场收盘时间不同，市场假期也有差异，我用USO给它估值就不准了，反向计算出来的仓位就更加不靠谱。
<br />想给SH501018正确估值，使用SZ162411的这种单一品种参考模式是不行的。{$strMaster}计算{$strQDII}净值的Excel虽然在我的网页工具出来后落寞了许多，不过他说了，用XOP估算华宝油气净值只是{$strElementaryTag}水平，能够用实际的详细持仓明细估算南方原油净值才算初中生水平！
<br />{$strWei}在雪球和微信公众号上写了一系列A股大时代的故事，一直用这个封面图片。因为我今天也忍不住开始讲{$strOilFundTag}基金历史的故事，就东施效颦也放个图。
$strImage
</p>
END;
}

function Echo20191107($strHead)
{
	$strFundAccount = GetNameLink('fundaccount', FUND_ACCOUNT_DISPLAY);
	$strBegin = GetNameLink('daylightsavingbegin', '夏令时开始');
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	
	$strHead = GetHeadElement($strHead);
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
	$strFundPosition = GetNameLink('fundposition', FUND_POSITION_DISPLAY);
	$strSZ160216 = GetFundPositionLink('SZ160216', true);
	$strSZ162719 = GetFundPositionLink('SZ162719', true);
	$strSZ163208 = GetFundPositionLink('SZ163208', true);
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2020年3月26日
<br />从{$strFundPosition}可以看到，之前国泰商品仓位一直中规中矩的保持在LOF标准的95%附近。不过在3月6日开始的这一轮CL断崖式下跌后，它的仓位也随着断崖式下跌了。目前估算仓位59%，已经只有大半桶油。
<br />国泰商品在3月13日停止了申购，紧接着的3月16日周一广发石油也停止了申购。因为海外账户保证金不够的原因，突然的大额申购可能会让SZ160216和SZ162719这种QDII基金在随后的大约一周内出现明显的仓位降低。
可以看到{$strSZ162719}仓位在3月20日就恢复到了正常的95%附近。那么，SZ160216一直没有恢复仓位，是不是它也采用了SZ162411类似的降仓位保申购的方式，尽可能吸引流动性？要知道，早已经在2月14日再次关门后的华宝油气因为美元资产净值的大幅降低，它如今的仓位已经由基金公司恪守的80%底线被动降低到了75%。
<br />这个问题其实难于判断，因为在基金公司有意降低仓位保申购的可能性外，还有另外一个解释：在国泰商品的持仓中，能保持迅速跟上当月CL跌幅的USO只是其中之一，此外还有大量像USL这种持仓很多远期CL的，所以看上去表现就像{$strSZ160216}仓位不足了。
<br />无论是什么原因，既然表现出来的仓位已经如此之低，用CL对冲的要小心，很容易一下子多空36%的仓位，一旦油价快速反弹就亏惨。
<br />基于类似的逻辑，持有XLE、XOP和IXC等多只美股原油股票ETF的诺安油气也会显示出它相对于XLE波动的仓位区别，为避免莫名其妙的亏钱，用XLE对冲前一定要记得看一眼实际表现出来的{$strSZ163208}仓位！
</p>
END;
}

function Echo20210624($strHead)
{
	$strKWEB = GetHoldingsLink('KWEB', true);
	$strQDII = GetNameLink('qdii');
	$strChinaInternetTag = GetNameTag('chinainternet', '中丐互怜');
	$strSZ164906 = GetStockLink('SZ164906');
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	$strElementary = GetNameLink('elementary', '小学生');
	$strImage = ImgMrFox();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年6月24日
<br />虽然原则上来说XOP也可以使用这个页面，但是它其实是为同时有港股和美股的{$strKWEB}持仓准备的。
<br />{$strQDII}基金总是越跌规模越大，流动性越好，前些年是华宝油气，而今年最热门的变成了{$strChinaInternetTag}。按SZ162411对应XOP的模式，中概互联的小弟SZ164906之前是用KWEB估值的。
不过因为中国互联有1/3的港股持仓，它的净值在港股交易时段会继续变化，所以原来的{$strSZ164906}页面其实没有什么实际用处。唯一的好处是在{$strFundHistory}中累积了几年的官方估值误差数据，帮我确认了用KWEB持仓估值中国互联的可行性。
<br />跟A股LOF基金每个季度才公布一次前10大持仓不同，美股ETF每天都会公布自己的净值和详细持仓比例。因为KWEB和中国互联跟踪同一个中证海外中国互联网指数H11136，这样可以从KWEB官网下载持仓文件后，根据它的实际持仓估算出净值。然后SZ164906的参考估值也就可以跟随白天的港股交易变动了。
<br />写了快6年的估值软件终于从{$strElementary}水平进化到了初中生水平，还是有些成就感的。暑假即将来到，了不起的狐狸爸爸要开始教已经读了一年小学的娃在Roblox上编程了。
$strImage
</p>
END;
}

function Echo20210714($strHead)
{
	$strNavHistory = GetNameLink('netvaluehistory', NETVALUE_HISTORY_DISPLAY);
	$strFundLinks = GetFundLinks(FUND_DEMO_SYMBOL);
	
	$strHead = GetHeadElement($strHead);
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
	$strSH513050 = GetStockLink('SH513050');
	$strChinaInternet = GetNameLink('chinainternet', '中丐互怜');
	$strSZ159605 = GetStockLink('SZ159605');
	$strSZ159607 = GetStockLink('SZ159607');
	$strFundPosition = GetNameLink('fundposition', FUND_POSITION_DISPLAY);
	$strQdiiHk = GetNameLink('qdiihk', QDII_HK_DISPLAY);
	$strQDII = GetNameLink('qdii', QDII_DISPLAY);
	$strImage = ImgHuangRong();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年7月28日
<br />从QDII中分出来，采用跟踪成分股变化的方式对同时有美股和港股持仓的{$strSH513050}等进行净值估算。
<br />A股大妈最喜欢干的事情就是抄底。随着过去半年来中概互联一路跌成了{$strChinaInternet}，中概互联网ETF的市场规模和流动性都在暴涨，就连原来叫中国互联的SZ164906都蹭热度借增加扩位简称的机会改名成了中概互联网LOF。看得我口水流一地，忍不住想做点什么蹭蹭热点。
<br />跟SZ164906和KWEB跟踪同一个指数H11136不同，SH513050跟踪的是另外一个不同的中证海外中国互联网50指数H30533。H30533和H11136在成分股选择上基本一致，但是H30533对单一成分股最大仓位限制是30%，而H11136限制10%的最大仓位，这样导致它们俩在腾讯和阿里持仓比例上区别巨大。
在中间的是跟踪中证海外中国互联网30指数930604的{$strSZ159605}和{$strSZ159607}，限制15%的最大仓位。另外，顾名思义930604的成分股数量要少50-30=20只。
<br />SH513050的成分股和比例来自于上交所官网的ETF申购赎回清单，SZ159605和SZ159607来自深交所官网的ETF申购赎回清单，这样未来可以方便的继续扩大混合QDII的成员。SZ164906的成分股和比例依旧还是来自KWEB官网公布的每日持仓更新。
<br />把SZ164906从老QDII挪到新的混合QDII其实是个相当痛苦的过程，原来以SZ162411为模板写的{$strFundPosition}等功能都要从QDII拓展出来，{$strQdiiHk}在这个过程中也跟着沾了光。
<br />官方估值跟原来{$strQDII}一样，不过混合QDII的参考估值有所不同。除了当日汇率的变化外，参考估值在港股开盘后还会反应当日港股成分股的变动对净值的影响。
$strImage
</p>
END;
}

?>
