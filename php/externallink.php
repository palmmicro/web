<?php
//require_once('url.php');
//require_once('debug.php');
require_once('externalurl.php');
require_once('httplink.php');
require_once('stock/stocksymbol.php');

// ****************************** External link functions *******************************************************
function GetOfficialLink($strHttp, $strDisplay)
{
    return GetExternalLink($strHttp, $strDisplay.'官网');
}

function GetEFundOfficialLink($strDigitA)
{
    return GetOfficialLink(GetEFundUrl().'/html/fund/'.$strDigitA.'_fundinfo.htm', $strDigitA);
}

function GetGuoTaiOfficialLink($strDigitA)
{
    return GetOfficialLink(GetGuoTaiFundUrl().'/Etrade/Jijin/view/id/'.$strDigitA, $strDigitA);
}

function GetBoShiOfficialLink($strDigitA)
{
    return GetOfficialLink(GetBoShiFundUrl().'/fund/'.$strDigitA.'.html', $strDigitA);
}

function GetHuaBaoOfficialLink($strDigitA)
{
    return GetOfficialLink(GetHuaBaoFundUrl().'/funds/'.$strDigitA.'/index.shtml', $strDigitA);
}

function GetJiaShiOfficialLink($strDigitA)
{
    return GetOfficialLink(GetJiaShiFundUrl().'/Services/cn/html/product/index.shtml?fundcode='.$strDigitA, $strDigitA);
}

function GetXinChengOfficialLink($strDigitA)
{
    return GetOfficialLink(GetXinChengFundUrl().'/pc/productDetail?fundcode='.$strDigitA, $strDigitA);
}

function GetYinHuaOfficialLink($strDigitA)
{
    return GetOfficialLink(GetYinHuaFundUrl().'/main/qxjj/'.$strDigitA.'/fndFacts.shtml', $strDigitA);
}

function GetOfficialLinkGSG()
{
	return GetOfficialLink('https://www.ishares.com/us/products/239757/GSG', 'GSG');
}

function GetShangHaiEtfOfficialLink()
{
    return GetExternalLink('http://www.sse.com.cn/market/funddata/volumn/etfvolumn/', '上交所官网ETF规模数据');
}

function GetShangHaiLofOfficialLink()
{
    return GetExternalLink('http://www.sse.com.cn/assortment/fund/lof/scale/', '上交所官网LOF规模数据');
}

function GetShenZhenLofOfficialLink()
{
    return GetExternalLink('http://www.szse.cn/market/fund/list/lofFundList/index.html', '深交所官网LOF数据');
}

function GetEastMoneyGlobalFuturesLink()
{
    return GetExternalLink('http://quote.eastmoney.com/center/gridlist.html#futures_global', '东方财富外盘期货汇总');
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

function GetEastMoneyFundRatioLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsFundA())
    {
        $strHttp = GetEastMoneyFundUrl()."f10/zcpz_$strDigit.html";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetEastMoneyQdiiLink()
{
    return GetExternalLink(GetEastMoneyFundUrl().'/QDII_jzzzl.html', '东方财富QDII汇总');
}

function GetXueqiuLink($sym)
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
		}
	}
    $strHttp = GetXueqiuUrl().'S/'.$strXueqiu;
    return GetExternalLink($strHttp, $strSymbol);
}

function GetXueqiuIdLink($strId, $strDisplay)
{
    return GetExternalLink(GetXueqiuUrl().'u/'.$strId, $strDisplay);
}

function GetYahooStockLink($sym)
{
    $strHttp = YahooStockGetUrl($sym->GetYahooSymbol());
    return GetExternalLink($strHttp, $sym->GetSymbol());
}

// http://finance.sina.com.cn/fund/quotes/162411/bc.shtml
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
        $strHttp = "http://finance.sina.com.cn/fund/quotes/$strDigit/bc.shtml";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetSinaCnStockLink($strSymbol)
{
    $strLower = strtolower($strSymbol);
    $strHttp = GetSinaFinanceUrl()."realstock/company/$strLower/nc.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

// http://stock.finance.sina.com.cn/usstock/quotes/SNP.html
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
    $strHttp = "http://stock.finance.sina.com.cn/usstock/quotes/$str.html";
    return GetExternalLink($strHttp, $strSymbol);
}

