<?php
require_once('_stock.php');
require_once('_emptygroup.php');
//require_once('_spdrnavxls.php');
require_once('_yahoohistorycsv.php');

class _AdminHistoryAccount extends SymbolAccount
{
    public function AdminProcess()
    {
	    if ($ref = $this->GetSymbolRef())
	    {
			YahooUpdateStockHistory($ref);
	        
	        // do some extra work together
//	        if ($ref->GetSymbol() == '^GSPC')		DebugNavXlsStr(new StockSymbol('SPY'));
//	        else									DebugNavXlsStr($ref);
	    }
	}
}

?>
