<?php
require_once('php/_entertainment.php');

function GetMetaDescription()
{
	return '雪球再次让我搞个直播。这次不想讲油了，讲了跟踪纳斯达克100的SZ161130近期溢价申购套利回顾，这里是文字美化版本和视频回放。';
}

function EchoAll()
{
	$strXueqiu = GetExternalLink(GetXueqiuWoodyUrl().'144000143', '听无敌哥讲那油气交易爆仓和破产的事情');
	$strSZ162411 = GetBlogLink(20150818);
	$strSZ161130 = GetGroupStockLink('SZ161130', true);
	$strQqqFund = GetStockCategoryLink('qqqfund');
	$strImgQqq = ImgAutoQuote(PATH_BLOG_PHOTO.'20200915QQQ.jpg', '9月11日QQQ官网显示的前十大持仓');
	$strGoogle = GetBlogLink(20110509);
	$strImgMnq = ImgAutoQuote(PATH_BLOG_PHOTO.'20200915MNQ.jpg', '9月14日芝商所官网显示的MNQ行情');
	$strSH513100 = GetGroupStockLink('SH513100');
	$strSZ159941 = GetGroupStockLink('SZ159941');
	$strImgNdx = ImgAutoQuote(PATH_BLOG_PHOTO.'20200915NDX.jpg', '9月14日stockchars.com显示的NDX技术分析图');
	$strAccount161129 = GetFundAccountLink('SZ161129', 235530);
	$strSZ161129 = GetGroupStockLink('SZ161129', true);
	$strAccount161130 = GetFundAccountLink('SZ161130', 59882);
	$strFundPosition = GetFundPositionLink('SZ161130');
	$strVideo = VideoSZ161130();

	EchoBlogDate();
    echo <<<END
<br />跟上次{$strXueqiu}一样，雪球运营人员总是在我的{$strSZ162411}和XOP亏得不能自理的时候让我做直播。不过常年卖惨这种人设只有元卫南才能乐此不疲的坚持下来，于是建议聊聊最近自己袖手旁观没有参与的{$strSZ161130}溢价申购套利。
9月11日直播的视频在最下面。讲得不好，准备的纳斯达克内容二十分钟就讲完了，后来基本上又回到了油气的东拉西扯上。本文是增强的文字版本，同时更新了最新的数据。
<br />美股市场指数代码总是五花八门。雪球上{$strQqqFund}显示的代码是.NDX，而YAHOO上的代码是^NDX。通常大家都觉得它代表美股科技股，其实更确切的分类说法是除金融公司外的一百家最大公司按市值加权的指数。跟踪它的ETF很多，最热门的有QQQ一倍做多、PSQ一倍做空、TQQQ三倍做多和SQQQ三倍做空等。
$strImgQqq
<br />这个指数群众基础非常好，可以从QQQ官网上9月11日前十大持仓比例看出，全部都是人民群众喜闻乐见的高科技公司。其中GOOGL和GOOG其实都是{$strGoogle}，二者加起来3.64+3.56=7.2%，在苹果、亚马逊和微软之后排第四。今年以来股价暴涨了好几倍的特斯拉目前排在第六，超过了上一个因为人工智能暴涨的NVDA。
$strImgMnq
<br />芝商所对应的期货有NQ和MNQ等。NQ货值是MNQ的十倍。说起来MNQ也是芝商所今年跟负油价一起搞出来的创新，这样能有更多散户参与股指期货的交易。一手MNQ按当前一万多点的指数乘以2美元计算，目前货值2万多美元，20倍左右的杠杆。
<br />A股市场上跟踪的基金也不少。除了不能套利的160213等场外基金，场内的{$strSH513100}长期关门，{$strSZ159941}每次一百万份起步每天限购一百万份，也就是每天一个幸运儿，这样每天每账户限购五百人民币的SZ161130成了套利党的香馍馍。
$strImgNdx
<br />NDX八月份进入连续创历史新高的模式，除了在8月10日那周回调了一次二十日SMA，也就是布林中轨，其它时间一直在沿布林上轨上涨不停新高。目前这一轮回调到了号称是美股小牛熊分界线五十日EMA，有可能会继续跌到布林下轨附近。
<br />SZ161130对上涨一开始是犹豫的，8月21日之前都是折价。8月24日开始，追高的来了，把它拉到了溢价，然后溢价一路上涨，9月3日最高值为7.99%。
不排除有易方达基金公司为了省广告费有意推波助澜的可能性，迄今为止我记录的最大溢价申购套利规模就是它导演的。今年3月24日有{$strAccount161129}户参与了{$strSZ161129}限额五百块的申购，对应接近六万人参与，当时场内交易溢价67%。
<br />有溢价的地方就有套利党。9月3日测算是{$strAccount161130}户，对应差不多一万自然人。测算场外申购了419户，就是说这一万人当中有大约四百人同时还做了场外申购，然后马上转场内了。不转场内的价值投资者是用场内新增数据测算不出来的。要不是近日来纳指大跌，9月8日场内就砸折价了，实际溢价1.63%。
<br />本来各个基金公司的QDII额度在今年3月份就被原油QDII基金狠狠坑了一把，现在更不够了，{$strFundPosition}的实际值下降到了90%左右。主动降仓位最低的在华宝油气上见过80%。
<br />对冲还是不对冲？不要怂就是干有它的道理。对于想做多的来说，只要有溢价就应该申购，上涨赚净值下跌赚溢价。从概率上来说长期肯定是赚钱的，不过要尽可能多的操作，概率是通过大数据回归的。
<br />亏钱的都不是价值投资，失败的套利都是赌博。A股市场钱多人傻，但是收割工具并不多，跨市场套利是真正的圣杯。一股QQQ相当于大约1100股SZ161130，一个拖拉机三千块对应1.5股QQQ，不容易精确对冲。MNQ可以实时对冲，一手MNQ的货值大约相当于8万股SZ161130，等SZ161130流动性好了后大有可为。    
$strVideo
</p>
END;
}

require('../../../php/ui/_dispcn.php');
?>
