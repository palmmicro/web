<?php

function _getReturnGroupText($strLink, $bChinese)
{
    if ($bChinese)     
    {
        $str = "返回{$strLink}分组";
    }
    else
    {
        $str = "Return $strLink Group";
    }
    return $str.HTML_NEW_LINE;
}

function _GetReturnGroupLink($strGroupId, $bChinese)
{
    $strLink = SelectGroupInternalLink($strGroupId, $bChinese);
    return _getReturnGroupText($strLink, $bChinese);
}

function _GetReturnSymbolGroupLink($strSymbol, $bChinese)
{
    $strLink = SelectSymbolInternalLink($strSymbol, $bChinese);
    if ($strLink == $strSymbol)
    {
        return $strSymbol;
    }
    return _getReturnGroupText($strLink, $bChinese);
}

function _GetNavLink($strTitle, $strId, $iTotal, $iStart, $iNum, $bChinese)
{
    return UrlGetNavLink(STOCK_PATH.$strTitle, $strId, $iTotal, $iStart, $iNum, $bChinese);
}

function _GetStockNavLink($strTitle, $strSymbol, $iTotal, $iStart, $iNum, $bChinese)
{
    return _GetNavLink($strTitle, 'symbol='.$strSymbol, $iTotal, $iStart, $iNum, $bChinese);
}

function _GetAdjustLink($strSymbol, $strQuery, $bChinese)
{
    return UrlBuildPhpLink(STOCK_PATH.'editstockgroup', $strQuery, '校准', 'Adjust', $bChinese).' '.$strSymbol;
}

function _GetEtfAdjustString($ref, $etf_ref, $bChinese)
{
    $strSymbol = $ref->GetStockSymbol();
    $strQuery = sprintf('%s=%.3f&%s=%.3f', $strSymbol, $ref->fPrice, $etf_ref->GetStockSymbol(), $etf_ref->fPrice);
    return _GetAdjustLink($strSymbol, $strQuery, $bChinese);
}

function _getPersonalGroupLink($strGroupId, $bChinese)
{
    $str = '';
    if ($result = SqlGetStockGroupItemByGroupId($strGroupId)) 
    {   
        while ($groupitem = mysql_fetch_assoc($result)) 
        {
            if (intval($groupitem['record']) > 0)
            {
                $str = SelectGroupInternalLink($strGroupId, $bChinese);
                break;
            }
        }
        @mysql_free_result($result);
    }
    return $str;
}

$group = false;

function _checkPersonalGroupId($strGroupId)
{
    global $group;
    
    if ($group == false)                        return true;
    if ($group->strGroupId != $strGroupId)    return true;
    return false;
}

function _getPersonalLinks($strMemberId, $bChinese)
{
    $str = HTML_NEW_LINE;
	if ($result = SqlGetStockGroupByMemberId($strMemberId)) 
	{
		while ($stockgroup = mysql_fetch_assoc($result)) 
		{
		    $strGroupId = $stockgroup['id'];
		    if (_checkPersonalGroupId($strGroupId))
		    {
		        $str .= _getPersonalGroupLink($strGroupId, $bChinese).' ';
		    }
		}
		@mysql_free_result($result);
	}
	return $str;
}

function EchoStockGroupLinks($bChinese)
{
    $str .= HTML_NEW_LINE.UrlGetCategoryLinks(STOCK_PATH, GetMenuArray($bChinese), $bChinese);
//    $str .= HTML_NEW_LINE.StockGetGroupLink($bChinese).' '.GetAhCompareLink($bChinese).' '.GetAdrhCompareLink($bChinese);
//    $str .= HTML_NEW_LINE.GetMyPortfolioLink($bChinese);
    if ($strMemberId = AcctIsLogin())
    {
        $str .= _getPersonalLinks($strMemberId, $bChinese);
    }
    echo $str;
}

function _getCategoryArray($bChinese)
{
    if ($bChinese)
    {
        return array('oilfund' => '油气',
                      'commodity' => '商品',
                      'goldetf' => '金银',
                      'chinainternet' => '海外中国互联网',
                      'qqqfund' => '纳斯达克100',
                      'spyfund' => '标普500',
                      'bricfund' => '金砖四国',
                      'hangseng' => '恒生指数',
                      'hshares' => 'H股国企指数',
                     );
    }
    else
    {
         return array('oilfund' => 'Oil&Gas',
                      'commodity' => 'Commodity',
                      'goldetf' => 'Gold&Silver',
                      'chinainternet' => 'Overseas China Internet',
                      'qqqfund' => 'NASDAQ-100',
                      'spyfund' => 'S&P 500',
                      'bricfund' => 'BRIC',
                      'hangseng' => 'Hang Seng Index',
                      'hshares' => 'H-Shares',
                     );
    }
}

