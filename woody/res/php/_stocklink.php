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
    $strLink = GetStockGroupLink($strGroupId, $bChinese);
    return _getReturnGroupText($strLink, $bChinese);
}

function _GetReturnSymbolGroupLink($strSymbol, $bChinese)
{
    if ($strLink = SelectStockLink($strSymbol, $bChinese))
    {
    	return _getReturnGroupText($strLink, $bChinese);
    }
    return '';
}

function _GetAdjustLink($strSymbol, $strQuery, $bChinese)
{
    return GetPhpLink(STOCK_PATH.'editstockgroup', $bChinese, '校准', 'Adjust', $strQuery).' '.$strSymbol;
}

function _GetEtfAdjustString($ref, $etf_ref, $bChinese)
{
    $strSymbol = $ref->GetStockSymbol();
    $strQuery = sprintf('%s=%.3f&%s=%.3f', $strSymbol, $ref->fPrice, $etf_ref->GetStockSymbol(), $etf_ref->fPrice);
    return _GetAdjustLink($strSymbol, $strQuery, $bChinese);
}

function _getPersonalGroupLink($strGroupId, $bChinese)
{
	$sql = new StockGroupItemSql($strGroupId);
    $arStockId = $sql->GetStockIdArray(true);
    if (count($arStockId) > 0)
    {
		return GetStockGroupLink($strGroupId, $bChinese);
    }
    return '';
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
    return GetPhpLink(STOCK_PATH.$strCategory, $bChinese, $ar[$strCategory]);
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
  
    case 'chinaetf':
    	$ar = ChinaEtfGetSymbolArray();
        break;
        
    case 'chinainternet':
        $ar = LofGetChinaInternetSymbolArray();
        break;
        
    case 'commodity':
        $ar = LofGetCommoditySymbolArray();
        break;
        
    case 'etflist':
        $ar = SqlGetEtfPairArray();
        break;
  
    case 'goldetf':
    	$ar = GoldEtfGetSymbolArray();
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
    	$ar = LofGetSpySymbolArray();
        break;
        
    case 'oilfund':
    	$ar = array('ptr', 'shi', 'snp');
    	$ar = array_merge($ar, LofGetOilEtfSymbolArray()
    							, LofGetOilSymbolArray());
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

function EchoOilSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('oilfund', $bChinese);
}

function EchoGoldSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('goldetf', $bChinese);
}

function EchoCommoditySoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('commodity', $bChinese);
}

function EchoQqqSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('qqqfund', $bChinese);
}

function EchoSpySoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('spyfund', $bChinese);
}

function EchoHangSengSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('hangseng', $bChinese);
}

function EchoHSharesSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('hshares', $bChinese);
}

function EchoASharesSoftwareLinks($bChinese = true)
{
    $ar = array('sz150022', 'sz150152');
   	$ar = array_merge($ar, ChinaEtfGetSymbolArray());
    $str = _getCategorySoftwareLinks($ar, 'A股', 'A Shares', $bChinese);
    echo $str;
}

function EchoBricSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('bricfund', $bChinese);
}

function EchoChinaInternetSoftwareLinks($bChinese = true)
{
    _echoCategorySoftwareLinks('chinainternet', $bChinese);
}

function EchoMilitarySoftwareLinks($bChinese = true)
{
    $ar = array('sh502004', 'sz150181', 'sz150186');
    $str = _getCategorySoftwareLinks($ar, '军工', 'Military', $bChinese);
    echo $str;
}

function EchoBrokageSoftwareLinks($bChinese = true)
{
    $ar = array('sz150200', 'sz150223');
    $str = _getCategorySoftwareLinks($ar, '证券公司', 'Brokage', $bChinese);
    echo $str;
}

