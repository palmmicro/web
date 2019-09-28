<?php
require_once('/php/stockgroup.php');

class StockSymbolPage extends EmptyStockGroup
{
    var $acct;				// AcctStart class
    var $ref = false;		// MysqlReference class
    
    function StockSymbolPage($bMustLogin = true) 
    {
    	$this->acct = new AcctStart();
    	if ($bMustLogin)
    	{
    		$this->acct->Auth();
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

    function GetLoginId()
    {
    	return $this->acct->GetLoginId();
    }
    
    function GetMemberId()
    {
    	return $this->acct->GetMemberId();
    }
    
    function IsAdmin()
    {
	   	return $this->acct->IsAdmin();
    }
    
    function Back()
    {
	   	$this->acct->Back();
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
    			EchoAllStockGroupParagraph($this->GetGroupId(), $ref->GetStockId(), $this->GetMemberId(), $strLoginId);
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
