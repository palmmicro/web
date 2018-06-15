<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoNetValueHistoryGraph($strSymbol, $bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $ar = $csv->ReadColumn(2);
   	if (count($ar) > 0)
   	{
   		$jpg->DrawDateArray($ar, $csv->ReadColumn(1));
   		$strPremium = $bChinese ? '溢价' : 'Premium';
   		EchoPageImage($strPremium, $strSymbol, $csv->GetPathName(), $jpg->GetPathName());
   	}
}

function _echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese)
{
    $str = _GetReturnSymbolGroupLink($strSymbol, $bChinese); 
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetStockSymbolLink('thanouslaw', $strSymbol, $bChinese, '测试小心愿定律', 'Test Thanous Law');
    }
   	EchoParagraph($str);
    
    StockPrefetchData(array($strSymbol));
    $fund = StockGetFundReference($strSymbol);
   	$csv = new PageCsvFile();
    EchoFundHistoryParagraph($fund, $bChinese, $csv, $iStart, $iNum);
    
    _echoNetValueHistoryGraph($strSymbol, $bChinese);
}

function EchoNetValueHistory($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	$sym = new StockSymbol($strSymbol);
    	if ($sym->IsFundA())
    	{
    		$iStart = UrlGetQueryInt('start');
    		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    		_echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese);
    	}
    }
    EchoPromotionHead($bChinese, 'netvalue');
}

function EchoTitle($bChinese = true)
{
  	$str = UrlGetQueryDisplay('symbol');
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

