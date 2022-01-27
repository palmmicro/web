<?php
require_once('_stock.php');
require_once('_emptygroup.php');
//require_once('_spdrnavxls.php');
require_once('/php/stockhis.php');
require_once('/php/stock/updatestockhistory.php');

// https://query1.finance.yahoo.com/v7/finance/download/KWEB?period1=1611673365&period2=1643209365&interval=1d&events=history&includeAdjustedClose=true
function YahooUpdateStockHistory($sym, $strStockId)
{
	StockSaveHistoryCsv('KWEB', 'https://query1.finance.yahoo.com/v7/finance/download/KWEB?period1=1611673365&period2=1643209365&interval=1d&events=history&includeAdjustedClose=true');
}

    $acct = new SymbolAccount();
	if ($acct->IsAdmin())
	{
		$acct->Create();
	    if ($ref = $acct->GetRef())
	    {
	        UpdateStockHistory($ref, $ref->GetStockId());
//			YahooUpdateStockHistory($ref, $ref->GetStockId());
	        
	        // do some extra work together
//	        if ($ref->GetSymbol() == '^GSPC')		DebugNavXlsStr(new StockSymbol('SPY'));
//	        else									DebugNavXlsStr($ref);
	    }
	}
	$acct->Back();
	
?>
