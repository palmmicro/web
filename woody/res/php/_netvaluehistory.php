<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoNetValueHistoryGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $ar = $csv->ReadColumn(2);
   	if (count($ar) > 0)
   	{
   		$jpg->DrawDateArray($ar);
   		$jpg->DrawCompareArray($csv->ReadColumn(1));
   		$jpg->Show(STOCK_DISP_PREMIUM, $strSymbol, $csv->GetPathName());
   	}
}

function _echoNetValueHistory($strSymbol, $iStart, $iNum)
{
    $str = '';
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetThanousLawLink($strSymbol);
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
    
    _echoNetValueHistoryGraph($strSymbol);
}

function EchoAll()
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	StockPrefetchData($strSymbol);
   		EchoStockGroupParagraph();	

   		$iStart = UrlGetQueryInt('start');
   		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		_echoNetValueHistory($strSymbol, $iStart, $iNum);
    }
    EchoPromotionHead('netvalue');
    EchoStockCategory();
}

function EchoMetaDescription()
{
    $str = UrlGetQueryDisplay('symbol');
    $str .= '净值历史记录页面. 用于某基金历史净值超过一定数量后的显示. 最近的基金净值记录一般会直接显示在该基金页面. 目前仅用于华宝油气(SZ162411)等LOF基金.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
  	echo UrlGetQueryDisplay('symbol').NETVALUE_HISTORY_DISPLAY;
}

    AcctAuth();

?>