function _getCategoryLink($strCategory, $bChinese)
{
    $ar = _getCategoryArray($bChinese);
    return UrlGetPhpLink(STOCK_PATH.$strCategory, false, $ar[$strCategory], $bChinese);
}

function EchoStockCategoryLinks($bChinese)
{
    $str = HTML_NEW_LINE.UrlGetCategoryLinks(STOCK_PATH, _getCategoryArray($bChinese), $bChinese);
    echo $str;
}

function _getCategorySoftwareLinks($arTitle, $strCn, $strUs, $bChinese)
{
    return GetCategorySoftwareLinks($arTitle, $bChinese ? $strCn : $strUs, $bChinese);
}

function GetCategoryArray($strTitle)
{
    $ar = array();
    switch ($strTitle)
    {
    case 'adr':
        $ar = AdrGetSymbolArray();
        break;
        
    case 'bricfund':
        $ar = LofGetBricSymbolArray();
        break;
  
    case 'ahcompare':
        $ar = SqlGetAhArray();
        break;
  
    case 'adrhcompare':
        $ar = SqlGetAdrhArray();
        break;
  
    case 'chinainternet':
        $ar = LofGetChinaInternetSymbolArray();
        break;
        
    case 'commodity':
        $ar = LofGetCommoditySymbolArray();
        break;
        
    case 'future':
        $ar = FutureGetSymbolArray();
        break;
        
    case 'goldetf':
    	$ar = array('gc', 'si');
    	$ar = array_merge($ar, GoldEtfGetSymbolArray());
    	$ar = array_merge($ar, LofGetGoldSymbolArray());
        break;
        
    case 'gradedfund':
        $ar = GradedFundGetSymbolArray();
        break;
        
    case 'hangseng':
    	$ar[] = 'sz150169';
    	$ar = array_merge($ar, LofHkGetHangSengSymbolArray());
        break;
        
    case 'hshares':
    	$ar[] = 'sz150175';
    	$ar = array_merge($ar, LofHkGetHSharesSymbolArray());
        break;
        
    case 'lof':
        $ar = LofGetSymbolArray();
        break;
        
    case 'lofhk':
        $ar = LofHkGetSymbolArray();
        break;
        
    case 'spyfund':
    	$ar = array('es', 'spy', 'uvxy'); 
    	$ar = array_merge($ar, LofGetSpySymbolArray());
        break;
        
    case 'oilfund':
    	$ar = array('ptr', 'shi', 'snp', 'cl', 'ng', 'oil', 'xop');
    	$ar = array_merge($ar, LofGetOilEtfSymbolArray());
    	$ar = array_merge($ar, LofGetOilSymbolArray());
        break;
        
    case 'pairtrading':
        $ar = PairTradingGetSymbolArray();
        break;
        
    case 'qqqfund':
        $ar = LofGetQqqSymbolArray(); 
        break;
    }
    return $ar;
}

function _echoCategorySoftwareLinks($strCategory, $bChinese)
{
    $ar = GetCategoryArray($strCategory);
    $strLink = _getCategoryLink($strCategory, $bChinese);
    echo GetCategorySoftwareLinks($ar, $strLink, $bChinese);
}

function EchoOilSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('oilfund', $bChinese);
}

function EchoGoldSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('goldetf', $bChinese);
}

function EchoCommoditySoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('commodity', $bChinese);
}

function EchoQqqSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('qqqfund', $bChinese);
}

function EchoSpySoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('spyfund', $bChinese);
}

function EchoHangSengSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('hangseng', $bChinese);
}

function EchoHSharesSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('hshares', $bChinese);
}

function EchoASharesSoftwareLinks($bChinese)
{
    $ar = array('sz150022', 'sz150152');
    $str = _getCategorySoftwareLinks($ar, 'A股', 'A Shares', $bChinese);
    echo $str;
}

function EchoBricSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('bricfund', $bChinese);
}

function EchoChinaInternetSoftwareLinks($bChinese)
{
    _echoCategorySoftwareLinks('chinainternet', $bChinese);
}

function EchoMilitarySoftwareLinks($bChinese)
{
    $ar = array('sh502004', 'sz150181', 'sz150186');
    $str = _getCategorySoftwareLinks($ar, '军工', 'Military', $bChinese);
    echo $str;
}

function EchoBrokageSoftwareLinks($bChinese)
{
    $ar = array('sz150200', 'sz150223');
    $str = _getCategorySoftwareLinks($ar, '证券公司', 'Brokage', $bChinese);
    echo $str;
}

