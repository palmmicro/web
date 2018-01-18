<?php
require_once('_stock.php');

function _echoThanousLawLink($strSymbol, $bChinese)
{
    $strGroupLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    $strThanousLaw = UrlBuildPhpLink(STOCK_PATH.'thanouslaw', 'symbol='.$strSymbol, '测试小心愿定律', 'Test Thanous Law', $bChinese);
    EchoParagraph($strGroupLink.' '.$strThanousLaw);
}

function _getStockHistory($ref)
{
    if ($ref)
    {
        $his = new StockHistory($ref);
        return $his;
    }        
    return false;
}

function _echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese)
{
    $strStockId = SqlGetStockId($strSymbol);
    $iTotal = SqlCountFundHistory($strStockId);
    $strNavLink = _GetStockNavLink('netvaluehistory', $strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    EchoParagraph($strNavLink);
    
    if (in_arrayLof($strSymbol))
    {
        PrefetchStockData(LofGetAllSymbolArray($strSymbol));
        $fund = new MyLofReference($strSymbol);
        _echoThanousLawLink($strSymbol, $bChinese);
        _EchoHistoryParagraph($fund, false, _getStockHistory($fund->etf_ref), $iStart, $iNum, $bChinese);
    }
    else if (in_arrayLofHk($strSymbol))
    {
        PrefetchStockData(LofHkGetAllSymbolArray($strSymbol));
        $fund = new MyLofHkReference($strSymbol);
        _EchoHistoryParagraph($fund, true, _getStockHistory($fund->etf_ref), $iStart, $iNum, $bChinese);
    }
    else if (in_arrayGoldEtf($strSymbol))
    {
        _EchoHistoryParagraph(new MyFundReference($strSymbol), true, false, $iStart, $iNum, $bChinese);
    }
    else if (in_arrayGradedFund($strSymbol))
    {
        _EchoHistoryParagraph(new MyFundReference($strSymbol), true, false, $iStart, $iNum, $bChinese);
    }
}

function EchoNetValueHistory($bChinese)
{
    global $g_strSymbol;
    
    if ($g_strSymbol)
    {
        $iStart = UrlGetQueryInt('start', 0);
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        _echoNetValueHistory($g_strSymbol, $iStart, $iNum, $bChinese);
    }
    EchoPromotionHead('netvalue', $bChinese);
}

function EchoTitle($bChinese)
{
    global $g_strSymbol;
    
    $str = $g_strSymbol; 
    if ($bChinese)
    {
        $str .= '净值历史记录';
    }
    else
    {
        $str .= ' Net Value History';
    }
    echo $str;
}

    AcctAuth();
    $g_strSymbol = UrlGetQueryValue('symbol');

?>

