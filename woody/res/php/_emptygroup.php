<?php
require_once('/php/stockgroup.php');

class StockSymbolPage extends EmptyStockGroup
{
    var $ref = false;		// MysqlReference
    
    var $strLoginId;
    var $strMemberId;
    
    function StockSymbolPage($strLoginId) 
    {
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
	   	
	   	$this->strLoginId = $strLoginId;
	   	if ($strEmail = UrlGetQueryValue('email'))
	   	{
	   		$this->strMemberId = SqlGetIdByEmail($strEmail); 
	   	}
	   	else
	   	{
	   		$this->strMemberId = $strLoginId;
	   	}
    }
    
    function GetRef()
    {
    	return $this->ref;
    }

    function GetLoginId()
    {
    	return $this->strLoginId;
    }
    
    function IsAdmin()
    {
	   	return AcctIsAdmin($this->strLoginId);
    }
    
    function EchoLinks($strVer = false)
    {
    	EchoPromotionHead($strVer);
    	EchoStockCategory($this->strLoginId);
    }
    
    function EchoStockGroup()
    {
    	if ($ref = $this->GetRef())
    	{
    		if ($strLoginId = $this->GetLoginId())
    		{
    			EchoAllStockGroupParagraph($this->GetGroupId(), $ref->GetStockId(), $this->strMemberId, $strLoginId);
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
    	return _GetWhoseDisplay($this->strMemberId, $this->strLoginId);
    }
}

?>
