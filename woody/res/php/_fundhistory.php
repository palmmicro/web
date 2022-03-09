<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/dateimagefile.php');
require_once('/php/ui/fundhistoryparagraph.php');

function _echoFundHistory($strSymbol, $iStart, $iNum, $bAdmin)
{
    $str = GetFundLinks($strSymbol);
    if (in_arrayQdii($strSymbol))				$str .= ' '.GetQdiiAnalysisLinks($strSymbol);
    else if (in_arrayQdiiMix($strSymbol))	$str .= ' '.GetFundAccountLink($strSymbol);
    if ($bAdmin)								$str .= '<br />'.StockGetAllLink($strSymbol);
   	EchoParagraph($str);
  
   	$csv = new PageCsvFile();
   	$sym = new StockSymbol($strSymbol);
   	if ($sym->IsFundA())
   	{
   		$fund = StockGetFundReference($strSymbol);
   		EchoFundHistoryParagraph($fund, $csv, $iStart, $iNum, $bAdmin);
   	}
   	else
   	{
   		if (($ref = StockGetEtfReference($strSymbol)) === false)		$ref = StockGetHoldingsReference($strSymbol);
 		if ($ref)	EchoEtfHistoryParagraph($ref, $csv, $iStart, $iNum, $bAdmin);
   	}
    $csv->Close();
    
    if ($csv->HasFile())
    {
    	$jpg = new DateImageFile();
   		if ($jpg->Draw($csv->ReadColumn(2), $csv->ReadColumn(1)))		EchoParagraph($csv->GetLink().'<br />'.$jpg->GetAll(STOCK_DISP_PREMIUM, $strSymbol));
   	}
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())		_echoFundHistory($ref->GetSymbol(), $acct->GetStart(), $acct->GetNum(), $acct->IsAdmin());
    $acct->EchoLinks('fundhistory');
}

function GetMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetMetaDisplay(FUND_HISTORY_DISPLAY);
    $str .= '页面。用于某基金历史交易超过一定数量后的显示。最近的基金交易记录一般会直接显示在该基金页面。';
    return CheckMetaDescription($str);
}

function GetTitle()
{
	global $acct;
	return $acct->GetTitleDisplay(FUND_HISTORY_DISPLAY);
}

    $acct = new SymbolAccount();
?>

