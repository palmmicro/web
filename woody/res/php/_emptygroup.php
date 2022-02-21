<?php

class SymbolAccount extends StockAccount
{
    function SymbolAccount() 
    {
        parent::StockAccount('symbol');

    	if ($strSymbol = StockCheckSymbol($this->GetQuery()))
    	{
   			StockPrefetchExtendedData($strSymbol);
   			$this->ref = StockGetReference($strSymbol);
    	}
	   	else if ($strStockId = UrlGetQueryValue('id'))
	   	{
	   		if ($strSymbol = SqlGetStockSymbol($strStockId))
	   		{
	   			SwitchToLink(UrlGetUri().'?'.UrlAddQuery('symbol='.$strSymbol));
	   		}
	   	}
    }
    
    function EchoStockGroup()
    {
    	if ($ref = $this->GetRef())
    	{
    		if ($ref->HasData() || $this->IsAdmin())
    		{
    			EchoStockGroupParagraph($this, false, $ref->GetStockId());
    			return $ref;
    		}
    	}
    	return false;
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

    function GetTitleDisplay($strDisplay = '')
    {
    	return $this->GetSymbolDisplay().$strDisplay.$this->GetStartNumDisplay();
    }

    function GetMetaDisplay($strDisplay = '')
    {
    	return $this->GetStockDisplay().$strDisplay.$this->GetStartNumDisplay();
    }
}

?>
