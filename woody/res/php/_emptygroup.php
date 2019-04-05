<?php
require_once('/php/stockgroup.php');

class SymbolGroup extends EmptyGroup
{
    var $ref = false;		// MysqlReference
    
    var $strMemberId;
    var $bAdmin;
    
    function SymbolGroup($strMemberId) 
    {
    	if ($strSymbol = UrlGetQueryValue('symbol'))
    	{
    		StockPrefetchData($strSymbol);
    		$this->ref = StockGetReference($strSymbol);
    	}
	   	else if ($strStockId = UrlGetQueryValue('id'))
	   	{
	   		if ($strSymbol = SqlGetStockSymbol($strStockId))
	   		{
	   			SwitchToLink(UrlGetUri().'?'.UrlAddQuery('symbol='.$strSymbol));
	   		}
	   	}
	   	
	   	$this->strMemberId = $strMemberId;
	   	$this->bAdmin = AcctIsAdmin();
    }
    
    function GetRef()
    {
    	return $this->ref;
    }

    function GetMemberId()
    {
    	return $this->strMemberId;
    }
    
    function IsAdmin()
    {
    	return $this->bAdmin;
    }
}

?>
