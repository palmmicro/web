<?php

function HShareEstToCny($fEst, $fRatio, $fHKCNY)
{
	return $fEst * $fRatio * $fHKCNY;
}

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
    
    function EstFromCny($strEst)
    {
  		return $this->a_ref ? strval(floatval($strEst) / ($this->fRatio * $this->fHKDCNY)) : '0';
    }

    function EstToCny($strEst)
    {
		return $this->a_ref ? strval(HShareEstToCny(floatval($strEst), $this->fRatio, $this->fHKDCNY)) : '0';
    }
    
    function GetCnyPrice()
    {
    	return $this->EstToCny($this->strPrice);
    }
    
    function GetAhRatio()
    {
    	if ($this->a_ref)
    	{
    		return $this->a_ref->fPrice / floatval($this->GetCnyPrice());
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
    
    function GetAdrhRatio()
    {
    	if ($this->adr_ref)
    	{
    		return $this->adr_ref->fPrice / floatval($this->GetUsdPrice());
    	}
    	return 1.0;
    }
}

?>
