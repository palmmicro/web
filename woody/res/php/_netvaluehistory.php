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
   		$jpg->DrawCompareArray($csv->ReadColumn(1));
   		$strPremium = $bChinese ? '溢价' : 'Premium';
   		$jpg->Show($strPremium, $strSymbol, $csv->GetPathName());
   	}
}

function _echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese)
{
    $str = '';
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetStockSymbolLink('thanouslaw', $strSymbol, '测试小心愿定律');
    }
   	EchoParagraph($str);
  
   	$csv = new PageCsvFile();
   	$sym = new StockSymbol($strSymbol);
   	if ($sym->IsFundA())
   	{
   		$fund = StockGetFundReference($strSymbol);
   		EchoFundHistoryParagraph($fund, $csv, $iStart, $iNum);
   	}
   	else if ($ref = StockGetEtfReference($strSymbol))
   	{
   		EchoEtfHistoryParagraph($ref, $csv, $iStart, $iNum);
   	}
    
    _echoNetValueHistoryGraph($strSymbol, $bChinese);
}

function EchoAll($bChinese = true)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();	

   		$iStart = UrlGetQueryInt('start');
   		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		_echoNetValueHistory($strSymbol, $iStart, $iNum, $bChinese);
    }
    EchoPromotionHead('netvalue');
    EchoStockCategory();
}

function EchoTitle($bChinese = true)
{
  	echo UrlGetQueryDisplay('symbol').($bChinese ? '净值历史记录' : ' Net Value History');
}

    AcctAuth();

?>

