<?php
require_once('_stock.php');
require_once('_spdrnavxls.php');
require_once('_emptygroup.php');

    $acct = new SymbolAcctStart();
	if ($acct->IsAdmin())
	{
	    if ($ref = $acct->GetRef())
	    {
	        $str = GetSpdrNavXlsStr($ref->GetStockSymbol());
	        DebugString($str);
	    }
	}
	$acct->Back();
	
?>
