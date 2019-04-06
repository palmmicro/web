<?php
require_once('/php/stockgroup.php');

class StockSymbolPage extends EmptyStockGroup
{
    var $ref = false;		// MysqlReference
    
    var $strMemberId;
    var $bAdmin;
    
    function StockSymbolPage($strMemberId) 
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
    
    function EchoLinks($strVer = false)
    {
    	EchoPromotionHead($strVer);
    	EchoStockCategory();
    }
    
    function GetSymbolDisplay($strDefault = '')
    {
        return $this->ref ? $this->ref->GetStockSymbol() : $strDefault;
    }
}

?>
