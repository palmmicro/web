<?php
require_once('_stock.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoThanousLawLink($strSymbol, $bChinese)
{
    $strThanousLaw = UrlBuildPhpLink(STOCK_PATH.'thanouslaw', 'symbol='.$strSymbol, '测试小心愿定律', 'Test Thanous Law', $bChinese);
    EchoParagraph($strThanousLaw);
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
        EchoFundHistoryParagraph($fund, $iStart, $iNum, $bChinese);
    }
    else if (in_arrayLofHk($strSymbol))
    {
        PrefetchStockData(LofHkGetAllSymbolArray($strSymbol));
        $fund = new MyLofHkReference($strSymbol);
        EchoFundHistoryParagraph($fund, $iStart, $iNum, $bChinese);
    }
    else if (in_arrayGoldEtf($strSymbol))
    {
        EchoFundHistoryParagraph(new MyFundReference($strSymbol), $iStart, $iNum, $bChinese);
    }
    else if (in_arrayGradedFund($strSymbol))
    {
        EchoFundHistoryParagraph(new MyFundReference($strSymbol), $iStart, $iNum, $bChinese);
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

