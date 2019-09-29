<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoFundHistoryGraph($strSymbol)
{
   	$csv = new PageCsvFile();
    $jpg = new DateImageFile();
    $ar = $csv->ReadColumn(2);
   	if (count($ar) > 0)
   	{
   		$jpg->DrawDateArray($ar);
   		$jpg->DrawCompareArray($csv->ReadColumn(1));
   		$jpg->Show(STOCK_DISP_PREMIUM, $strSymbol, $csv->GetLink());
   	}
}

function _echoFundHistory($strSymbol, $iStart, $iNum)
{
    $str = GetStockHistoryLink($strSymbol);
    if (in_arrayLof($strSymbol))
    {
    	$str .= ' '.GetNetValueHistoryLink($strSymbol);
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
    
    _echoFundHistoryGraph($strSymbol);
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$iStart = UrlGetQueryInt('start');
   		$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
   		_echoFundHistory($ref->GetStockSymbol(), $iStart, $iNum);
    }
    $acct->EchoLinks();
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_HISTORY_DISPLAY;
    $str .= '页面. 用于某基金历史交易超过一定数量后的显示. 最近的基金交易记录一般会直接显示在该基金页面. 目前仅用于华宝油气(SZ162411)等LOF基金.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().FUND_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAcctStart();

?>

