<?php
require_once('_stock.php');
require_once('_spdrnavxls.php');
require_once('_emptygroup.php');

    $acct = new SymbolAccount();
	if ($acct->IsAdmin())
	{
	    if ($ref = $acct->GetRef())
	    {
	        $str = GetSpdrNavXlsStr($ref->GetSymbol());
	        DebugString($str);
	    }
	}
	$acct->Back();
	
?>
