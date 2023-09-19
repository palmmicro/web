<?php

function GetUpdateStockHistoryLink($sym, $strDisplay = false)
{
	$strSymbol = $sym->GetSymbol();
	return GetOnClickLink(STOCK_PATH.'submithistory.php?symbol='.$strSymbol, "确认更新{$strSymbol}历史记录?", ($strDisplay ? $strDisplay : $strSymbol));
}

function _getCategoryLink($strCategory)
{
    $ar = GetStockCategoryArray();
    return GetStockPhpLink($strCategory, $ar[$strCategory]);
}

function GetCategoryArray($strPage)
{
    $ar = array();
    switch ($strPage)
    {
    case 'abcompare':
   		$pair_sql = new AbPairSql();
        $ar = $pair_sql->GetSymbolArray();
        break;
  
    case 'adrhcompare':
   		$pair_sql = new AdrPairSql();
        $ar = $pair_sql->GetSymbolArray();
        break;
  
    case 'ahcompare':
   		$pair_sql = new AhPairSql();
        $ar = $pair_sql->GetSymbolArray();
        break;
  
    case 'chinaindex':
    	$ar = ChinaIndexGetSymbolArray();
        break;
        
    case 'chinainternet':
        $ar = array('SH513050', 'SH513220', 'SZ159605', 'SZ159607', 'SZ164906');
        break;
        
    case 'commodity':
        $ar = array_merge(QdiiGetCommoditySymbolArray(), QdiiGetGoldSymbolArray(), GoldSilverGetSymbolArray());
        break;
        
    case 'fundlist':
   		$pair_sql = new FundPairSql();
        $ar = $pair_sql->GetSymbolArray();
        break;
  
    case 'goldsilver':
    	$ar = GoldSilverGetSymbolArray();
        break;
        
    case 'hangseng':
    	$ar = QdiiHkGetHangSengSymbolArray();
        break;
        
    case 'hshares':
    	$ar = QdiiHkGetHSharesSymbolArray();
        break;
        
    case 'hstech':
    	$ar = QdiiHkGetTechSymbolArray();
        break;
        
    case 'qdii':
        $ar = QdiiGetSymbolArray();
        break;
        
    case 'qdiihk':
        $ar = QdiiHkGetSymbolArray();
        break;
        
    case 'qdiimix':
        $ar = QdiiMixGetSymbolArray();
        break;
        
    case 'qdiijp':
        $ar = QdiiJpGetSymbolArray();
        break;
        
    case 'qdiieu':
        $ar = QdiiEuGetSymbolArray();
        break;
        
    case 'oilfund':
    	$ar = array_merge(QdiiGetOilEtfSymbolArray(), QdiiGetOilSymbolArray());
        break;
        
    case 'qqqfund':
        $ar = QdiiGetQqqSymbolArray(); 
        break;

    case 'spyfund':
    	$ar = QdiiGetSpySymbolArray();
        break;
    }
    return $ar;
}

function GetCategorySoftwareLinks($arTitle, $strCategory)
{
    $str = '<br />'.$strCategory.' - ';
    foreach ($arTitle as $strPage)
    {
    	$str .= GetStockPageLink(strtolower($strPage), StockGetSymbol($strPage)).' ';
    }
    return $str;
}

function _getCategorySoftwareLinks($strCategory)
{
    $ar = GetCategoryArray($strCategory);
    $strLink = _getCategoryLink($strCategory);
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetOilSoftwareLinks()
{
    return _getCategorySoftwareLinks('oilfund');
}

function GetCommoditySoftwareLinks()
{
    return _getCategorySoftwareLinks('commodity');
}

function GetQqqSoftwareLinks()
{
    return _getCategorySoftwareLinks('qqqfund');
}

function GetSpySoftwareLinks()
{
    return _getCategorySoftwareLinks('spyfund');
}

function GetHangSengSoftwareLinks()
{
    return _getCategorySoftwareLinks('hangseng');
}

function GetHSharesSoftwareLinks()
{
    return _getCategorySoftwareLinks('hshares');
}

function GetHsTechSoftwareLinks()
{
    return _getCategorySoftwareLinks('hstech');
}

function GetASharesSoftwareLinks()
{
   	$ar = ChinaIndexGetSymbolArray();
    $str = GetCategorySoftwareLinks($ar, 'A股');
    return $str;
}

function GetChinaInternetSoftwareLinks()
{
    return _getCategorySoftwareLinks('chinainternet');
}

function GetBoShiSoftwareLinks($strDigitA)
{
    $ar = array('SH513360', 'SH513500', 'SH513390', 'SZ159742', 'SZ159937');
	$strUrl = 'http://www.bosera.com';
    return ' '.GetOfficialLink($strUrl.'/fund/'.$strDigitA.'.html', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '博时基金'));
}

