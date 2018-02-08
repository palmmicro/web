<?php
require_once('_stock.php');

function _echoThanousLawLink($strSymbol, $bChinese)
{
    $strThanousLaw = UrlBuildPhpLink(STOCK_PATH.'thanouslaw', 'symbol='.$strSymbol, '测试小心愿定律', 'Test Thanous Law', $bChinese);
    EchoParagraph($strThanousLaw);
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
    $strGroupLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    EchoParagraph($strGroupLink.$strNavLink);
    
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
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
        $iStart = UrlGetQueryInt('start', 0);
        $iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
        _echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese);
    }
    EchoPromotionHead('netvalue', $bChinese);
}

function EchoTitle($bChinese)
{
  	$str = UrlGetQueryDisplay('symbol', '');
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

?>

