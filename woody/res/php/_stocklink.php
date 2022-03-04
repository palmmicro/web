<?php

function GetUpdateStockHistoryLink($strSymbol, $strDisplay = false)
{
	return GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?symbol='.$strSymbol, "确认更新{$strSymbol}历史记录?", ($strDisplay ? $strDisplay : $strSymbol));
}

function _GetAdjustLink($strSymbol, $strQuery)
{
    return GetStockPhpLink('editstockgroup', '校准', 'adjust=1&'.$strQuery).' '.$strSymbol;
}

function _GetEtfAdjustString($ref, $etf_ref)
{
	$strSymbol = $ref->GetSymbol();
    $strQuery = sprintf('Date=%s&%s=%s&%s=%s', $ref->GetDate(), $strSymbol, $ref->GetPrice(), $etf_ref->GetSymbol(), $etf_ref->GetPrice());
    return _GetAdjustLink($strSymbol, $strQuery);
}

define('OIL_GROUP_DISPLAY', '原油');
define('COMMODITY_GROUP_DISPLAY', '大宗商品和金银');
define('CHINAINTERNET_GROUP_DISPLAY', '中丐互怜');
define('QQQ_GROUP_DISPLAY', '纳斯达克100');
define('SPY_GROUP_DISPLAY', '标普500');
define('HANGSENG_GROUP_DISPLAY', '恒生指数');
define('HSTECH_GROUP_DISPLAY', '恒生科技指数');
define('HSHARES_GROUP_DISPLAY', 'H股中国企业指数');

