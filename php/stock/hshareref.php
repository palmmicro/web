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
    
    // constructor 
    function HShareReference($strSymbol) 
    {
   		$this->fHKDCNY = SqlGetHKCNY();
        if ($strSymbolA = SqlGetHaPair($strSymbol))
        {
        	$this->a_ref = new MyStockReference($strSymbolA);
    		$this->fRatio = SqlGetAhPairRatio($this->a_ref);
    	}
        if ($strSymbolAdr = SqlGetHadrPair($strSymbol))
        {
        	$this->adr_ref = new MyStockReference($strSymbolAdr);
    		$this->fAdrRatio = SqlGetAdrhPairRatio($this->adr_ref);
    		$this->fUSDCNY = SqlGetUSCNY();
    		$this->fHKDUSD = $this->fHKDCNY / $this->fUSDCNY;
    	}
        parent::MyStockReference($strSymbol);
    }
    
    function EstFromCny($fEst)
    {
    	if ($this->a_ref)
    	{
    		return $fEst / ($this->fRatio * $this->fHKDCNY);
    	}
    	return 0.0;
    }

    function EstToCny($fEst)
    {
    	if ($this->a_ref)
    	{
    		return $fEst * ($this->fRatio * $this->fHKDCNY);
    	}
    	return 0.0;
    }
    
    function GetCnyPrice()
    {
    	return $this->EstToCny($this->fPrice);
    }
    
    function GetAhRatio()
    {
    	if ($this->a_ref)
    	{
    		return $this->a_ref->fPrice / $this->GetCnyPrice();
    	}
    	return 1.0;
    }
   
    function EstFromUsd($fEst)
    {
    	if ($this->adr_ref)
    	{
    		return $fEst / ($this->fAdrRatio * $this->fHKDUSD);
    	}
    	return 0.0;
    }

    function EstToUsd($fEst)
    {
    	if ($this->adr_ref)
    	{
    		return $fEst * ($this->fAdrRatio * $this->fHKDUSD);
    	}
    	return 0.0;
    }
    
    function FromUsdToCny($fEst)
    {
		$fHkd = $this->EstFromUsd($fEst);
		return $this->EstToCny($fHkd);
	}

	function FromCnyToUsd($fEst, $ref)
	{
		$fHkd = $this->EstFromCny($fEst);
		return $this->EstToUsd($fHkd);
	}
    
    function GetUsdPrice()
    {
    	return $this->EstToUsd($this->fPrice);
    }
    
    function GetAdrhRatio()
    {
    	if ($this->adr_ref)
    	{
    		return $this->adr_ref->fPrice / $this->GetUsdPrice();
    	}
    	return 1.0;
    }
}

?>
