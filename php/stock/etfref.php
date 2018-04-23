<?php

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyStockReference
{
    var $strPairSymbol;
    var $strPairId;

    var $fRatio = 1.0;
    
    // constructor 
    function EtfReference($strSymbol, $strPairSymbol) 
    {
        parent::MyStockReference($strSymbol);
    	$this->strPairSymbol = $strPairSymbol;
    	$this->strPairId = SqlGetStockId($strPairSymbol);
        $this->fRatio = SqlGetEtfPairRatio($this->GetStockId());
        if ($history = SqlGetFundHistoryNow($this->GetStockId()))
        {
            $strDate = $history['date'];
            $fNetValue = floatval($history['netvalue']);
        }
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

?>
