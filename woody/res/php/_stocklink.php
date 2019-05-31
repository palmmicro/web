<?php

function _GetAdjustLink($strSymbol, $strQuery)
{
    return GetPhpLink(STOCK_PATH.'editstockgroup', 'adjust=1&'.$strQuery, '校准').' '.$strSymbol;
}

function _GetEtfAdjustString($ref, $etf_ref)
{
	$strSymbol = $ref->GetStockSymbol();
    $strQuery = sprintf('%s=%s&%s=%s', $strSymbol, $ref->GetPrice(), $etf_ref->GetStockSymbol(), $etf_ref->GetPrice());
    return _GetAdjustLink($strSymbol, $strQuery);
}

function _getCategoryArray()
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

function _getCategoryLink($strCategory)
{
    $ar = _getCategoryArray();
    return GetPhpLink(STOCK_PATH.$strCategory, false, $ar[$strCategory]);
}

function GetCategoryArray($strTitle)
{
    $ar = array();
    switch ($strTitle)
    {
    case 'adr':
        $ar = AdrGetSymbolArray();
        break;
        
    case 'adrhcompare':
        $ar = SqlGetAdrhArray();
        break;
  
    case 'ahcompare':
        $ar = SqlGetAhArray();
        break;
  
    case 'bricfund':
        $ar = LofGetBricSymbolArray();
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
        
    case 'hangseng':
    	$ar = LofHkGetHangSengSymbolArray();
        break;
        
    case 'hshares':
    	$ar = LofHkGetHSharesSymbolArray();
        break;
        
    case 'lof':
        $ar = LofGetSymbolArray();
        break;
        
    case 'lofhk':
        $ar = LofHkGetSymbolArray();
        break;
        
    case 'oilfund':
    	$ar = array('ptr', 'shi', 'snp');
    	$ar = array_merge($ar, LofGetOilEtfSymbolArray()
    							, LofGetOilSymbolArray());
        break;
        
    case 'qqqfund':
        $ar = LofGetQqqSymbolArray(); 
        break;

    case 'spyfund':
    	$ar = LofGetSpySymbolArray();
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

function _echoCategorySoftwareLinks($strCategory)
{
	echo _getCategorySoftwareLinks($strCategory);
}

function GetOilSoftwareLinks()
{
    return _getCategorySoftwareLinks('oilfund');
}

function EchoOilSoftwareLinks()
{
    _echoCategorySoftwareLinks('oilfund');
}

function GetGoldSoftwareLinks()
{
    return _getCategorySoftwareLinks('goldetf');
}

function EchoGoldSoftwareLinks()
{
    _echoCategorySoftwareLinks('goldetf');
}

function GetCommoditySoftwareLinks()
{
    return _getCategorySoftwareLinks('commodity');
}

function EchoCommoditySoftwareLinks()
{
    _echoCategorySoftwareLinks('commodity');
}

function GetQqqSoftwareLinks()
{
    return _getCategorySoftwareLinks('qqqfund');
}

function EchoQqqSoftwareLinks()
{
    _echoCategorySoftwareLinks('qqqfund');
}

function GetSpySoftwareLinks()
{
    return _getCategorySoftwareLinks('spyfund');
}

function EchoSpySoftwareLinks()
{
    _echoCategorySoftwareLinks('spyfund');
}

function GetHangSengSoftwareLinks()
{
    return _getCategorySoftwareLinks('hangseng');
}

function EchoHangSengSoftwareLinks()
{
    _echoCategorySoftwareLinks('hangseng');
}

function GetHSharesSoftwareLinks()
{
    return _getCategorySoftwareLinks('hshares');
}

function EchoHSharesSoftwareLinks()
{
    _echoCategorySoftwareLinks('hshares');
}

function GetASharesSoftwareLinks()
{
   	$ar = ChinaEtfGetSymbolArray();
    $str = GetCategorySoftwareLinks($ar, 'A股');
    return $str;
}

function EchoASharesSoftwareLinks()
{
    echo GetASharesSoftwareLinks();
}

function EchoBricSoftwareLinks()
{
    _echoCategorySoftwareLinks('bricfund');
}

function EchoChinaInternetSoftwareLinks()
{
    _echoCategorySoftwareLinks('chinainternet');
}

function GetBoseraSoftwareLinks()
{
    $ar = array('sh513500', 'sz159937');
    $strLink = GetExternalLink('http://www.bosera.com', '博时基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoBoseraSoftwareLinks()
{
    echo GetBoseraSoftwareLinks();                 
}

function EchoBocomSchroderSoftwareLinks()
{
    $ar = array('sz164906');
    $strLink = GetExternalLink('http://www.fund001.com', '交银施罗德基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

function GetChinaAmcSoftwareLinks()
{
    $ar = array('sh510330', 'sz159920');
    $strLink = GetExternalLink('http://www.chinaamc.com', '华夏基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoCiticPruSoftwareLinks()
{
    $ar = array('sz165510', 'sz165513');
    $strLink = GetExternalLink('http://www.citicprufunds.com.cn', '信诚基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

function EchoCmfSoftwareLinks()
{
    $ar = array('sz161714');
    $strLink = GetExternalLink('http://www.cmfchina.com/main/index/index.shtml', '招商基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

function GetDaChengSoftwareLinks()
{
    $ar = array('sz160924');
    $strLink = GetExternalLink('http://www.dcfund.com.cn', '大成基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetEFundSoftwareLinks()
{
    $ar = array('sh510900', 'sh513050', 'sz159934', 'sz161116', 'sz161125', 'sz161126', 'sz161127', 'sz161128', 'sz161129');
    $strLink = GetExternalLink('http://www.efunds.com.cn', '易方达基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoEFundSoftwareLinks()
{
    echo GetEFundSoftwareLinks();                 
}

function EchoFortuneSoftwareLinks()
{
    $ar = array('sz162411', 'sz162415');
    $strLink = GetExternalLink('http://www.fsfund.com', '华宝基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

function EchoGuangFaSoftwareLinks()
{
    $ar = array('sz159941', 'sz162719');
    $strLink = GetExternalLink('http://www.gffunds.com.cn', '广发基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

function GetGuoTaiSoftwareLinks()
{
    $ar = array('sh513100', 'sh518800', 'sz160216');
    $strLink = GetExternalLink('http://www.gtfund.com', '国泰基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoGuoTaiSoftwareLinks()
{
    echo GetGuoTaiSoftwareLinks();                 
}

function GetHarvestSoftwareLinks()
{
    $ar = array('sz159919', 'sz160717', 'sz160719', 'sz160723');
    $strLink = GetExternalLink('http://www.jsfund.cn', '嘉实基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoHarvestSoftwareLinks()
{
	echo GetHarvestSoftwareLinks();
}

function GetHuaAnSoftwareLinks()
{
    $ar = array('sh513030', 'sh518880', 'sz160416');
    $strLink = GetExternalLink('http://www.huaan.com.cn', '华安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoHuaAnSoftwareLinks()
{
	echo GetHuaAnSoftwareLinks();
}

function GetHuaTaiSoftwareLinks()
{
    $ar = array('sh510300');
    $strLink = GetExternalLink('http://www.huatai-pb.com', '华泰柏瑞');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoHuaTaiSoftwareLinks()
{
	echo GetHuaTaiSoftwareLinks();
}

function GetPenghuaSoftwareLinks()
{
    $ar = array('sh501025');
    $strLink = GetExternalLink('http://www.phfund.com.cn', '鹏华基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetSouthernSoftwareLinks()
{
    $ar = array('sh501018', 'sh513660', 'sz160140');
    $strLink = GetExternalLink('http://www.nffund.com', '南方基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoSouthernSoftwareLinks()
{
    echo GetSouthernSoftwareLinks();                 
}

function GetUbsSdicSoftwareLinks()
{
    $ar = array('sz161226');
    $strLink = GetExternalLink('http://www.ubssdic.com', '国投瑞银');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function EchoUniversalSoftwareLinks()
{
    $ar = array('sz164701');
    $strLink = GetExternalLink('http://www.99fund.com', '汇添富基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

function EchoYinHuaSoftwareLinks()
{
    $ar = array('sz161815');
    $strLink = GetExternalLink('http://www.yhfund.com.cn', '银华基金');
    $str = GetCategorySoftwareLinks($ar, $strLink);
    echo $str;                 
}

$group = false;

function _checkPersonalGroupId($strGroupId)
{
    global $group;
    
    if ($group == false)                        return true;
    if ($group->GetGroupId() != $strGroupId)    return true;
    return false;
}

function _getPersonalGroupLink($strGroupId)
{
	$sql = new StockGroupItemSql($strGroupId);
    $arStockId = $sql->GetStockIdArray(true);
    if (count($arStockId) > 0)
    {
		return GetStockGroupLink($strGroupId);
    }
    return '';
}

function _getPersonalLinks($strMemberId)
{
    $str = ' - ';
	$sql = new StockGroupSql($strMemberId);
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
		    $strGroupId = $record['id'];
		    if (_checkPersonalGroupId($strGroupId))
		    {
		        $str .= _getPersonalGroupLink($strGroupId).' ';
		    }
		}
		@mysql_free_result($result);
	}
	return $str;
}

function GetStockGroupLinks($strLoginId = false)
{
    if ($strLoginId == false)	$strLoginId = AcctIsLogin();
    $str = '<br />'.GetCategoryLinks(GetMenuArray());
    $str .= '<br />'.GetMyPortfolioLink();
    if ($strLoginId)
    {
        $str .= _getPersonalLinks($strLoginId);
    }
    else
    {
    	$str .= '<br />'.GetMyStockGroupLink();	// .' '.GetAhCompareLink().' '.GetAdrhCompareLink();
    }
    return $str;
}

function EchoStockGroupLinks()
{
	$str = GetStockGroupLinks();
    echo $str;
}

function EchoStockCategory($strLoginId = false)
{
    $str = GetCategoryLinks(_getCategoryArray());
	$str .= GetStockGroupLinks($strLoginId);
    EchoParagraph($str);
}

?>
