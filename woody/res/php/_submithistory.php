<?php
require_once('_stock.php');
require_once('_emptygroup.php');
//require_once('_spdrnavxls.php');
require_once('_yahoohistorycsv.php');

    $acct = new SymbolAccount();
	if ($acct->IsAdmin())
	{
	    if ($ref = $acct->GetRef())
	    {
			YahooUpdateStockHistory($ref);
	        
	        // do some extra work together
//	        if ($ref->GetSymbol() == '^GSPC')		DebugNavXlsStr(new StockSymbol('SPY'));
//	        else									DebugNavXlsStr($ref);
	    }
	}
	$acct->Back();
	
?>
