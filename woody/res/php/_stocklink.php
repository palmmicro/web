<?php

function _GetAdjustLink($strSymbol, $strQuery)
{
    return GetPhpLink(STOCK_PATH.'editstockgroup', 'adjust=1&'.$strQuery, '校准').' '.$strSymbol;
}

function _GetEtfAdjustString($ref, $etf_ref)
{
	$strSymbol = $ref->GetSymbol();
    $strQuery = sprintf('Date=%s&%s=%s&%s=%s', $ref->GetDate(), $strSymbol, $ref->GetPrice(), $etf_ref->GetSymbol(), $etf_ref->GetPrice());
    return _GetAdjustLink($strSymbol, $strQuery);
}

define('OIL_GROUP_DISPLAY', '油气');
define('COMMODITY_GROUP_DISPLAY', '大宗商品和金银');
define('CHINAINTERNET_GROUP_DISPLAY', '海外中国互联网');
define('QQQ_GROUP_DISPLAY', '纳斯达克100');
define('SPY_GROUP_DISPLAY', '标普500');
define('HANGSENG_GROUP_DISPLAY', '恒生指数');
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
                   );
}

function _getCategoryLink($strCategory)
{
    $ar = GetStockCategoryArray();
    return GetPhpLink(STOCK_PATH.$strCategory, false, $ar[$strCategory]);
}

function GetCategoryArray($strTitle)
{
    $ar = array();
    switch ($strTitle)
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
        $ar = QdiiGetChinaInternetSymbolArray();
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
        
    case QDII_PAGE:
        $ar = QdiiGetSymbolArray();
        break;
        
    case QDII_HK_PAGE:
        $ar = QdiiHkGetSymbolArray();
        break;
        
    case QDII_MIX_PAGE:
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

function GetBoShiSoftwareLinks()
{
    $ar = array('SH513500', 'SZ159937');
    $strLink = GetExternalLink(GetBoShiFundUrl(), '博时基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetJiaoYinSchroderSoftwareLinks()
{
    $ar = array('SZ164906');
    $strLink = GetExternalLink(GetJiaoYinSchroderFundUrl(), '交银施罗德基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetXinChengSoftwareLinks()
{
    $ar = array('SZ165510', 'SZ165513');
    $strLink = GetExternalLink(GetXinChengFundUrl(), '信诚基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetDaChengSoftwareLinks()
{
    $ar = array('SZ160924');
    $strLink = GetExternalLink('http://www.dcfund.com.cn', '大成基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetEFundSoftwareLinks()
{
    $ar = array('SH510900', 'SH513050', 'SZ159934', 'SZ161116', 'SZ161125', 'SZ161126', 'SZ161127', 'SZ161128', 'SZ161129', 'SZ161130');
    $strLink = GetExternalLink(GetEFundUrl(), '易方达基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaBaoSoftwareLinks()
{
    $ar = array('SZ162411', 'SZ162415');
    $strLink = GetExternalLink(GetHuaBaoFundUrl(), '华宝基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetGuangFaSoftwareLinks()
{
    $ar = array('SZ159941', 'SZ162719');
    $strLink = GetExternalLink(GetGuangFaFundUrl(), '广发基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetGuoTaiSoftwareLinks()
{
    $ar = array('SH513100', 'SH518800', 'SZ160216');
    $strLink = GetExternalLink(GetGuoTaiFundUrl(), '国泰基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaXiaSoftwareLinks()
{
    $ar = array('SH510330', 'SH513300', 'SH513660', 'SZ159920');
    $strLink = GetExternalLink(GetHuaXiaFundUrl(), '华夏基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetJiaShiSoftwareLinks()
{
    $ar = array('SZ159919', 'SZ160717', 'SZ160719', 'SZ160723');
    $strLink = GetExternalLink(GetJiaShiFundUrl(), '嘉实基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaAnSoftwareLinks()
{
    $ar = array('SH513030', 'SH518880', 'SZ160416');
    $strLink = GetExternalLink(GetHuaAnFundUrl(), '华安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaTaiSoftwareLinks()
{
    $ar = array('SH510300');
    $strLink = GetExternalLink('http://www.huatai-pb.com', '华泰柏瑞');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetIcbcCsSoftwareLinks()
{
    $ar = array('SZ164824');
    $strLink = GetExternalLink('http://www.icbccs.com.cn', '工银瑞信');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetNuoAnSoftwareLinks()
{
    $ar = array('SZ163208');
    $strLink = GetExternalLink(GetNuoAnFundUrl(), '诺安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetPenghuaSoftwareLinks()
{
    $ar = array('SH501025');
    $strLink = GetExternalLink(GetPenghuaFundUrl(), '鹏华基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetNanFangSoftwareLinks()
{
    $ar = array('SH501018', 'SH501302', 'SZ160140');
    $strLink = GetExternalLink(GetNanFangFundUrl(), '南方基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetUbsSdicSoftwareLinks()
{
    $ar = array('SZ161226');
    $strLink = GetExternalLink('http://www.ubssdic.com', '国投瑞银');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetUniversalSoftwareLinks()
{
    $ar = array('SH501043', 'SZ164701');
    $strLink = GetExternalLink('http://www.99fund.com', '汇添富基金');
    return GetCategorySoftwareLinks($ar, $strLink);
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
