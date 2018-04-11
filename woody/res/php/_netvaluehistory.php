<?php
require_once('_stock.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese)
{
    if (in_arrayLof($strSymbol))
    {
    	$strThanousLaw = UrlBuildPhpLink(STOCK_PATH.'thanouslaw', 'symbol='.$strSymbol, '测试小心愿定律', 'Test Thanous Law', $bChinese);
    	EchoParagraph($strThanousLaw);
    }
    
    $strStockId = SqlGetStockId($strSymbol);
    $iTotal = SqlCountFundHistory($strStockId);
    $strNavLink = _GetStockNavLink($strSymbol, $iTotal, $iStart, $iNum, $bChinese);
    $strGroupLink = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    EchoParagraph($strGroupLink.$strNavLink);
    
    MyStockPrefetchData(array($strSymbol));
    $fund = MyStockGetFundReference($strSymbol);
    EchoFundHistoryFullParagraph($fund, $iStart, $iNum, $bChinese);
}

function EchoNetValueHistory($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$sym = new StockSymbol($strSymbol);
    	if ($sym->IsFundA())
    	{
    		$iStart = UrlGetQueryInt('start', 0);
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		_echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese);
    	}
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

