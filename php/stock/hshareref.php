<?php

// ****************************** HShareReference class *******************************************************
class HShareReference extends MyStockReference
{
    var $a_ref = false;
    var $adr_ref = false;
    var $uscny_ref = false;
    var $hkcny_ref;

    var $fAdrRatio = 1.0;
    
    var $fHKDUSD;
    var $fUSDCNY;
    var $fHKDCNY;
    
    function HShareReference($strSymbol) 
    {
        $this->hkcny_ref = new CnyReference('HKCNY');
        $this->fHKDCNY = floatval($this->hkcny_ref->GetPrice());
        if ($strSymbolA = SqlGetHaPair($strSymbol))
        {
        	$this->a_ref = new MyStockReference($strSymbolA);
    	}
        if ($strSymbolAdr = SqlGetHadrPair($strSymbol))
        {
        	$this->adr_ref = new MyStockReference($strSymbolAdr);
    		$this->fAdrRatio = SqlGetAdrhPairRatio($this->adr_ref);
    		
    		$this->uscny_ref = new CnyReference('USCNY');
    		$this->fUSDCNY = floatval($this->uscny_ref->GetPrice());
    		$this->fHKDUSD = $this->fHKDCNY / $this->fUSDCNY;
    	}
        parent::MyStockReference($strSymbol);
    }
    
    function GetHKDUSD()
    {
    	return $this->fHKDUSD;
    }
    
    function GetUSDCNY()
    {
    	return $this->fUSDCNY;
    }
    
    function GetHKDCNY()
    {
    	return $this->fHKDCNY;
    }
    
    function GetAdrRatio()
    {
    	return $this->fAdrRatio;
    }
    
    function GetSymbolA()
    {
    	return $this->a_ref ? $this->a_ref->GetSymbol() : false;
    }
    
    function EstFromCny($strEst)
    {
  		return $this->a_ref ? strval(floatval($strEst) / $this->fHKDCNY) : '0';
    }

    function EstToCny($strEst, $strHKDCNY = false)
    {
    	$fHKDCNY = $strHKDCNY ? floatval($strHKDCNY) : $this->fHKDCNY;
		return $this->a_ref ? strval(floatval($strEst) * $fHKDCNY) : '0';
    }
    
    function GetCnyPrice()
    {
    	return $this->EstToCny($this->GetPrice());
    }
    
    function GetAhPriceRatio()
    {
    	if ($this->a_ref)
    	{
    		$strPrice = $this->a_ref->GetPrice();
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
    	return $this->EstToUsd($this->GetPrice());
    }
    
    function GetAdrhPriceRatio()
    {
    	if ($this->adr_ref)
    	{
    		$strPrice = $this->GetUsdPrice();
    		if (empty($strPrice) == false)		return floatval($this->adr_ref->GetPrice()) / floatval($strPrice);
    	}
    	return 1.0;
    }
}

?>
