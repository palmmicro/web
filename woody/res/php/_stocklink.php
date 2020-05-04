<?php

function _GetAdjustLink($strSymbol, $strQuery)
{
    return GetPhpLink(STOCK_PATH.'editstockgroup', 'adjust=1&'.$strQuery, '校准').' '.$strSymbol;
}

function _GetEtfAdjustString($ref, $etf_ref)
{
	$strSymbol = $ref->GetSymbol();
    $strQuery = sprintf('%s=%s&%s=%s', $strSymbol, $ref->GetPrice(), $etf_ref->GetSymbol(), $etf_ref->GetPrice());
    return _GetAdjustLink($strSymbol, $strQuery);
}

function GetStockCategoryArray()
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

function GetOilSoftwareLinks()
{
    return _getCategorySoftwareLinks('oilfund');
}

function GetGoldSoftwareLinks()
{
    return _getCategorySoftwareLinks('goldetf');
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
   	$ar = ChinaEtfGetSymbolArray();
    $str = GetCategorySoftwareLinks($ar, 'A股');
    return $str;
}

function GetBricSoftwareLinks()
{
    return _getCategorySoftwareLinks('bricfund');
}

function GetChinaInternetSoftwareLinks()
{
    return _getCategorySoftwareLinks('chinainternet');
}

function GetBoShiSoftwareLinks()
{
    $ar = array('sh513500', 'sz159937');
    $strLink = GetExternalLink(GetBoShiFundUrl(), '博时基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetBocomSchroderSoftwareLinks()
{
    $ar = array('sz164906');
    $strLink = GetExternalLink('http://www.fund001.com', '交银施罗德基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetChinaAmcSoftwareLinks()
{
    $ar = array('sh510330', 'sz159920');
    $strLink = GetExternalLink('http://www.chinaamc.com', '华夏基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetXinChengSoftwareLinks()
{
    $ar = array('sz165510', 'sz165513');
    $strLink = GetExternalLink(GetXinChengFundUrl(), '信诚基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetCmfSoftwareLinks()
{
    $ar = array('sz161714');
    $strLink = GetExternalLink('http://www.cmfchina.com/main/index/index.shtml', '招商基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetDaChengSoftwareLinks()
{
    $ar = array('sz160924');
    $strLink = GetExternalLink('http://www.dcfund.com.cn', '大成基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetEFundSoftwareLinks()
{
    $ar = array('sh510900', 'sh513050', 'sz159934', 'sz161116', 'sz161125', 'sz161126', 'sz161127', 'sz161128', 'sz161129', 'sz161130');
    $strLink = GetExternalLink(GetEFundUrl(), '易方达基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaBaoSoftwareLinks()
{
    $ar = array('sz162411', 'sz162415');
    $strLink = GetExternalLink(GetHuaBaoFundUrl(), '华宝基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetGuangFaSoftwareLinks()
{
    $ar = array('sz159941', 'sz162719');
    $strLink = GetExternalLink('http://www.gffunds.com.cn', '广发基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetGuoTaiSoftwareLinks()
{
    $ar = array('sh513100', 'sh518800', 'sz160216');
    $strLink = GetExternalLink(GetGuoTaiFundUrl(), '国泰基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetJiaShiSoftwareLinks()
{
    $ar = array('sz159919', 'sz160717', 'sz160719', 'sz160723');
    $strLink = GetExternalLink(GetJiaShiFundUrl(), '嘉实基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaAnSoftwareLinks()
{
    $ar = array('sh513030', 'sh518880', 'sz160416');
    $strLink = GetExternalLink(GetHuaAnFundUrl(), '华安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetHuaTaiSoftwareLinks()
{
    $ar = array('sh510300');
    $strLink = GetExternalLink('http://www.huatai-pb.com', '华泰柏瑞');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetIcbcCsSoftwareLinks()
{
    $ar = array('sz164824');
    $strLink = GetExternalLink('http://www.icbccs.com.cn', '工银瑞信');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetLionSoftwareLinks()
{
    $ar = array('sz163208');
    $strLink = GetExternalLink('http://www.lionfund.com.cn', '诺安基金');
    return GetCategorySoftwareLinks($ar, $strLink);
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

function GetUbsSdicSoftwareLinks()
{
    $ar = array('sz161226');
    $strLink = GetExternalLink('http://www.ubssdic.com', '国投瑞银');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetUniversalSoftwareLinks()
{
    $ar = array('sz164701');
    $strLink = GetExternalLink('http://www.99fund.com', '汇添富基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

function GetYinHuaSoftwareLinks()
{
    $ar = array('sz161815');
    $strLink = GetExternalLink(GetYinHuaFundUrl(), '银华基金');
    return GetCategorySoftwareLinks($ar, $strLink);
}

?>