// http://stock.finance.sina.com.cn/hkstock/quotes/00386.html
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
    $strHttp = "http://stock.finance.sina.com.cn/hkstock/quotes/$str.html";
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
    $strHttp = GetSinaFinanceUrl()."futures/quotes/$strSymbol.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaForexLink($sym)
{
	if ($str = $sym->IsNewSinaForex())
	{
		$strSymbol = strtoupper($str);
	}
	else
	{
		$strSymbol = $sym->GetSymbol();
	}
    $strHttp = GetSinaFinanceUrl()."money/forex/hq/$strSymbol.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetExternalStockHistoryLink($sym)
{
	if ($sym->IsIndexA())
	{
		$strHttp = SinaGetStockHistoryUrl($sym);
	}
	else
	{
		$strHttp = YahooStockHistoryGetUrl($sym->GetYahooSymbol());
	}
    return GetExternalLink($strHttp, '历史数据');
}

// http://vip.stock.finance.sina.com.cn/corp/go.php/vISSUE_ShareBonus/stockid/000028.phtml
// http://stock.finance.sina.com.cn/hkstock/dividends/00386.html
// https://finance.yahoo.com/quote/XOP/history?filter=div
function GetStockDividendUrl($sym)
{
   	$strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsSymbolA())
    {
    	return "http://vip.stock.finance.sina.com.cn/corp/go.php/vISSUE_ShareBonus/stockid/$strDigit.phtml";
    }
    else if ($sym->IsSymbolH())
    {
    	return "http://stock.finance.sina.com.cn/hkstock/dividends/$strSymbol.html";
    }
    return YahooStockHistoryGetUrl($strSymbol).'?filter=div';
}

function GetStockDividendLink($sym)
{
    $strHttp = GetStockDividendUrl($sym);
    return GetExternalLink($strHttp, '分红数据');
}

// http://quote.eastmoney.com/forex/USDCNY.html
function GetEastMoneyForexLink($strSymbol)
{
    $strHttp = "http://quote.eastmoney.com/forex/$strSymbol.html";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetReferenceRateForexLink($strSymbol)
{
    $strHttp = 'http://www.chinamoney.com.cn/index.html';
    return GetExternalLink($strHttp, $strSymbol);
}

function GetTradingViewLink($strSymbol)
{
    $strHttp = 'https://www.tradingview.com/symbols/AMEX-'.$strSymbol;
    return GetExternalLink($strHttp, $strSymbol);
}

// http://stockcharts.com/h-sc/ui?s=XOP&p=D&b=5&g=0&id=p39648755011
function GetStockChartsLink($strSymbol)
{
	if ($strSymbol == '^GSPC')	$str = '$SPX';
	else							$str = $strSymbol;
    $strHttp = 'http://stockcharts.com/h-sc/ui?s='.$str.'&p=D&b=5&g=0&id=p39648755011';
    return GetExternalLink($strHttp, $strSymbol);
}

function GetWeixinLink($bChinese = true)
{
    $strHttp = 'https://mp.weixin.qq.com';
    return GetExternalLink($strHttp, ($bChinese ? '微信公众平台' : 'Wechat Public Platform'));
}

function GetAastocksLink($strType = 'adr')
{
	return GetExternalLink(GetAastocksUrl($strType), '阿思達克');
}

function GetJisiluGoldLink()
{
	return GetExternalLink(GetJisiluDataUrl().'etf/#tlink_1', '集思录');
}

function GetJisiluLofHkLink()
{
	return GetExternalLink(GetJisiluDataUrl().'lof/#index', '集思录');
}

function GetJisiluLofLink()
{
	return GetExternalLink(GetJisiluDataUrl().'qdii/', '集思录');
}

function GetSpdrNavLink($strSymbol)
{
	if ($strUrl = GetSpdrNavUrl($strSymbol))
	{
		return GetExternalLink($strUrl, 'SPDR净值文件');
	}
	return '';
}

function GetMacroTrendsGoldOilRatioLink()
{
	return GetExternalLink(GetMacroTrendsUrl().'/1380/gold-to-oil-ratio-historical-chart', '金油比');
}

function GetMacroTrendsFutureLink($str)
{
	return GetExternalLink(GetMacroTrendsUrl().'/futures/'.$str, $str.'期货');
}

function GetDailyFxCrudeOilLink()
{
	return GetExternalLink('https://www.dailyfx.com/crude-oil', '原油期货');
}

function GetBuffettIndicatorLink()
{
	return GetExternalLink('https://www.longtermtrends.net/market-cap-to-gdp/', '巴菲特指标');
}

function GetCmeCrudeOilLink()
{
	return GetOfficialLink(GetCmeTradingUrl().'energy/crude-oil/light-sweet-crude.html', '芝商所CL');
}

function GetCmeEquityIndexLink()
{
	return GetOfficialLink(GetCmeTradingUrl().'equity-index/', '芝商所股指期货'); 
}

function GetUscfLink()
{
	return GetOfficialLink('http://www.uscfinvestments.com', 'USO/USL/BNO'); 
}

?>
