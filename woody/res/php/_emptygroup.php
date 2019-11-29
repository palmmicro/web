<?php

class SymbolAcctStart extends StockAcctStart
{
    var $ref = false;		// MysqlReference class
    
    function SymbolAcctStart() 
    {
        parent::StockAcctStart('symbol');
    	
    	if ($strSymbol = $this->GetQuery())
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

    function EchoStockGroup()
    {
    	if ($ref = $this->GetRef())
    	{
   			$this->EchoStockGroupParagraph(false, $ref->GetStockId());
    	}
    	return $ref;
    }
    
    function GetSymbolDisplay($strDefault = '')
    {
    	$ref = $this->GetRef();
        return $ref ? $ref->GetSymbol() : $strDefault;
    }

    function GetStockDisplay($strDefault = '')
    {
    	$ref = $this->GetRef();
        return $ref ? RefGetStockDisplay($ref) : $strDefault;
    }
}

?>
