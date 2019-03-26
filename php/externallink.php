<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('stock/stocksymbol.php');
require_once('stock/googlestock.php');

// ****************************** External link functions *******************************************************
function GetEastMoneyFundLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsFundA())
    {
        $strHttp = "http://fund.eastmoney.com/$strDigit.html";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetEastMoneyFundRatioLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsFundA())
    {
        $strHttp = "http://fund.eastmoney.com/f10/zcpz_$strDigit.html";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetXueQiuLink($sym)
{
    $strSymbol = $sym->GetSymbol();
	$strXueQiu = $strSymbol;
    if ($sym->IsIndex())
    {
    	switch ($strSymbol)
    	{
    	case '^GSPC':
			$strXueQiu = '.INX';
			break;
			
		case '^HSI':
			$strXueQiu = 'HKHSI';
			break;
			
		case '^HSCE':
			$strXueQiu = 'HKHSCEI';
			break;
		}
	}
    $strHttp = 'https://xueqiu.com/S/'.$strXueQiu;
    return GetExternalLink($strHttp, $strSymbol);
}

function GetYahooStockLink($sym)
{
    $strHttp = YahooStockGetUrl($sym->GetYahooSymbol());
    return GetExternalLink($strHttp, $sym->GetSymbol());
}

function GetGoogleStockLink($sym)
{
    $strHttp = GOOGLE_QUOTES_URL.$sym->GetGoogleSymbol();
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

// http://finance.sina.com.cn/realstock/company/sh600028/nc.shtml
function GetSinaCnStockLink($strSymbol)
{
    $strLower = strtolower($strSymbol);
    $strHttp = "http://finance.sina.com.cn/realstock/company/$strLower/nc.shtml";
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

// http://finance.sina.com.cn/futures/quotes/CL.shtml
function GetSinaFutureLink($strSymbol)
{
    $strHttp = "http://finance.sina.com.cn/futures/quotes/$strSymbol.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

// http://finance.sina.com.cn/money/forex/hq/USDCNY.shtml
function GetSinaForexLink($strSymbol)
{
    $strHttp = "http://finance.sina.com.cn/money/forex/hq/$strSymbol.shtml";
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

// https://www.jisilu.cn/data/sfnew/detail/502004
function EchoJisiluGradedFund()
{
    $strSymbol = UrlGetTitle();
    $sym = new StockSymbol($strSymbol);
    if ($strDigit = $sym->IsFundA())
    {
        $strHttp = "https://www.jisilu.cn/data/sfnew/detail/$strDigit";
        $str = GetExternalLink($strHttp, '集思录');
        echo $str;
    }
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

// https://mp.weixin.qq.com/
function GetWeixinLink($bChinese = true)
{
    $strHttp = 'https://mp.weixin.qq.com';
    return GetExternalLink($strHttp, ($bChinese ? '微信公众平台' : 'Wechat Public Platform'));
}

?>