function GetStockCategoryArray()
{
    return array('oilfund' => OIL_GROUP_DISPLAY,
                   'commodity' => COMMODITY_GROUP_DISPLAY,
                   'chinainternet' => CHINAINTERNET_GROUP_DISPLAY,
                   'qqqfund' => QQQ_GROUP_DISPLAY,
                   'spyfund' => SPY_GROUP_DISPLAY,
                   'hangseng' => HANGSENG_GROUP_DISPLAY,
                   'hshares' => HSHARES_GROUP_DISPLAY,
                   'hstech' => HSTECH_GROUP_DISPLAY,
                   );
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
    case ADR_PAGE:
        $ar = AdrGetSymbolArray();
        break;
        
    case ADRH_COMPARE_PAGE:
        $ar = SqlGetAdrhArray();
        break;
  
    case AH_COMPARE_PAGE:
   		$pair_sql = new AhPairSql();
        $ar = $pair_sql->GetSymbolArray();
        break;
  
    case CHINA_INDEX_PAGE:
    	$ar = ChinaIndexGetSymbolArray();
        break;
        
    case 'chinainternet':
//        $ar = array('SH513050', 'SZ159605', 'SZ159607', 'SZ164906');
        $ar = array('SH513050', 'SZ164906');
        break;
        
    case 'commodity':
        $ar = array_merge(QdiiGetCommoditySymbolArray()
        				   , QdiiGetGoldSymbolArray()
    					   , GoldSilverGetSymbolArray()
    					   , array('ACH'));
        break;
        
    case ETF_LIST_PAGE:
        $ar = SqlGetEtfPairArray();
        break;
  
    case GOLD_SILVER_PAGE:
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
        
    case QDII_HK_PAGE:
        $ar = QdiiHkGetSymbolArray();
        break;
        
    case 'qdiimix':
        $ar = QdiiMixGetSymbolArray();
        break;
        
    case 'oilfund':
    	$ar = array_merge(QdiiGetOilEtfSymbolArray()
    					   , QdiiGetOilSymbolArray()
    					   , array('PTR', 'SHI', 'SNP'));
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

function GetBoShiFundUrl()
{
	return 'http://www.bosera.com';
}

function GetBoShiOfficialLink($strDigitA)
{
    return GetOfficialLink(GetBoShiFundUrl().'/fund/'.$strDigitA.'.html', $strDigitA);
}

function GetBoShiSoftwareLinks()
{
    $ar = array('SH513500', 'SZ159742', 'SZ159937');
    $strLink = GetExternalLink(GetBoShiFundUrl(), '博时基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetDaChengFundUrl()
{
	return 'http://www.dcfund.com.cn';
}

// http://www.dcfund.com.cn/dcjj/159740/index.jhtml
function GetDaChengOfficialLink($strDigitA)
{
    return GetOfficialLink(GetDaChengFundUrl().'/dcjj/'.$strDigitA.'/index.jhtml', $strDigitA);
}

function GetDaChengSoftwareLinks()
{
    $ar = array('SZ159740', 'SZ160924');
    $strLink = GetExternalLink(GetDaChengFundUrl(), '大成基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetEFundUrl()
{
	return 'http://www.efunds.com.cn';
}

function GetEFundOfficialLink($strDigitA)
{
    return GetOfficialLink(GetEFundUrl().'/html/fund/'.$strDigitA.'_fundinfo.htm', $strDigitA);
}

function GetEFundSoftwareLinks($strDigitA = false)
{
    $ar = array('SH510900', 'SH513010', 'SH513050', 'SZ159934', 'SZ161116', 'SZ161125', 'SZ161126', 'SZ161127', 'SZ161128', 'SZ161129', 'SZ161130');
    $strLink = GetExternalLink(GetEFundUrl(), '易方达基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetGuangFaSoftwareLinks($strDigitA)
{
    $ar = array('SZ159941', 'SZ162719');
	$strUrl = 'http://www.gffunds.com.cn';
    return ' '.GetOfficialLink($strUrl.'/funds/?fundcode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '广发基金'));
}

function GetGuoTaiSoftwareLinks()
{
    $ar = array('SH513100', 'SH518800', 'SZ160216');
    $strLink = GetExternalLink(GetGuoTaiFundUrl(), '国泰基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaAnFundUrl()
{
	return 'http://www.huaan.com.cn';
}

function GetHuaAnOfficialLink($strDigitA)
{
    return GetOfficialLink(GetHuaAnFundUrl().'/funds/'.$strDigitA.'/index.shtml', $strDigitA);
}

function GetHuaAnSoftwareLinks()
{
    $ar = array('SH513030', 'SH513580', 'SH518880', 'SZ160416');
    $strLink = GetExternalLink(GetHuaAnFundUrl(), '华安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaBaoSoftwareLinks($strDigitA)
{
    $ar = array('SZ162411', 'SZ162415');
	$strUrl = 'http://www.fsfund.com';
    return ' '.GetOfficialLink($strUrl.'/funds/'.$strDigitA.'/index.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '华宝基金'));
}

function GetHuaTaiFundUrl()
{
	return 'http://www.huatai-pb.com';
}

function GetHuaTaiOfficialLink($strDigitA)
{
    return GetOfficialLink(GetHuaTaiFundUrl().'/products/zhishu/'.$strDigitA.'/summary/index.html', $strDigitA);
}

function GetHuaTaiSoftwareLinks()
{
    $ar = array('SH510300', 'SH513130');
    $strLink = GetExternalLink(GetHuaTaiFundUrl(), '华泰柏瑞');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaXiaFundUrl()
{
	return 'http://www.chinaamc.com/';
}

function GetHuaXiaOfficialLink($strDigitA)
{
    return GetOfficialLink(GetHuaXiaFundUrl().'fund/'.$strDigitA.'/index.shtml', $strDigitA);
}

function GetHuaXiaSoftwareLinks()
{
    $ar = array('SH510330', 'SH513180', 'SH513300', 'SH513660', 'SZ159850', 'SZ159920');
    $strLink = GetExternalLink(GetHuaXiaFundUrl(), '华夏基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetIcbcCsSoftwareLinks()
{
    $ar = array('SZ164824');
    $strLink = GetExternalLink('http://www.icbccs.com.cn', '工银瑞信');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetJianXinFundUrl()
{
	return 'http://www.ccbfund.cn';
}

// http://www.ccbfund.cn/fund_info/info.jspx?fundCode=513680
function GetJianXinOfficialLink($strDigitA)
{
    return GetOfficialLink(GetJianXinFundUrl().'/fund_info/info.jspx?fundCode='.$strDigitA, $strDigitA);
}

function GetJianXinSoftwareLinks()
{
    $ar = array('SH513680');
    $strLink = GetExternalLink(GetJianXinFundUrl(), '建信基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetJiaoYinSchroderSoftwareLinks($strDigitA)
{
    $ar = array('SZ164906');
	$strUrl = 'https://www.fund001.com';
    return ' '.GetOfficialLink($strUrl.'/fund/'.$strDigitA.'/index.shtml', $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '交银施罗德基金'));
}

function GetJiaShiFundUrl()
{
	return 'http://www.jsfund.cn';
}

// http://www.jsfund.cn/main/fund/159823/fundManager.shtml
function GetJiaShiOfficialLink($strDigitA)
{
    return GetOfficialLink(GetJiaShiFundUrl().'/main/fund/'.$strDigitA.'/fundManager.shtml', $strDigitA);
}

function GetJiaShiSoftwareLinks()
{
    $ar = array('SZ159741', 'SZ159823', 'SZ159919', 'SZ160717', 'SZ160719', 'SZ160723');
    $strLink = GetExternalLink(GetJiaShiFundUrl(), '嘉实基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetNanFangFundUrl()
{
	return 'http://www.nffund.com/';
}

function GetNanFangOfficialLink($strDigitA)
{
    return GetOfficialLink(GetNanFangFundUrl().'main/jjcp/fundproduct/'.$strDigitA.'.shtml', $strDigitA);
}

function GetNanFangSoftwareLinks()
{
    $ar = array('SH501018', 'SH501302', 'SH513600', 'SZ159954', 'SZ160140');
    $strLink = GetExternalLink(GetNanFangFundUrl(), '南方基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

// https://www.lionfund.com.cn/official/funds/main?fundCode=163208
function GetNuoAnSoftwareLinks($strDigitA)
{
    $ar = array('SZ163208');
	$strUrl = 'https://www.lionfund.com.cn';
    return ' '.GetOfficialLink($strUrl.'/official/funds/main?fundCode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '诺安基金'));
}

function GetPenghuaSoftwareLinks()
{
    $ar = array('SH501025');
    $strLink = GetExternalLink(GetPenghuaFundUrl(), '鹏华基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetPingAnFundUrl()
{
	return 'http://www.fund.pingan.com';
}

// http://www.fund.pingan.com/main/peanutFinance/yingPeanut/fundDetailV2/159960.shtml
function GetPingAnOfficialLink($strDigitA)
{
    return GetOfficialLink(GetPingAnFundUrl().'/main/peanutFinance/yingPeanut/fundDetailV2/'.$strDigitA.'.shtml', $strDigitA);
}

function GetPingAnSoftwareLinks()
{
    $ar = array('SZ159960');
    $strLink = GetExternalLink(GetPingAnFundUrl(), '平安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetUbsSdicSoftwareLinks()
{
    $ar = array('SZ161226');
    $strLink = GetExternalLink('http://www.ubssdic.com', '国投瑞银');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetUniversalFundUrl()
{
	return 'http://www.99fund.com';
}

// http://www.99fund.com/main/products/pofund/164705/fundgk.shtml
function GetUniversalOfficialLink($strDigitA)
{
    return GetOfficialLink(GetUniversalFundUrl().'/main/products/pofund/'.$strDigitA.'/fundgk.shtml', $strDigitA);
}

function GetUniversalSoftwareLinks()
{
    $ar = array('SH501043', 'SZ164701', 'SZ164705');
    $strLink = GetExternalLink(GetUniversalFundUrl(), '汇添富基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetXinChengSoftwareLinks($strDigitA)
{
    $ar = array('SZ165510', 'SZ165513');
	$strUrl = 'http://www.citicprufunds.com.cn';
    return ' '.GetOfficialLink($strUrl.'/pc/productDetail?fundcode='.$strDigitA, $strDigitA).GetCategorySoftwareLinks($ar, GetExternalLink($strUrl, '信诚基金'));
}

function GetYinHuaSoftwareLinks()
{
    $ar = array('SZ161815', 'SZ161831');
    $strLink = GetExternalLink(GetYinHuaFundUrl(), '银华基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}
/*
大卫把移民话题带这么火，我来跟风讲个凡尔赛的故事吧。
前2年网上讨论“清华父母的子女上清华的概率多大”火热的时候，我有个大学同学在同学群里说，他马上中学毕业的儿子就不上清华，而是去UC伯克利读CS。后来又过了一段时间，听说他儿子最终自己选择去了布朗大学。没选择伯克利的原因，是因为布朗大学的白人女同学比较多。
再往前，大约10年前吧，我失业无所事事的时候，有一次被一个美籍台湾老板叫去拉斯维加斯CES免费帮忙看展台，期间跟他的几个员工同吃同住来往密切，很快从政治历史聊到了私人话题。他的一个老员工有一天喝得有点多，跟我说发愁他博士毕业的女儿找不到女婿。我问他原因，他说你看我们老板两个儿子，娶的都是白人女，美国的华人女想找般配的华人男性太难了。
一言惊醒梦中人，我想到从前打工的Palmmicro美籍台湾老板的独生儿子，同样娶的是白人女。在美国成功的二代华人男性都努力娶白人女的背后，隐藏了多少童年的憋屈啊！
2014年的6月，当我家娃在娃妈肚子里的时候，我买了1周往返美国的机票试图去延续一下我的绿卡，在入境的时候被逮了个正着。美国入境官员给了我2个选择，要么留下来呆满6个月，要么当场放弃绿卡。我平时一贯是鄙视中医的，但是智者千虑必有一失，因为娃在娃妈肚子里这几个月已经让娃妈脸上多了很多斑，有人跟我说这是娃的雄性激素在起作用，我居然信了。
想到我的儿子要被迫在美国出生长大，跟其它华人小男生一样度过暗无天日的童年，我毅然选择了放弃。
5个月过后，娃出生了，我才发现自己错得多离谱！
*/
?>
