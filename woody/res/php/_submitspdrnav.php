<?php
require_once('/php/account.php');
require_once('/php/stock.php');
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
