<?php

class SymbolAccount extends StockAccount
{
//    var $sharesdiff_sql;
    
    function SymbolAccount() 
    {
        parent::StockAccount('symbol');

//	    $this->sharesdiff_sql = new SharesDiffSql();
    }
/*
    function GetSharesDiffSql()
    {
    	return $this->sharesdiff_sql;
    }
*/    
    function Create()
    {
    	if ($strSymbol = StockCheckSymbol($this->GetQuery()))
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
    }
    
    function EchoStockGroup()
    {
    	if ($ref = $this->GetRef())
    	{
    		if ($ref->HasData())
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
}

?>