function EchoBoseraSoftwareLinks($bChinese = true)
{
    $ar = array('sh513500', 'sz159937');
    $strLink = GetExternalLink('http://www.bosera.com', $bChinese ? '博时基金' : 'Bosera Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoBocomSchroderSoftwareLinks($bChinese = true)
{
    $ar = array('sz164906');
    $strLink = GetExternalLink('http://www.fund001.com', $bChinese ? '交银施罗德基金' : 'BOCOM Schroder Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoChinaAmcSoftwareLinks($bChinese = true)
{
    $ar = array('sh510330', 'sh513660', 'sz159920');
    $strLink = GetExternalLink('http://www.chinaamc.com', $bChinese ? '华夏基金' : 'China AMC');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoCiticPruSoftwareLinks($bChinese = true)
{
    $ar = array('sz165510', 'sz165513');
    $strLink = GetExternalLink('http://www.citicprufunds.com.cn', $bChinese ? '信诚基金' : 'CITIC-PRUDENTIAL Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoCmfSoftwareLinks($bChinese = true)
{
    $ar = array('sz150200', 'sz161714');
    $strLink = GetExternalLink('http://www.cmfchina.com/main/index/index.shtml', $bChinese ? '招商基金' : 'China Merchants Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoDaChengSoftwareLinks($bChinese = true)
{
    $ar = array('sz160924');
    $strLink = GetExternalLink('http://www.dcfund.com.cn', $bChinese ? ' 大成基金' : 'Da Cheng Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoEFundSoftwareLinks($bChinese = true)
{
    $ar = array('sh502004', 'sh510900', 'sh513050', 'sz159934', 'sz161116', 'sz161125', 'sz161126', 'sz161127', 'sz161128', 'sz161129');
    $strLink = GetExternalLink('http://www.efunds.com.cn', $bChinese ? '易方达基金' : 'E Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoFortuneSoftwareLinks($bChinese = true)
{
    $ar = array('sh501021', 'sz162411', 'sz162415');
    $strLink = GetExternalLink('http://www.fsfund.com', $bChinese ? '华宝基金' : 'Hwabao Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoFullgoalSoftwareLinks($bChinese = true)
{
    $ar = array('sz150152', 'sz150181', 'sz150209', 'sz150223');
    $strLink = GetExternalLink('http://www.fullgoal.com.cn', $bChinese ? '富国基金' : 'Fullgoal Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoGuangFaSoftwareLinks($bChinese = true)
{
    $ar = array('sz159941', 'sz162719');
    $strLink = GetExternalLink('http://www.gffunds.com.cn', $bChinese ? '广发基金' : 'GF Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoGuoTaiSoftwareLinks($bChinese = true)
{
    $ar = array('sh513100', 'sh518800', 'sz160216');
    $strLink = GetExternalLink('http://www.gtfund.com', $bChinese ? '国泰基金' : 'GuoTai Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoHarvestSoftwareLinks($bChinese = true)
{
    $ar = array('sz159919', 'sz160717', 'sz160719', 'sz160723');
    $strLink = GetExternalLink('http://www.jsfund.cn', $bChinese ? '嘉实基金' : 'Harvest Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoHuaAnSoftwareLinks($bChinese = true)
{
    $ar = array('sh513030', 'sh518880', 'sz160416');
    $strLink = GetExternalLink('http://www.huaan.com.cn', $bChinese ? '华安基金' : 'HuaAn Funds');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoHuaTaiSoftwareLinks($bChinese = true)
{
    $ar = array('sh510300');
    $strLink = GetExternalLink('http://www.huatai-pb.com', $bChinese ? '华泰柏瑞' : 'HuaTai-PB Funds');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoPenghuaSoftwareLinks($bChinese = true)
{
    $ar = array('sh501025', 'sz150205', 'sz150277');
    $strLink = GetExternalLink('http://www.phfund.com.cn', $bChinese ? '鹏华基金' : 'Penghua Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoSouthernSoftwareLinks($bChinese = true)
{
    $ar = array('sh501018', 'sz160125', 'sz160140');
    $strLink = GetExternalLink('http://www.nffund.com', $bChinese ? '南方基金' : 'CSAM');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoSwsMuSoftwareLinks($bChinese = true)       
{
    $ar = array('sz150022', 'sz150186');
    $strLink = GetExternalLink('http://www.swsmu.com', $bChinese ? '申万菱信基金' : 'SWS MU Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoUniversalSoftwareLinks($bChinese = true)
{
    $ar = array('sz150169', 'sz164701');
    $strLink = GetExternalLink('http://www.99fund.com', $bChinese ? '汇添富基金' : 'CUAM');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
}

function EchoYinHuaSoftwareLinks($bChinese = true)
{
    $ar = array('sz150175', 'sz161815');
    $strLink = GetExternalLink('http://www.yhfund.com.cn', $bChinese ? '银华基金' : 'YinHua Fund');
    $str = GetCategorySoftwareLinks($ar, $strLink, $bChinese);
    echo $str;                 
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
	$sql = new StockGroupSql($strMemberId);
	if ($result = $sql->GetAll()) 
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

function _getStockGroupLinks($bChinese)
{
    $str = HTML_NEW_LINE.GetCategoryLinks(GetMenuArray, $bChinese);
    $str .= HTML_NEW_LINE.GetMyStockGroupLink($bChinese);	// .' '.GetAhCompareLink($bChinese).' '.GetAdrhCompareLink($bChinese);
    $str .= HTML_NEW_LINE.GetMyPortfolioLink($bChinese);
    if ($strMemberId = AcctIsLogin())
    {
        $str .= _getPersonalLinks($strMemberId, $bChinese);
    }
    return $str;
}

function EchoStockGroupLinks($bChinese = true)
{
	$str = _getStockGroupLinks($bChinese);
    echo $str;
}

function EchoStockCategory($bChinese = true)
{
	$str = $bChinese ? '相关软件' : 'Related software'; 
    $str .= ':'.HTML_NEW_LINE.GetCategoryLinks(_getCategoryArray, $bChinese);
	$str .= _getStockGroupLinks($bChinese);
    EchoParagraph($str);
}

?>
