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
   		$jpg->DrawDateArray($ar);
   		$jpg->DrawSecondArray($csv->ReadColumn(1));
   		$jpg->SaveFile();
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
    
    StockPrefetchData($strSymbol);
   	$csv = new PageCsvFile();
   	$sym = new StockSymbol($strSymbol);
   	if ($sym->IsFundA())
   	{
   		$fund = StockGetFundReference($strSymbol);
   		EchoFundHistoryParagraph($fund, $bChinese, $csv, $iStart, $iNum);
   	}
   	else if ($ref = StockGetEtfReference($strSymbol))
   	{
   		EchoEtfHistoryParagraph($ref, $bChinese, $csv, $iStart, $iNum);
   	}
    
    _echoNetValueHistoryGraph($strSymbol, $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
   		$iStart = UrlGetQueryInt('start');
   		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		_echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese);
    }
    EchoPromotionHead($bChinese, 'netvalue');
    EchoStockCategory($bChinese);
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '净值历史记录' : ' Net Value History');
}

    AcctAuth();

?>

