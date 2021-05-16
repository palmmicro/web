<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/dateimagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoFundHistory($strSymbol, $iStart, $iNum)
{
    $str = GetStockHistoryLink($strSymbol);
   	$str .= ' '.GetNetValueHistoryLink($strSymbol);
    if (in_arrayQdii($strSymbol))
    {
    	$str .= ' '.GetQdiiAnalysisLinks($strSymbol);
    }
   	EchoParagraph($str);
  
   	$csv = new PageCsvFile();
   	$sym = new StockSymbol($strSymbol);
   	if ($ref = StockGetEtfReference($strSymbol))
   	{
   		EchoEtfHistoryParagraph($ref, $csv, $iStart, $iNum);
   	}
   	else if ($sym->IsFundA())
   	{
   		$fund = StockGetFundReference($strSymbol);
   		EchoFundHistoryParagraph($fund, $csv, $iStart, $iNum);
   	}
    $csv->Close();
    
    if ($csv->HasFile())
    {
    	$jpg = new DateImageFile();
   		if ($jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1)))
   		{
   			EchoParagraph($csv->GetLink().'<br />'.$jpg->GetAll(STOCK_DISP_PREMIUM, $strSymbol));
   		}
   	}
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		_echoFundHistory($ref->GetSymbol(), $acct->GetStart(), $acct->GetNum());
    }
    $acct->EchoLinks(FUND_HISTORY_PAGE);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().FUND_HISTORY_DISPLAY;
    $str .= '页面. 用于某基金历史交易超过一定数量后的显示. 最近的基金交易记录一般会直接显示在该基金页面. 目前仅用于华宝油气(SZ162411)等QDII基金.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().FUND_HISTORY_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>

