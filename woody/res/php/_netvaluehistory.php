<?php
require_once('_stock.php');
require_once('_emptygroup.php');
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
   		$jpg->Show(STOCK_DISP_PREMIUM, $strSymbol, $csv->GetLink());
   	}
}

function _echoNetValueHistory($strSymbol, $iStart, $iNum)
{
    $str = GetStockHistoryLink($strSymbol);
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetThanousLawLink($strSymbol);
    	$str .= ' '.GetFundAccountLink($strSymbol);
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
	global $group;
	
    if ($ref = $group->EchoStockGroup())
    {
   		$iStart = UrlGetQueryInt('start');
   		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		_echoNetValueHistory($ref->GetStockSymbol(), $iStart, $iNum);
    }
    $group->EchoLinks('netvalue');
}

function EchoMetaDescription()
{
	global $group;
	
  	$str = $group->GetStockDisplay().NETVALUE_HISTORY_DISPLAY;
    $str .= '页面. 用于某基金历史净值超过一定数量后的显示. 最近的基金净值记录一般会直接显示在该基金页面. 目前仅用于华宝油气(SZ162411)等LOF基金.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $group;
	
  	$str = $group->GetSymbolDisplay().NETVALUE_HISTORY_DISPLAY;
  	echo $str;
}

    $group = new StockSymbolPage();

?>

