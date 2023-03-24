<?php
require_once('externalurl.php');
require_once('stock/stocksymbol.php');

// ****************************** External link functions *******************************************************
function GetOfficialLink($strHttp, $strDisplay)
{
    return GetExternalLink($strHttp, $strDisplay.'官网');
}

// https://www.spglobal.com/spdji/en/indices/equity/sp-oil-gas-exploration-production-select-industry-index/#overview
function GetSpindicesOfficialLink($strTicker)
{
	$str = 'https://www.spglobal.com/spdji/en/indices/';
	switch ($strTicker)
	{
	case 'DJSOEP':
		$str .= 'equity/dow-jones-us-select-oil-exploration-production-index';
		break;
		
	case 'SPGCCI':
		$str .= 'commodities/sp-gsci';
		break;
		
	case 'GSPE':
		$str .= 'equity/sp-500-energy-sector';
		break;
		
	case 'IXE':
		$str .= 'equity/energy-select-sector-index';
		break;
		
	case 'SGES':
		$str .= 'equity/sp-global-1200-energy-sector';
		break;

	case 'SPGOGUP':
		$str .= 'equity/sp-global-oil-index';
		break;
		
	case 'SPSIOP':
		$str .= 'equity/sp-oil-gas-exploration-production-select-industry-index';
		break;
	}
	$str .= '/#overview';
	return GetOfficialLink($str, '^'.$strTicker);
}

function GetIsharesOfficialLink($strSymbol)
{
	$str = GetIsharesEtfUrl($strSymbol);
	return GetOfficialLink($str, $strSymbol);
}

function GetSpdrOfficialLink($strSymbol)
{
	$str = GetSpdrEtfUrl().'funds/';
	switch ($strSymbol)
	{
	case 'XBI':
		$str .= 'spdr-sp-biotech-etf-xbi';
		break;

	case 'XLE':
		$str .= 'the-energy-select-sector-spdr-fund-xle';
		break;

	case 'XLY':
		$str .= 'the-consumer-discretionary-select-sector-spdr-fund-xly';
		break;

	case 'XOP':
		$str .= 'spdr-sp-oil-gas-exploration-production-etf-xop';
		break;
	}
	return GetOfficialLink($str, $strSymbol);
}

function GetInvescoOfficialLink($strSymbol)
{
	$str = 'https://www.invesco.com/us/financial-products/etfs/product-detail?productId='.$strSymbol;
	return GetOfficialLink($str, $strSymbol);
}

function GetKraneOfficialLink($strSymbol)
{
	$str = GetKraneUrl().strtolower($strSymbol).'/';
	return GetOfficialLink($str, $strSymbol);
}

function GetCsindexOfficialLink($strSymbol)
{
	$str = GetCsindexUrl($strSymbol);
	return GetOfficialLink($str, $strSymbol);
}

function GetShangHaiEtfListLink()
{
    return GetExternalLink(GetSseUrl().'disclosure/fund/etflist/', '上交所ETF申购赎回清单');
}

function GetShangHaiEtfShareLink()
{
    return GetExternalLink(GetSseUrl().'market/funddata/volumn/etfvolumn/', '上交所ETF规模');
}

function GetShangHaiLofShareLink()
{
    return GetExternalLink(GetSseUrl().'assortment/fund/lof/scale/', '上交所LOF规模');
}

function GetShenZhenLofLink()
{
    return GetExternalLink(GetSzseUrl().'market/product/list/lofFundList/index.html', '深交所LOF数据');
}

function GetShenZhenEtfListLink()
{
    return GetExternalLink(GetSzseUrl().'disclosure/fund/currency/index.html', '深交所申购赎回清单');
}

function GetEastMoneyFundLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsFundA())
    {
        $strHttp = GetEastMoneyFundUrl().$strDigit.'.html';
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetXueqiuLink($sym, $strDisplay = false)
{
    $strSymbol = $sym->GetSymbol();
	$strXueqiu = $strSymbol;
    if ($sym->IsIndex())
    {
    	switch ($strSymbol)
    	{
    	case '^GSPC':
			$strXueqiu = '.INX';
			break;
			
		case '^HSI':
			$strXueqiu = 'HKHSI';
			break;
			
		case '^HSCE':
			$strXueqiu = 'HKHSCEI';
			break;
			
		case '^HSTECH':
			$strXueqiu = 'HKHSTECH';
			break;
		}
	}
    $strHttp = GetXueqiuUrl().'S/'.$strXueqiu;
    return GetExternalLink($strHttp, ($strDisplay ? $strDisplay : $strSymbol));
}

function GetXueQiuIdLink($strId, $strDisplay)
{
    return GetExternalLink(GetXueqiuUrl().'u/'.$strId, $strDisplay);
}

function GetYahooStockLink($sym)
{
    $strHttp = GetYahooStockUrl($sym->GetYahooSymbol());
    return GetExternalLink($strHttp, $sym->GetSymbol());
}

function GetYahooNavLink($strSymbol)
{
    $strHttp = GetYahooStockUrl(GetYahooNetValueSymbol($strSymbol));
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaFundLink($sym)
{
    $strDigit = $sym->IsFundA();
    if ($strDigit == false)
    {
    	$strDigit = $sym->IsSinaFund();
    }
    
    $strSymbol = $sym->GetSymbol();
    if ($strDigit)
    {
        $strHttp = GetSinaFinanceUrl()."/fund/quotes/$strDigit/bc.shtml";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetSinaCnStockLink($strSymbol)
{
    $strLower = strtolower($strSymbol);
    $strHttp = GetSinaFinanceUrl()."/realstock/company/$strLower/nc.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaUsStockLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($sym->IsIndex())
    {
		$str = '.'.strtoupper($sym->GetSinaIndexUS());
	}
    else 
    {
        $str = $strSymbol;
    }
    $strHttp = GetSinaStockUrl()."/usstock/quotes/$str.html";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaHkStockLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($sym->IsIndex())
    {
		$str = $sym->GetSinaIndexH();
	}
    else 
    {
        $str = $strSymbol;
    }
    $strHttp = GetSinaStockUrl()."/hkstock/quotes/$str.html";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaStockLink($sym)
{
    if ($sym->IsSymbolA())
    {
    	if ($sym->IsFundA())
    	{
    		return GetSinaFundLink($sym);
    	}
    	return GetSinaCnStockLink($sym->GetSymbol());
    }
    else if ($sym->IsSymbolH())
    {
    	return GetSinaHkStockLink($sym);
    }
  	return GetSinaUsStockLink($sym);
}

function GetSinaFutureLink($sym)
{
	if ($strSymbol = $sym->IsSinaFutureUs())
	{
	}
	else
	{
		$strSymbol = $sym->GetSymbol();
	}
    $strHttp = GetSinaFinanceUrl()."/futures/quotes/$strSymbol.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaForexLink($sym)
{
	if ($str = $sym->IsNewSinaForex())
	{
		$strSymbol = 'USD'.strtoupper($str);
	}
	else
	{
		$strSymbol = $sym->GetSymbol();
	}
    $strHttp = GetSinaFinanceUrl()."/money/forex/hq/$strSymbol.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetExternalStockHistoryLink($sym)
{
	$strHttp = GetYahooStockHistoryUrl($sym->GetYahooSymbol());
    return GetExternalLink($strHttp, '历史数据');
}

// https://finance.yahoo.com/quote/XOP/history?filter=div
function GetStockDividendUrl($sym)
{
   	$strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsSymbolA())
    {
    	return GetSinaVipStockUrl()."/corp/go.php/vISSUE_ShareBonus/stockid/$strDigit.phtml";
    }
    else if ($sym->IsSymbolH())
    {
    	return GetSinaStockUrl()."/hkstock/dividends/$strSymbol.html";
    }
    return GetYahooStockHistoryUrl($strSymbol).'?filter=div';
}

function GetStockDividendLink($sym)
{
    $strHttp = GetStockDividendUrl($sym);
    return GetExternalLink($strHttp, '分红数据');
}

function GetReferenceRateForexLink($strSymbol)
{
    $strHttp = 'http://www.chinamoney.com.cn/index.html';
    return GetExternalLink($strHttp, $strSymbol);
}

function GetTradingViewLink($strSymbol)
{
    $strHttp = 'https://www.tradingview.com/symbols/AMEX-'.$strSymbol.'/';
    return GetExternalLink($strHttp, $strSymbol);
}

// http://stockcharts.com/h-sc/ui?s=XOP&p=D&b=5&g=0&id=p39648755011
function GetStockChartsLink($strSymbol)
{
	if ($strSymbol == '^GSPC')		$str = '$SPX';
	else if ($strSymbol == '^NDX')	$str = '$NDX';
	else								$str = $strSymbol;
    $strHttp = 'http://stockcharts.com/h-sc/ui?s='.$str.'&p=D&b=5&g=0&id=p39648755011';
    return GetExternalLink($strHttp, $strSymbol);
}

function GetWeixinLink()
{
    $strHttp = 'https://mp.weixin.qq.com';
    return GetExternalLink($strHttp, '微信公众平台');
}

function GetAastocksLink($strType = 'adr')
{
	return GetExternalLink(GetAastocksUrl($strType), '阿思達克');
}

function GetJisiluGoldLink()
{
	return GetExternalLink(GetJisiluDataUrl().'etf/#tlink_1', '集思录');
}

function GetJisiluQdiiLink($bAsia = false)
{
	$strUrl = GetJisiluDataUrl().'qdii/';
	if ($bAsia)	$strUrl .= '#qdiia';
	return GetExternalLink($strUrl, '集思录');
}

function GetEtfNavLink($sym)
{
	if ($strUrl = GetEtfNavUrl($sym))
	{
		return GetExternalLink($strUrl, '净值文件');
	}
	return '';
}

function GetUscfLink()
{
	return GetOfficialLink('http://www.uscfinvestments.com', 'USO'); 
}

?>