// http://www.cmfchina.com/main/513220/fundinfo.shtml
function GetCmfSoftwareLinks($strDigitA)
{
    $ar = array('SH513220', 'SZ159659');
	$strUrl = 'http://www.cmfchina.com';
    return ' '.GetOfficialLink($strUrl.'/main/'.$strDigitA.'/fundinfo.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '招商基金'));
}

// http://www.dcfund.com.cn/dcjj/159740/index.jhtml
function GetDaChengSoftwareLinks($strDigitA)
{
    $ar = array('SZ159513', 'SZ159740', 'SZ160924');
	$strUrl = 'http://www.dcfund.com.cn';
    return ' '.GetOfficialLink($strUrl.'/dcjj/'.$strDigitA.'/index.jhtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '大成基金'));
}

// https://www.efunds.com.cn/fund/510900.shtml
function GetEFundSoftwareLinks($strDigitA)
{
    $ar = array('SH510310', 'SH510900', 'SH513000', 'SH513010', 'SH513050', 'SZ159696', 'SZ159934', 'SZ161116', 'SZ161125', 'SZ161126', 'SZ161127', 'SZ161128', 'SZ161129', 'SZ161130');
	$strUrl = 'https://www.efunds.com.cn';
    return ' '.GetOfficialLink($strUrl.'/fund/'.$strDigitA.'.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '易方达基金'));
}

function GetGuangFaSoftwareLinks($strDigitA)
{
    $ar = array('SH513380', 'SZ159605', 'SZ159941', 'SZ162719');
	$strUrl = 'http://www.gffunds.com.cn';
    return ' '.GetOfficialLink($strUrl.'/funds/?fundcode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '广发基金'));
}

function GetGuoTaiSoftwareLinks($strDigitA)
{
    $ar = array('SH513100', 'SH518800', 'SZ159612', 'SZ160216');
	$strUrl = 'https://e.gtfund.com';
    return ' '.GetOfficialLink($strUrl.'/Etrade/Jijin/view/id/'.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '国泰基金'));
}

function GetHuaAnSoftwareLinks($strDigitA)
{
    $ar = array('SH513030', 'SH513080', 'SH513580', 'SH513880', 'SH518880', 'SZ159632', 'SZ160416');
	$strUrl = 'http://www.huaan.com.cn';
    return ' '.GetOfficialLink($strUrl.'/funds/'.$strDigitA.'/index.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '华安基金'));
}

function GetHuaBaoSoftwareLinks($strDigitA)
{
    $ar = array('SH501312', 'SZ162411', 'SZ162415');
	$strUrl = 'http://www.fsfund.com';
    return ' '.GetOfficialLink($strUrl.'/funds/'.$strDigitA.'/index.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '华宝基金'));
}

function GetHuaTaiSoftwareLinks($strDigitA)
{
    $ar = array('SH510300', 'SH513110', 'SH513130');
	$strUrl = 'http://www.huatai-pb.com';
    return ' '.GetOfficialLink($strUrl.'/products/zhishu/'.$strDigitA.'/summary/index.html', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '华泰柏瑞'));
}

function GetHuaXiaSoftwareLinks($strDigitA)
{
    $ar = array('SH510330', 'SH513180', 'SH513300', 'SH513520', 'SH513660', 'SZ159655', 'SZ159850', 'SZ159920');
	$strUrl = 'http://www.chinaamc.com';
    return ' '.GetOfficialLink($strUrl.'/fund/'.$strDigitA.'/index.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '华夏基金'));
}

// https://www.icbccs.com.cn/gyrx/jjcp/etf/gyrjETF/index.html
// https://www.icbccs.com.cn/gyrx/jjcp/qdi/gyydjjrmbfof/index.html
function GetIcbcCsSoftwareLinks($strDigitA)
{
    $ar = array('SZ159866', 'SZ164824');
	$strUrl = 'https://www.icbccs.com.cn';
	switch ($strDigitA)
	{
	case '159866':
		$str = '/gyrx/jjcp/etf/gyrjETF/index.html';
		break;
		
	case '164824':
		$str = '/gyrx/jjcp/qdi/gyydjjrmbfof/index.html';
		break;
	}
    return ' '.GetOfficialLink($strUrl.$str, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '工银瑞信'));
}
/*
function GetJianXinSoftwareLinks($strDigitA)
{
    $ar = array('');
	$strUrl = 'http://www.ccbfund.cn';
    return ' '.GetOfficialLink($strUrl.'/fund_info/info.jspx?fundCode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '建信基金'));
}
*/
function GetJiaoYinSchroderSoftwareLinks($strDigitA)
{
    $ar = array('SZ164906');
	$strUrl = 'https://www.fund001.com';
    return ' '.GetOfficialLink($strUrl.'/fund/'.$strDigitA.'/index.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '交银施罗德基金'));
}

// http://www.jsfund.cn/main/fund/159823/fundManager.shtml
function GetJiaShiSoftwareLinks($strDigitA)
{
    $ar = array('SZ159501', 'SZ159607', 'SZ159741', 'SZ159823', 'SZ159919', 'SZ160717', 'SZ160719', 'SZ160723');
	$strUrl = 'http://www.jsfund.cn';
    return ' '.GetOfficialLink($strUrl.'/main/fund/'.$strDigitA.'/fundManager.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '嘉实基金'));
}

// http://www.igwfmc.com/main/jjcp/product/501225/detail.html
function GetJingShunSoftwareLinks($strDigitA)
{
    $ar = array('SH501225', 'SZ159509');
	$strUrl = 'http://www.igwfmc.com';
    return ' '.GetOfficialLink($strUrl.'/main/jjcp/product/'.$strDigitA.'/detail.html', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '景顺长城基金'));
}

function GetNanFangSoftwareLinks($strDigitA)
{
    $ar = array('SH501018', 'SH501302', 'SH513600', 'SH513650', 'SZ159954', 'SZ160140');
	$strUrl = 'http://www.nffund.com';
    return ' '.GetOfficialLink($strUrl.'/main/jjcp/fundproduct/'.$strDigitA.'.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '南方基金'));
}

// https://www.lionfund.com.cn/official/funds/main?fundCode=163208
function GetNuoAnSoftwareLinks($strDigitA)
{
    $ar = array('SZ163208');
	$strUrl = 'https://www.lionfund.com.cn';
    return ' '.GetOfficialLink($strUrl.'/official/funds/main?fundCode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '诺安基金'));
}

function GetPenghuaSoftwareLinks($strDigitA)
{
    $ar = array('SH501025');
	$strUrl = 'https://www.phfund.com.cn';
    return ' '.GetOfficialLink($strUrl.'/web/FUND_'.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '鹏华基金'));
}

// http://www.fund.pingan.com/main/peanutFinance/yingPeanut/fundDetailV2/159960.shtml
function GetPingAnSoftwareLinks($strDigitA)
{
    $ar = array('SZ159960');
	$strUrl = 'http://www.fund.pingan.com';
    return ' '.GetOfficialLink($strUrl.'/main/peanutFinance/yingPeanut/fundDetailV2/'.$strDigitA.'.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '平安基金'));
}

// http://www.ubssdic.com/main/jjcp/cpxq/161226.shtml
function GetUbsSdicSoftwareLinks($strDigitA)
{
    $ar = array('SZ161226');
	$strUrl = 'http://www.ubssdic.com';
    return ' '.GetOfficialLink($strUrl.'/main/jjcp/cpxq/'.$strDigitA.'.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '国投瑞银'));
}

// http://www.99fund.com/main/products/pofund/164705/fundgk.shtml
function GetUniversalSoftwareLinks($strDigitA)
{
    $ar = array('SH501043', 'SH513260', 'SH513290', 'SZ159660', 'SZ164701', 'SZ164705');
	$strUrl = 'http://www.99fund.com';
    return ' '.GetOfficialLink($strUrl.'/main/products/pofund/'.$strDigitA.'/fundgk.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '汇添富基金'));
}

function GetXinChengSoftwareLinks($strDigitA)
{
    $ar = array('SZ165513');
	$strUrl = 'http://www.citicprufunds.com.cn';
    return ' '.GetOfficialLink($strUrl.'/pc/productDetail?fundcode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '信诚基金'));
}

function GetYinHuaSoftwareLinks($strDigitA)
{
    $ar = array('SZ161815', 'SZ161831');
	$strUrl = 'http://www.yhfund.com.cn';
    return ' '.GetOfficialLink($strUrl.'/main/qxjj/'.$strDigitA.'/fndFacts.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '银华基金'));
}
/*
大卫把移民话题带这么火，我来跟风讲个凡尔赛的故事吧。
前2年网上讨论“清华父母的子女上清华的概率多大”火热的时候，我有个大学同学在同学群里说，他马上中学毕业的儿子就不上清华，而是去UC伯克利读CS。后来又过了一段时间，听说他儿子最终自己选择去了布朗大学。没选择伯克利的原因，是因为布朗大学的白人女同学比较多。
再往前，大约10年前吧，我失业无所事事的时候，有一次被一个美籍台湾老板叫去拉斯维加斯CES免费帮忙看展台，期间跟他的几个员工同吃同住来往密切，很快从政治历史聊到了私人话题。他的一个老员工有一天喝得有点多，跟我说发愁他博士毕业的女儿找不到女婿。我问他原因，他说你看我们老板两个儿子，娶的都是白人女，美国的华人女想找般配的华人男性太难了。
一言惊醒梦中人，我想到从前打工的Palmmicro美籍台湾老板的独生儿子，同样娶的是白人女。在美国成功的二代华人男性都努力娶白人女的背后，隐藏了多少童年的憋屈啊！
2014年的6月，当我家娃在娃妈肚子里的时候，我买了1周往返美国的机票试图去延续一下我的绿卡，在入境的时候被逮了个正着。美国入境官员给了我2个选择，要么留下来呆满6个月，要么当场放弃绿卡。我平时一贯是鄙视中医的，但是智者千虑必有一失，因为娃在娃妈肚子里这几个月已经让娃妈脸上多了很多斑，有人跟我说这是娃的雄性激素在起作用，我居然信了。
想到我的儿子要被迫在美国出生长大，跟其它华人小男生一样度过暗无天日的童年，我毅然选择了放弃。
5个月过后，娃出生了，我才发现自己错得多离谱！

1997年跟研究生导师在美国硅谷ESS公司合作H.324视频电话项目期间，认识了当时开了2家纳斯达克上市公司并且把第3家公司卖给了上市公司ESS的王继行博士。1999年毕业后加入王博士开的第4家公司：Palm Microsystems Inc。
由于跟知名的Palm公司名字类似带来的不便，公司在2002年改名为Centrality Communications, 后在2007年被上市公司SiRF收购。
在此期间经历：
1. 嵌入式软件工程师，参与PA1688芯片设计过程中的软件验证、底层驱动程序开发、运行在PA1688上的精简TCPIP协议栈以及H.323和SIP通信协议开发等工作。
2. 项目经理，负责跟清华大学国家重点语音实验室合作在PA1688的DSP上完成G.723.1和G.729等标准语音压缩算法的软件实现。
3. 产品总监，负责基于PA1688芯片的网络电话和单口网关等VoIP总体解决方案的研发和市场推广。此方案曾经是中国低端VoIP市场的领跑者，用户包括华为3COM等知名公司。

我以前加过一个低风险投资群，当我发现群里大多数人都把卖PUT当成低风险投资后就退了。
以前我也搞过自己的群，群里就有来自那个地方风险群的惊艳大师。
大师以套利著称，而且连续几年下来都是谨小慎微严格对冲的。
大师唯一的软肋，就是也把卖PUT当成了低风险投资。
2020年5月的美油期货CL，他在油价25美元的时候双卖了18美元的PUT和32美元的CALL, 如意算盘是当月跌到18以上或者涨到32以下都能躺赚。
大家现在都知道，那期CL就是著名的负油价。很快就跌破了18，让大师亏钱平仓了。
大师赌上了瘾，继续卖了1000手5月合约10美元的PUT。每手是1000桶，这笔PUT货值1个亿的美元。
随着油价跌破10美元，大师被强平。
大师输红了眼，继续又卖了1000手6月合约10美元的PUT。几天后6月合约再次跌破10美元，最低到了6美元，大师多年赚的美元全部灰飞烟灭。
老房子着火最可怕

*/
?>
