<?php
require_once('debug.php');
require_once('stock/stocksymbol.php');
require_once('stock/googlestock.php');

// ****************************** External link functions *******************************************************

function GetChinaFundLink($sym)
{
    $strSymbol = $sym->strSymbol;
    if ($sym->IsFundA())
    {
        $strHttp = 'http://fund.eastmoney.com/'.$sym->strDigitA.'.html';
        return DebugGetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

function GetXueQiuLink($strSymbol)
{
    $strHttp = "https://xueqiu.com/S/$strSymbol";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

function GetYahooStockLink($strYahooSymbol, $strSymbol)
{
    $strHttp = "http://finance.yahoo.com/q?s=$strYahooSymbol";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

function GetYahooStockHistoryLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    $strYahooSymbol = $sym->GetYahooSymbol();
    $strHttp = YAHOO_HISTORY_QUOTES_URL.$strYahooSymbol.'/history';
    return DebugGetExternalLink($strHttp, $strSymbol);
}

function GetGoogleStockLink($strGoogleSymbol, $strSymbol)
{
    $strHttp = GOOGLE_QUOTES_URL.$strGoogleSymbol;
    return DebugGetExternalLink($strHttp, $strSymbol);
}

// http://finance.sina.com.cn/realstock/company/sh600028/nc.shtml
function GetSinaStockLink($strSymbol)
{
    $strLower = strtolower($strSymbol);
    $strHttp = "http://finance.sina.com.cn/realstock/company/$strLower/nc.shtml";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

// http://stock.finance.sina.com.cn/usstock/quotes/SNP.html
function GetSinaUsStockLink($sym)
{
    $strSymbol = $sym->strSymbol;
    if ($sym->IsIndex())
    {
		$str = '.'.strtoupper($sym->GetSinaIndexUS());
	}
    else 
    {
        $str = $strSymbol;
    }
    $strHttp = "http://stock.finance.sina.com.cn/usstock/quotes/$str.html";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

// http://stock.finance.sina.com.cn/hkstock/quotes/00386.html
function GetSinaHkStockLink($sym)
{
    $strSymbol = $sym->strSymbol;
    if ($sym->IsIndex())
    {
		$str = $sym->GetSinaIndexH();
	}
    else 
    {
        $str = $strSymbol;
    }
    $strHttp = "http://stock.finance.sina.com.cn/hkstock/quotes/$str.html";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

// http://finance.sina.com.cn/fund/quotes/162411/bc.shtml
function GetSinaFundLink($sym)
{
    $strSymbol = $sym->strSymbol;
    if ($sym->IsFundA())
    {
        $strHttp = 'http://finance.sina.com.cn/fund/quotes/'.$sym->strDigitA.'/bc.shtml';
        return DebugGetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

// http://finance.sina.com.cn/futures/quotes/CL.shtml
function GetSinaFutureLink($strSymbol)
{
    $strHttp = "http://finance.sina.com.cn/futures/quotes/$strSymbol.shtml";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

// http://finance.sina.com.cn/money/forex/hq/USDCNY.shtml
function GetSinaForexLink($strSymbol)
{
    $strHttp = "http://finance.sina.com.cn/money/forex/hq/$strSymbol.shtml";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

// http://vip.stock.finance.sina.com.cn/q/go.php/vDYData/kind/znzd/index.phtml?symbol=600028
function GetSinaN8n8Link($sym)
{
    $strSymbol = $sym->strSymbol;
    if ($sym->IsSymbolA())
    {
        $strHttp = 'http://vip.stock.finance.sina.com.cn/q/go.php/vDYData/kind/znzd/index.phtml?symbol='.$sym->strDigitA;
        return DebugGetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

// https://www.jisilu.cn/data/ha_history/600585
function GetJisiluAHLink($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsSymbolA())
    {
        $strHttp = 'https://www.jisilu.cn/data/ha_history/'.$sym->strDigitA;
        return DebugGetExternalLink($strHttp, $strSymbol);
    }
    return $strSymbol;
}

// https://www.jisilu.cn/data/sfnew/detail/502004
function EchoJisiluGradedFund()
{
    $strSymbol = UrlGetTitle();
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        $strHttp = 'https://www.jisilu.cn/data/sfnew/detail/'.$sym->strDigitA;
        $str = DebugGetExternalLink($strHttp, '集思录');
        echo $str;
    }
}

// http://quote.eastmoney.com/forex/USDCNY.html
function GetEastMoneyForexLink($strSymbol)
{
    $strHttp = "http://quote.eastmoney.com/forex/$strSymbol.html";
    return DebugGetExternalLink($strHttp, $strSymbol);
}

function GetReferenceRateForexLink($strSymbol)
{
    $strHttp = 'http://www.chinamoney.com.cn/index.html';
    return DebugGetExternalLink($strHttp, $strSymbol);
}

?>
