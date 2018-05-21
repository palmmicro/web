<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoNetValueHistoryGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(2), $csv->ReadColumn(1));
	$strPremium = $bChinese ? '溢价' : 'Premium';
    EchoPageImage($strPremium, $strSymbol, $csv->GetPathName(), $jpg->GetPathName());
}

function _echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese)
{
    $str = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.BuildPhpLink(STOCK_PATH.'thanouslaw', 'symbol='.$strSymbol, '测试小心愿定律', 'Test Thanous Law', $bChinese);
    }
   	EchoParagraph($str);
    
    StockPrefetchData(array($strSymbol));
    $fund = StockGetFundReference($strSymbol);
   	$csv = new PageCsvFile();
    EchoFundHistoryFullParagraph($fund, $csv, $iStart, $iNum, $bChinese);
    
    _echoNetValueHistoryGraph($strSymbol, $bChinese);
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