function EchoBoseraSoftwareLinks($bChinese)
{
    $ar = array('sh513500', 'sz159937');
    $strLink = DebugGetExternalLink('http://www.bosera.com', $bChinese ? '博时基金' : 'Bosera Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoBocomSchroderSoftwareLinks($bChinese)
{
    $ar = array('sz164906');
    $strLink = DebugGetExternalLink('http://www.fund001.com', $bChinese ? '交银施罗德基金' : 'BOCOM Schroder Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoChinaAmcSoftwareLinks($bChinese)
{
    $ar = array('sh513660', 'sz159920');
    $strLink = DebugGetExternalLink('http://www.chinaamc.com', $bChinese ? '华夏基金' : 'China AMC');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoCiticPruSoftwareLinks($bChinese)
{
    $ar = array('sz165510', 'sz165513');
    $strLink = DebugGetExternalLink('http://www.citicprufunds.com.cn', $bChinese ? '信诚基金' : 'CITIC-PRUDENTIAL Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoCmfSoftwareLinks($bChinese)
{
    $ar = array('sz150200', 'sz161714');
    $strLink = DebugGetExternalLink('http://www.cmfchina.com/main/index/index.shtml', $bChinese ? '招商基金' : 'China Merchants Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoDaChengSoftwareLinks($bChinese)
{
    $ar = array('sz160924');
    $strLink = DebugGetExternalLink('http://www.dcfund.com.cn', $bChinese ? ' 大成基金' : 'Da Cheng Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoEFundSoftwareLinks($bChinese)
{
    $ar = array('sh502004', 'sh510900', 'sh513050', 'sz159934', 'sz161116', 'sz161125', 'sz161126', 'sz161127', 'sz161128', 'sz161129');
    $strLink = DebugGetExternalLink('http://www.efunds.com.cn', $bChinese ? '易方达基金' : 'E Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoFortuneSoftwareLinks($bChinese)
{
    $ar = array('sh501021', 'sz162411', 'sz162415');
    $strLink = DebugGetExternalLink('http://www.fsfund.com', $bChinese ? '华宝基金' : 'Hwabao Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoFullgoalSoftwareLinks($bChinese)
{
    $ar = array('sz150152', 'sz150181', 'sz150209', 'sz150223');
    $strLink = DebugGetExternalLink('http://www.fullgoal.com.cn', $bChinese ? '富国基金' : 'Fullgoal Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoGuangFaSoftwareLinks($bChinese)
{
    $ar = array('sz159941', 'sz162719');
    $strLink = DebugGetExternalLink('http://www.gffunds.com.cn', $bChinese ? '广发基金' : 'GF Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoGuoTaiSoftwareLinks($bChinese)
{
    $ar = array('sh513100', 'sh518800', 'sz160216');
    $strLink = DebugGetExternalLink('http://www.gtfund.com', $bChinese ? '国泰基金' : 'GuoTai Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoHarvestSoftwareLinks($bChinese)
{
    $ar = array('sz160717', 'sz160719', 'sz160723');
    $strLink = DebugGetExternalLink('http://www.jsfund.cn', $bChinese ? '嘉实基金' : 'Harvest Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoHuaAnSoftwareLinks($bChinese)
{
    $ar = array('sh513030', 'sh518880', 'sz160416');
    $strLink = DebugGetExternalLink('http://www.huaan.com.cn', $bChinese ? '华安基金' : 'HuaAn Funds');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoPenghuaSoftwareLinks($bChinese)
{
    $ar = array('sh501025', 'sz150205', 'sz150277');
    $strLink = DebugGetExternalLink('http://www.phfund.com.cn', $bChinese ? '鹏华基金' : 'Penghua Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoSouthernSoftwareLinks($bChinese)
{
    $ar = array('sh501018', 'sz160125', 'sz160140');
    $strLink = DebugGetExternalLink('http://www.nffund.com', $bChinese ? '南方基金' : 'CSAM');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoSwsMuSoftwareLinks($bChinese)       
{
    $ar = array('sz150022', 'sz150186');
    $strLink = DebugGetExternalLink('http://www.swsmu.com', $bChinese ? '申万菱信基金' : 'SWS MU Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoUniversalSoftwareLinks($bChinese)
{
    $ar = array('sz150169', 'sz164701');
    $strLink = DebugGetExternalLink('http://www.99fund.com', $bChinese ? '汇添富基金' : 'CUAM');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoYinHuaSoftwareLinks($bChinese)
{
    $ar = array('sz150175', 'sz161815');
    $strLink = DebugGetExternalLink('http://www.yhfund.com.cn', $bChinese ? '银华基金' : 'YinHua Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

?>
