<?php

// ****************************** HShareReference class *******************************************************
class HShareReference extends MyStockReference
{
    var $a_ref = false;
    var $adr_ref = false;

    var $fRatio = 1.0;
    var $fAdrRatio = 1.0;
    
    var $fHKDUSD;
    var $fUSDCNY;
    var $fHKDCNY;
    
    function HShareReference($strSymbol) 
    {
   		$this->fHKDCNY = floatval(SqlGetHKCNY());
        if ($strSymbolA = SqlGetHaPair($strSymbol))
        {
        	$this->a_ref = new MyStockReference($strSymbolA);
    		$this->fRatio = SqlGetAhPairRatio($this->a_ref);
    	}
        if ($strSymbolAdr = SqlGetHadrPair($strSymbol))
        {
        	$this->adr_ref = new MyStockReference($strSymbolAdr);
    		$this->fAdrRatio = SqlGetAdrhPairRatio($this->adr_ref);
    		$this->fUSDCNY = floatval(SqlGetUSCNY());
    		$this->fHKDUSD = $this->fHKDCNY / $this->fUSDCNY;
    	}
        parent::MyStockReference($strSymbol);
    }
    
    function GetRatio()
    {
    	return $this->fRatio;
    }
    
    function GetAdrRatio()
    {
    	return $this->fAdrRatio;
    }
    
    function GetSymbolA()
    {
    	return $this->a_ref ? $this->a_ref->GetStockSymbol() : false;
    }
    
    function EstFromCny($strEst)
    {
  		return $this->a_ref ? strval(floatval($strEst) / ($this->fRatio * $this->fHKDCNY)) : '0';
    }

    function EstToCny($strEst, $strHKDCNY = false)
    {
    	$fHKDCNY = $strHKDCNY ? floatval($strHKDCNY) : $this->fHKDCNY;
		return $this->a_ref ? strval(floatval($strEst) * $this->fRatio * $fHKDCNY) : '0';
    }
    
    function GetCnyPrice()
    {
    	return $this->EstToCny($this->strPrice);
    }
    
    function GetAhPriceRatio()
    {
    	if ($this->a_ref)
    	{
    		$strPrice = $this->a_ref->GetCurrentPrice();
    		if (empty($strPrice) == false)		return floatval($strPrice) / floatval($this->GetCnyPrice());
    	}
    	return 1.0;
    }
   
    function EstFromUsd($strEst)
    {
   		return $this->adr_ref ? strval(floatval($strEst) / ($this->fAdrRatio * $this->fHKDUSD)) : '0';
    }

    function EstToUsd($strEst)
    {
   		return $this->adr_ref ? strval(floatval($strEst) * ($this->fAdrRatio * $this->fHKDUSD)) : '0';
    }
    
    function FromUsdToCny($strEst)
    {
		$strHkd = $this->EstFromUsd($strEst);
		return $this->EstToCny($strHkd);
	}

	function FromCnyToUsd($strEst)
	{
		$strHkd = $this->EstFromCny($strEst);
		return $this->EstToUsd($strHkd);
	}
    
    function GetUsdPrice()
    {
    	return $this->EstToUsd($this->strPrice);
    }
    
    function GetAdrhPriceRatio()
    {
    	if ($this->adr_ref)
    	{
    		$strPrice = $this->GetUsdPrice();
    		if (empty($strPrice) == false)		return $this->adr_ref->fPrice / floatval($strPrice);
    	}
    	return 1.0;
    }
}

?>
