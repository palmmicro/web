<?php

// ****************************** HShareReference class *******************************************************
class HShareReference extends MyStockReference
{
    var $a_ref;

    var $fRatio = 1.0;
    var $fHKDCNY;
    
    // constructor 
    function HShareReference($strSymbol, $a_ref) 
    {
    	$this->a_ref = $a_ref;
    	if ($a_ref)
    	{
    		$this->fRatio = SqlGetAhPairRatio($a_ref);
    	}
    	$this->fHKDCNY = SqlGetHKCNY();
        parent::MyStockReference($strSymbol);
    }
    
    function EstFromCny($fEst)
    {
    	return $fEst / ($this->fRatio * $this->fHKDCNY);
    }

    function EstToCny($fEst)
    {
    	return $fEst * ($this->fRatio * $this->fHKDCNY);
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
}

// ****************************** HAdrReference class *******************************************************
class HAdrReference extends HShareReference
{
    var $adr_ref;

    var $fAdrRatio = 1.0;
    var $fHKDUSD;
    var $fUSDCNY;
    
    // constructor 
    function HAdrReference($strSymbol, $a_ref, $adr_ref) 
    {
    	$this->adr_ref = $adr_ref;
    	if ($adr_ref)
    	{
    		$this->fAdrRatio = SqlGetAdrhPairRatio($adr_ref);
    	}
    	$this->fUSDCNY = SqlGetUSCNY();
        parent::HShareReference($strSymbol, $a_ref);
        $this->fHKDUSD = $this->fHKDCNY / $this->fUSDCNY;
    }
    
    function EstFromUsd($fEst)
    {
    	return $fEst / ($this->fAdrRatio * $this->fHKDUSD);
    }

    function EstToUsd($fEst)
    {
    	return $fEst * ($this->fAdrRatio * $this->fHKDUSD);
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
