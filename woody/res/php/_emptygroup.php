<?php

class SymbolAcctStart extends AcctStart
{
    var $ref = false;		// MysqlReference class
    
    function SymbolAcctStart($bMustLogin = true) 
    {
        parent::AcctStart();
    	if ($bMustLogin)
    	{
    		$this->Auth();
    	}
    	
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
    	EchoPromotionHead($strVer);
    	EchoStockCategory($this->GetLoginId());
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
