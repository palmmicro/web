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

function Echo20191025($strHead)
{
	$strFundAccount = GetNameLink('fundaccount', FUND_ACCOUNT_DISPLAY);
	$strNavHistory = GetNameLink(TABLE_NETVALUE_HISTORY, NETVALUE_HISTORY_DISPLAY);
	$strNavHistoryLink = GetNetValueHistoryLink(FUND_DEMO_SYMBOL, 'num=0', '统计');
	$strFundPositionLink = GetFundPositionLink(FUND_DEMO_SYMBOL);
	
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
</p>
END;
}

function Echo20200326($strHead)
{
	$strSZ160216 = GetStockLink('SZ160216');
	$strSZ162719 = GetStockLink('SZ162719');
	$strSH501018 = GetStockLink('SH501018');
	$strImage = ImgPanicFree();
	$strFundPosition = GetNameLink('fundposition', FUND_POSITION_DISPLAY);
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2020年3月26日
<br />流动性是个很神奇的东西，我一直喜欢用高速公路上的车流来比喻它。不知道什么时候原本高速行驶的车流会突然慢下来塞住，又不知道什么时候会逐步缓解直到重新一路畅通。
<br />{$strSZ160216}跟SZ162411是2011到2012年基本上同时代的第一批QDII基金。开始几年没啥人气，2015年传说中的著名网络写手烟雨江南邱晓华卸任基金经理前，把名字上依然保持着大宗商品的国泰商品改造成了一个纯油基金，净值几乎100%跟随USO和美油期货CL。
也就是说，我可以用USO非常准确的给这4年多以来的国泰商品估值。
<br />100%跟随CL就意味着可以套利。在CL砸向2016初的26美元那一轮中，可以抄底油价又可以套利的国泰商品跟华宝油气一样迅速成长起来，QDII场内流动性仅次于华宝油气。在华宝油气2016年1月21日因为外汇额度彻底关门后，国泰商品也在2016年2月24日彻底关门。
<br />接下来神奇的事情发生了。随着油价迅速反弹，华宝油气很快就在2016年3月25日恢复了每日10万限额的申购，到了当年4月8日更是恢复到了50万。而国泰商品却一直到2017年的5月11日才恢复每日1000的限额申购，然后2018年8月21日至今一直是每日限额1万。
民间传说是国泰基金把外汇额度挪到其它产品上去了。可能是因为关门时间太长，之前累积起来的流动性一去不复返，以至于现在连南方原油都不如。
<br />事实上，当{$strSH501018}计划在2016年中间上市的时候，我看到的套利群体是对它寄予厚望的，希望它能重复国泰商品100%跟CL的模式方便大家赚钱。可惜南方基金没采用现成的套利促进流动性的模式，所以它到现在的流动性也还是苦哈哈。
<br />今年1月13日收盘后，华宝基金发布了一个给我当头一棒的公告，要开始销售C类华宝油气份额。0申购费、7日后0赎回费、同时还降低管理费率的场外C类份额无疑会严重打击场内SZ162411的流动性。我感觉华宝基金在重复南方基金的错误，一旦流动性开始下降，紧跟着会下降的就是市场规模了。
<br />魏大户在雪球和微信公众号上写了一系列A股大时代的故事，一直用这个封面图片。因为我今天也忍不住开始写亲历历史，就东施效颦也放个图。
$strImage
<br />从{$strFundPosition}可以看到，之前国泰商品的仓位一直中规中矩的保持在LOF标准的95%附近。不过在3月6日开始的这一轮CL断崖式下跌后，它的仓位也随着断崖式下跌了。目前估算仓位只有59%，已经只有大半桶油。
<br />国泰商品在3月13日停止了申购，紧接着的3月16日周一广发石油也停止了申购。因为海外账户保证金不够的原因，突然的大额申购可能会让SZ160216和{$strSZ162719}这种QDII基金在随后的大约一周内出现明显的仓位降低。
可以看到SZ162719在3月20日就恢复到了正常的95%仓位附近。那么，SZ160216一直没有恢复仓位，是不是它也采用了SZ162411类似的降仓位保申购的方式，尽可能吸引流动性？要知道，早已经在2月14日再次关门后的华宝油气因为美元资产净值的大幅降低，它如今的仓位已经由基金公司恪守的80%底线被动降低到了75%。
<br />这个问题其实难于判断，因为在基金公司有意降低仓位保申购的可能性外，还有另外一个解释：在国泰商品的持仓中，能保持迅速跟上当月CL跌幅的USO只是其中之一，此外还有大量像USL这种持仓很多远期CL的，所以看上去表现就像SZ160216仓位不足了。
<br />无论是什么原因，既然表现出来的仓位已经如此之低，用CL对冲的要小心，很容易一下子多空36%的仓位，一旦油价快速反弹就亏惨。
</p>
END;
}

?>
