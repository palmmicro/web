<?php

class SymbolAccount extends StockAccount
{
    function SymbolAccount() 
    {
        parent::StockAccount('symbol');

        if ($this->GetQuery() == false)
        {
        	if ($strStockId = UrlGetQueryValue('id'))
        	{
        		if ($strSymbol = SqlGetStockSymbol($strStockId))	SwitchToLink(UrlGetUri().'?'.UrlAddQuery('symbol='.$strSymbol));
        	}
        }
    }
    
    function GetSymbolRef()
    {
    	if ($ref = $this->GetRef())		return $ref;
    	else
    	{
    		if ($strSymbol = $this->StockCheckSymbol($this->GetQuery()))
    		{
    			StockPrefetchExtendedData($strSymbol);
    			$ref = StockGetReference($strSymbol);
    			$this->SetRef($ref);
    			return $ref;
    		}
    	}
    	return false;
    }
    
    function EchoStockGroup()
    {
    	if ($ref = $this->GetSymbolRef())
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
    	$ref = $this->GetSymbolRef();
        return $ref ? $ref->GetSymbol() : $strDefault;
    }

    function GetStockDisplay($strDefault = '')
    {
    	$ref = $this->GetSymbolRef();
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
