<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('_spdrnavxls.php');
require_once('_emptygroup.php');

    $group = new StockSymbolPage();
	if ($group->IsAdmin())
	{
	    if ($ref = $group->GetRef())
	    {
	        $str = GetSpdrNavXlsStr($ref->GetStockSymbol());
	        DebugString($str);
	    }
	}
	$group->Back();
	
?>
