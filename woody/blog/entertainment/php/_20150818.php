<?php
require_once('_entertainment.php');
require_once('../php/_stockdemo.php');

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

function Echo20150827($strHead)
{
	$strImage = ImgRonin();
	$strQDII = GetStockMenuLink('qdii');
	$strSZ159920 = GetStockLink('SZ159920', true);
	$strSH510900 = GetStockLink('SH510900', true);
	$strSH513500 = GetStockLink('SH513500', true);
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2015年8月27日
<br />整理代码最好的方式是多开发几个类似{$strQDII}。伴随最近抄底港股加入{$strSZ159920}和{$strSH510900}净值计算工具，观摩美股崩盘期间顺手加入了{$strSH513500}净值计算工具，也许日后会用上。
<br />牢记股市三大幻觉：A股要涨、美股见顶、港股便宜！
$strImage
</p>
END;
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

function Echo20161006($strHead)
{
	$strSZ162411 = GetCalibrationHistoryLink(FUND_DEMO_SYMBOL, true).CALIBRATION_HISTORY_DISPLAY;
	$strUSO = GetCalibrationHistoryLink('USO', true).CALIBRATION_HISTORY_DISPLAY;
	$strQDII = GetNameLink('qdii');
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2016年10月6日
<br />在华宝油气估值的时候，每次拿到官方发布的净值后都会根据净值当天的美股数据和美元人民币中间价做一次自动校准，从现在开始全部在{$strSZ162411}页面记录下来，方便观察长期趋势。校准时间就是拿到新的官方净值后第一次访问的时间。
类似的版面上还有CL和{$strUSO}，用在{$strQDII}基金的实时估值上。
<br />碰到XOP分红除权的日子，就需要进行手工校准。否则的话要等下一次自动校准后，估值结果才会再次正确。
</p>
END;
}

function _getUpdateChinaStockLink($strNode, $strDisplay)
{
	return DebugIsAdmin() ? GetInternalLink('/php/test/updatechinastock.php?node='.$strNode, $strDisplay) : '';
}

function Echo20161020($strHead)
{
	$strNode = 'hs_a';
	
	$strQuote = GetQuoteElement('交通银行');
	$strChinaStock = GetExternalLink(GetSinaChinaStockListUrl($strNode));
	$strUpdateChinaStock = _getUpdateChinaStockLink($strNode, '更新A股数据');
	$strUsStock = GetExternalLink(GetSinaUsStockListUrl());
	$strUpdateUsStock = DebugIsAdmin() ? GetInternalLink('/php/test/updateusstock.php', '更新美股数据') : '';
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2016年10月20日
<br />今天发现有个微信公众号用户用语音查询{$strQuote}，没查到因为数据库中根本没有它。不过因此刺激了我给加上查询所有股票交易数据的功能。
<br />首先我要把A股3000多只股票都加到数据库中。开始我想直接开个大循环从000001到699999从新浪拿数据，后来觉得太蠢了，还担心新浪的数据接口把我列入黑名单。不过接下来我从{$strChinaStock}找到了所有A股数据。$strUpdateChinaStock
<br />继续给数据库中加美股代码，希望{$strUsStock}这个不完整的美股单子能满足绝大多数中国用户的查询。$strUpdateUsStock
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
<br />{$strWeiXin}搞了几个月，使用者寥寥。不过开发微信公众号的过程中有个意外收获，帮助我彻底区分了净值计算和用户显示界面的代码。为了充分利用这个好处，我马上把它也包括在了微信公众号的查询结果中：输入{$str600028}或者{$str00386}试试看。
<br />数据来源：{$strSource}	{$strUpdate}
<br />同时增加个对比页面：
END;

   	$ref = new AhPairReference(AH_DEMO_SYMBOL);
   	EchoAhParagraph(array($ref));
}

function Echo20171001($strHead)
{
	$strSMA = GetNameLink('sma');
	$strBollinger = GetNameLink('bollinger', '布林');
	
	$strHead = GetHeadElement($strHead);
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
	$strSMA = GetNameLink('sma');
	$strBollinger = GetNameLink('bollinger', '布林');
	$strEMA = GetNameLink('ema');
	
	$strHead = GetHeadElement($strHead);
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
	$strXueQiu = GetXueQiuIdLink('1955602780', '不明真相的群众');
	$strAhCompare= GetNameLink('ahcompare', AH_COMPARE_DISPLAY);
	$str00700 = GetQuoteElement('00700');
	$strTencent = GetQuoteElement('腾讯');
	$strSource = GetExternalLink(GetAastocksUrl());
	$strUpdate = DebugIsAdmin() ? GetInternalLink('/php/test/updateadr.php', '更新H股ADR数据') : '';
	$strTableSql = GetCodeElement('TableSql');
	$strValSql = GetCodeElement('ValSql');
	$strDateSql = GetCodeElement('DateSql');
	$strIntSql = GetCodeElement('IntSql');
	$strPairSql = GetCodeElement('PairSql');
	$strStockPairSql = GetCodeElement('StockPairSql');
	$strQDII = GetNameLink('qdii');
	$strCalibration = GetNameLink('calibrationhistory', CALIBRATION_HISTORY_DISPLAY);
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2018年4月4日
<br />雪球创始人方三文，自称{$strXueQiu}。平时总是苦口婆心的把盈亏同源放在嘴边，鼓动大家通过雪球资管做资产配置。但是他却认为自己对互联网企业有深刻理解，在推销自己私募的时候总是鼓吹腾讯和FB，又把盈亏同源抛在脑后了。
<br />最近2个月腾讯结束了屡创新高的行情，开始跟FB一起下跌，引发了大家抄底雪球方丈的热情。不仅港股腾讯00700每天巨量交易，就连它在美股粉单市场的ADR在雪球上都热闹非凡。
这吸引了我的注意力，然后发现港股还有其它不少股票也有美股市场的American Depositary Receipt(ADR)。于是我按照原来{$strAhCompare}的套路增加了个页面蹭一下热度。同时也加入到了微信公众号的查询中：输入{$strTencent}或者{$str00700}试试看。
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
END;

   	$ref = new AdrPairReference(ADRH_DEMO_SYMBOL);
   	EchoAdrhParagraph(array($ref));
   	EchoParagraph(GetQuoteElement('Life is like a snowball. The important thing is finding wet snow and a really long hill. — Warren Buffett'));
}

function Echo20180405($strHead)
{
	$strNode = 'hs_b';
	
	$strChinaStock = GetExternalLink(GetSinaChinaStockListUrl($strNode));
	$strUpdateChinaStock = _getUpdateChinaStockLink($strNode, '更新B股数据');
	$str000488 = GetQuoteElement('000488');
	$str200488 = GetQuoteElement('200488');
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2018年4月5日
<br />折腾完H股后觉得意犹未尽，一鼓作气继续加上AB股对比。其实我自己连B股账户都没有，写这个就是完全为了测试一下现有代码的可扩展性。此外，因为B股规模远小于A股，以后可以用来方便测试二者的共同代码。
<br />数据来自{$strChinaStock}。$strUpdateChinaStock 
<br />输入查{$str000488}或者{$str200488}试试看。
</p>
END;

   	$ref = new AbPairReference(AB_DEMO_SYMBOL);
   	EchoAbParagraph(array($ref));
}

function Echo20180410($strHead)
{
	$strCNY = GetQuoteElement('人民币汇率');
	$strLink = GetMyStockLink('USCNY');
	$strOldUSCNY = GetQuoteElement('美元人民币中间价');
	$strUSCNY = GetQuoteElement('美元人民币汇率中间价');
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2018年4月10日
<br />沉寂已久的微信公众号在清明假期中突然有人来查了下{$strCNY}，因为没有任何匹配，这个查询通知到了我的电子邮件中，让我感觉一下子打了鸡血，学习微信小程序开发的劲头一下子足了好多。
<br />微信订阅号中查不到用来估值的人民币汇率的确有点奇怪。原因是为了加快反应时间，向微信发的查询是不会去再去拿每天更新一次的人民币中间价数据的。
<br />当然这现在已经难不倒我了，我可以从数据库中把最近2天的中间价找出来，拼成跟其他数据类似的格式提供给用户。按惯例，又全面整理了几天代码，直到今天才完工。
<br />因为微信查找中我没有做中文分词，因此{$strCNY}这种5个字的长查询其实是很难匹配的。为了保证下次用户能查到，我还特意手工把数据库中{$strLink}的说明从{$strOldUSCNY}改成了{$strUSCNY}。
</p>
END;
}

function Echo20190601($strHead)
{
	$strImage = ImgTianHeng();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2019年6月1日
<br />两年多过去，微信公众号上现有517个用户，感觉基本上体现了目前华宝油气套利群体的规模。
<br />佛前五百罗汉，田横五百壮士；微信用户超过五百人就可以开通流量主收广告费了。
$strImage
</p>
END;
}

function Echo20190713($strHead)
{
	$strQuote = GetQuoteElement('019547');
	$strLink = GetSinaQuotesLink('sh019547');
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2019年7月13日
<br />昨天有人在微信公众号上查{$strQuote}没有匹配。看了一下{$strLink}，发现居然是国债。软件工具有人用终归是好事情，不过以前我好像听说过资产1000万美元以下的不应该考虑债券投资，所以还是按捺住了兴奋的心情，没有再次削尖铅笔给我的数据库加上所有A股债券数据。
<br />还有一个更加深刻的原因是，因为查询时会从头到尾遍历一遍股票数据库，现在的查询速度已经快要慢到了公众号的极限，实在不能想象再加一两万条债券进去会怎么样。
<br />基于相同的原因，既拖慢速度我自己又不用，公众号也不提供场外基金的数据查询。
</p>
END;
}

function Echo20191025($strHead)
{
	$strFundAccount = GetNameLink('fundaccount', FUND_ACCOUNT_DISPLAY);
	$strNavHistory = GetNameLink('netvaluehistory', NETVALUE_HISTORY_DISPLAY);
	$strNavHistoryLink = GetNavHistoryLink(FUND_DEMO_SYMBOL, 'num=0', '统计');
	$strFundPositionLink = GetFundPositionLink(FUND_DEMO_SYMBOL);
	$strSZ160216 = GetFundPositionLink('SZ160216', true);
	$strSH501018 = GetFundPositionLink('SH501018', true);
	$strMaster = GetXueQiuIdLink('1873146750', '惊艳大师');
	$strQDII = GetNameLink('qdii');
	$strElementaryTag = GetNameTag('elementary', '小学生');
	$strWei = GetXueQiuIdLink('1135063033', '魏大户');
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

function Echo20210227($strHead)
{
	$strBtok = GetExternalLink('https://0.plus');
	$strWeb = GetExternalLink('https://web.telegram.im');
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年2月27日
<br />因为微信个人订阅号的各种限制，最近削尖铅笔基于Telegram电报API开发了机器人@palmmicrobot，把微信公众号上的查询功能完全复制到了电报软件上。同时创建了@palmmicrocast频道，用来主动发布用户在各种渠道查询过程中碰到的可能需要提醒的信息。
<br />电报是开源的，而且鼓励大家把它无缝集成到各种应用场景中。墙内使用电报可以从{$strBtok}下载安装Btok手机APP，也可以使用非官方的WEB版本{$strWeb}。
<br />互联网不是法外之地，虽然墙外的电报软件能畅所欲言并且避免恶意举报，请大家记住Palmmicro的一切都是实名可以抓到我的，不要在电报中有关Palmmicro的地方乱说话！
<br />不忘初心，接下来打算写个用电报机器人管理的基于MQTT协议的IoT模块。
</p>
END;
}

function Echo20210320($strHead)
{
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年3月20日
<br />微信公众号发文章时出现<font color=red>剩余群发次数为0</font>的错误信息后，上网搜了一圈没找到解决方案。后来发现是最近写文章太积极，在已经发出文章的19日就开始写了20日的开头，等到20日要群发时，系统还没反应过来。
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
	$strKWEB = GetHoldingsLink('KWEB', true);
	$strQDII = GetNameLink('qdii');
	$strSZ164906 = GetStockLink('SZ164906');
	$strFundHistory = GetNameLink('fundhistory', FUND_HISTORY_DISPLAY);
	$strElementary = GetNameLink('elementary', '小学生');
	$strImage = ImgMrFox();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年6月24日
<br />虽然原则上来说XOP也可以使用这个页面，但是它其实是为同时有港股和美股的{$strKWEB}持仓准备的。
<br />{$strQDII}基金总是越跌规模越大，流动性越好，前些年是华宝油气，而今年最热门的变成了中丐互怜。按SZ162411对应XOP的模式，中概互联的小弟SZ164906之前是用KWEB估值的。
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
	$strSZ159605 = GetStockLink('SZ159605');
	$strSZ159607 = GetStockLink('SZ159607');
	$strHoldings = GetNameLink('holdings', HOLDINGS_DISPLAY);
	$strFundPosition = GetNameLink('fundposition', FUND_POSITION_DISPLAY);
	$strQdiiHk = GetNameLink('qdiihk', QDII_HK_DISPLAY);
	$strQDII = GetNameLink('qdii', QDII_DISPLAY);
	$strImage = ImgHuangRong();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年7月28日
<br />从QDII中分出来，采用跟踪成分股变化的方式对同时有美股和港股持仓的{$strSH513050}等进行净值估算。
<br />A股大妈最喜欢干的事情就是抄底。随着过去半年来中概互联一路跌成了中丐互怜，中概互联网ETF的市场规模和流动性都在暴涨，就连原来叫中国互联的SZ164906都蹭热度借增加扩位简称的机会改名成了中概互联网LOF。看得我口水流一地，忍不住想做点什么蹭蹭热点。
<br />跟SZ164906和KWEB跟踪同一个指数H11136不同，SH513050跟踪的是另外一个不同的中证海外中国互联网50指数H30533。H30533和H11136在成分股选择上基本一致，但是H30533对单一成分股最大仓位限制是30%，而H11136限制10%的最大仓位，这样导致它们俩在腾讯和阿里持仓比例上区别巨大。
在中间的是跟踪中证海外中国互联网30指数930604的{$strSZ159605}和{$strSZ159607}，限制15%的最大仓位。另外，顾名思义930604的成分股数量要少50-30=20只。
<br />SH513050的成分股和比例来自于上交所官网的ETF申购赎回清单，SZ159605和SZ159607来自深交所官网的ETF申购赎回清单，这样未来可以方便的继续扩大混合QDII的成员。SZ164906的成分股和比例依旧还是来自KWEB官网公布的每日{$strHoldings}更新。
<br />把SZ164906从老QDII挪到新的混合QDII其实是个相当痛苦的过程，原来以SZ162411为模板写的{$strFundPosition}等功能都要从QDII拓展出来，{$strQdiiHk}在这个过程中也跟着沾了光。
<br />官方估值跟原来{$strQDII}一样，不过混合QDII的参考估值有所不同。除了当日汇率的变化外，参考估值在港股开盘后还会反应当日港股成分股的变动对净值的影响。
$strImage
</p>
END;
}

function Echo20211129($strHead)
{
	$strImage = ImgGreatDynasty();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2021年11月29日
<br />今天很不高兴，写的中丐互怜LOF(164906)限购1000的文章竟然几小时后就被人举报删除了。死了张屠夫，不吃有毛猪，以后还是要努力坚持做自己的网站。
<br />其实早在因为举报连续被封了8个QQ群，附带被封了用了20年的QQ号之后，我就预感到了微信迟早也会被封。如今离开了QQ没有关系，没有微信的话可是刷不了绿码连门都出不了，只能彻底放弃腾讯家包括公众号在内的一切公开使用了。
$strImage
</p>
END;
}

function Echo20220914($strHead)
{
	$strEndWechat = GetNameLink('endwechat', '放弃微信');
	$strWoody1234 = GetXueQiuIdLink('2244868365', 'woody1234');
	$strChinaInternet = GetNameLink('chinainternet', '中丐互怜');
	$strSH513220 = GetStockLink('SH513220', true);
	$strSH513360 = GetStockLink('SH513360', true);
	$strImage = ImgRuLai();
	
	$strHead = GetHeadElement($strHead);
    echo <<<END
	$strHead
<p>2022年9月14日
<br />在美军从越南撤退的时候，美国政府估计其中有相当大比例的染上了毒瘾。按当时的普遍研究，吸毒者复发的可能性高达90%以上，如何面对预期中几十万退伍的瘾君子成了一个严峻的问题。然后让严阵以待的社会学家们完全没有想到的是，事实上复发的比例不到5%。
于是研究者们又挖空心思搞了一个新理论出来：只要远离了原来上瘾的环境，就不容易再次上瘾。
<br />在我刚开始混雪球和搞微信公众号的时候，对成为股票套利大V曾经是满怀希望的。这个希望破灭在QQ群和号被封后。我意识到套利者群体中其实不少人是满怀敌意的。而且即使不举报我，出于秘籍不能外传的心理，绝大多数套利者也不会愿意主动帮我分享，因此这条大V之路其实走不通。
<br />不幸的是，我发现我上瘾了，每天花了大量的时间搞无效的网络社交。于是开始有意的让自己远离上瘾环境。公众号在去年11月因为举报封了我一篇文章，我就不再更新文章，{$strEndWechat}上6000多的订阅者；雪球在今年2月删除了我一条宣传网站的评论，我就弃用了13000多粉丝的{$strWoody1234}帐号。从此彻底戒断大V梦想。
<br />戒断上瘾总会有副作用，对我来说，就是口头上喊着要努力专心做好自己的网站，实际上在很长时间内却再也提不起兴致，以至于经常放在嘴边自嘲的每天20行代码都断了很久。
<br />7月份的时候，我注意到{$strChinaInternet}来了个新成员{$strSH513220}，本来想简单的通过拷贝复制加上，却发现跟其它老丐帮成员不同，它居然还有A股成分股。一下子我的拖延症就犯了，一直拖到这个月才动手。
<br />既然加上了A股成分股的处理，那么把老的同样同时有美股、港股和A股成分股的{$strSH513360}加上也就成了简单的拷贝复制。剩下就看在没有网络宣传的情况下，搜索引擎们能多有效的帮助用户找到这些估值网页了。
$strImage
</p>
END;
}


?>
