<?php

class SymbolAcctStart extends NavAcctStart
{
    var $ref = false;		// MysqlReference class
    
    function SymbolAcctStart($bLogin = true) 
    {
        parent::NavAcctStart($bLogin);
    	
    	if ($strSymbol = UrlGetQueryValue('symbol'))
    	{
    		if (strlen($strSymbol) <= MAX_STOCK_SYMBOL_LEN)
    		{
    			StockPrefetchData($strSymbol);
    			$this->ref = StockGetReference($strSymbol);
    		}
    	}
	   	else if ($strStockId = UrlGetQueryValue('id'))
	   	{
	   		if ($strSymbol = SqlGetStockSymbol($strStockId))
	   		{
	   			SwitchToLink(UrlGetUri().'?'.UrlAddQuery('symbol='.$strSymbol));
	   		}
	   	}
    }
    
    function GetRef()
    {
    	return $this->ref;
    }

    function EchoLinks($strVer = false)
    {
    	$strLoginId = $this->GetLoginId();
    	EchoPromotionHead($strVer, $strLoginId);
    	EchoStockCategory($strLoginId);
    }
    
    function EchoStockGroup()
    {
    	if ($ref = $this->GetRef())
    	{
    		if ($strLoginId = $this->GetLoginId())
    		{
    			EchoAllStockGroupParagraph(false, $ref->GetStockId(), $this->GetMemberId(), $strLoginId);
    		}
    	}
    	return $ref;
    }
    
    function GetSymbolDisplay($strDefault = '')
    {
    	$ref = $this->GetRef();
        return $ref ? $ref->GetStockSymbol() : $strDefault;
    }

    function GetStockDisplay($strDefault = '')
    {
    	$ref = $this->GetRef();
        return $ref ? RefGetStockDisplay($ref) : $strDefault;
    }

    function GetWhoseDisplay()
    {
    	return _GetWhoseDisplay($this->GetMemberId(), $this->GetLoginId());
    }
}

?>
