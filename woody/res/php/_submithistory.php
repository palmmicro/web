<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('_spdrnavxls.php');
require_once('/php/stockhis.php');
require_once('/php/stock/updatestockhistory.php');

// https://danjuanapp.com/djmodule/value-center

    $acct = new SymbolAccount();
	if ($acct->IsAdmin())
	{
		$acct->Create();
	    if ($ref = $acct->GetRef())
	    {
	        UpdateStockHistory($ref, $ref->GetStockId());
	        
	        // do some extra work together
	        DebugNavXlsStr($ref);
	    }
	}
	$acct->Back();
	
?>
