<?php
//require_once('url.php');
//require_once('debug.php');
require_once('httplink.php');
require_once('stock/stocksymbol.php');
require_once('stock/googlestock.php');

// ****************************** External link functions *******************************************************

function GetChinaFundLink($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsFundA())
    {
        $strHttp = "http://fund.eastmoney.com/$strDigit.html";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetXueQiuLink($strSymbol)
{
	if ($strSymbol == '^GSPC')
	{
		$strXueQiuSymbol = '.INX';
	}
	else
	{
		$strXueQiuSymbol = $strSymbol;
	}
    $strHttp = 'https://xueqiu.com/S/'.$strXueQiuSymbol;
    return GetExternalLink($strHttp, $strSymbol);
}

function GetYahooStockLink($strYahooSymbol, $strSymbol)
{
    $strHttp = YahooStockGetUrl($strYahooSymbol);
    return GetExternalLink($strHttp, $strSymbol);
}

function GetYahooStockHistoryLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $strYahooSymbol = $sym->GetYahooSymbol();
    $strHttp = YAHOO_HISTORY_QUOTES_URL.$strYahooSymbol.'/history';
    return GetExternalLink($strHttp, $strSymbol);
}

function GetGoogleStockLink($strGoogleSymbol, $strSymbol)
{
    $strHttp = GOOGLE_QUOTES_URL.$strGoogleSymbol;
    return GetExternalLink($strHttp, $strSymbol);
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
function GetSinaStockLink($strSymbol)
{
    $strLower = strtolower($strSymbol);
    $strHttp = "http://finance.sina.com.cn/realstock/company/$strLower/nc.shtml";
    return GetExternalLink($strHttp, $strSymbol);
}

function GetSinaCnLink($sym)
{
    if ($sym->IsFundA())
    {
		return GetSinaFundLink($sym);
    }
	return GetSinaStockLink($sym->GetSymbol());
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

// http://vip.stock.finance.sina.com.cn/q/go.php/vDYData/kind/znzd/index.phtml?symbol=600028
function GetSinaN8n8Link($sym)
{
    $strSymbol = $sym->GetSymbol();
    if ($strDigit = $sym->IsSymbolA())
    {
        $strHttp = "http://vip.stock.finance.sina.com.cn/q/go.php/vDYData/kind/znzd/index.phtml?symbol=$strDigit";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

// https://www.jisilu.cn/data/ha_history/600585
function GetJisiluAhLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($strDigit = $sym->IsSymbolA())
    {
        $strHttp = "https://www.jisilu.cn/data/ha_history/$strDigit";
        return GetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
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

function GetAdrLink($strSymbol)
{
    $strHttp = 'http://www.aastocks.com/tc/market/adr.aspx';
    return GetExternalLink($strHttp, $strSymbol);
}

?>
