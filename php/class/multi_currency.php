<?php

// ****************************** MultiCurrency Class *******************************************************

class MultiCurrency
{
    var $fCNY;
    var $fHKD;
    var $fUSD;

    var $fConvertCNY;
    var $fConvertHKD;
    var $fConvertUSD;
    
    function MultiCurrency() 
    {
        $this->fCNY = 0.0;
        $this->fHKD = 0.0;
        $this->fUSD = 0.0;
    }

    function Convert($fUSDCNY, $fHKDCNY = false) 
    {
        $this->fConvertCNY = $this->fCNY;
        if ($fUSDCNY)   $this->fConvertCNY += $this->fUSD * $fUSDCNY;    
        if ($fHKDCNY)   $this->fConvertCNY += $this->fHKD * $fHKDCNY;

        if ($fUSDCNY)   $this->fConvertUSD = $this->fConvertCNY / $fUSDCNY;
        else              $this->fConvertUSD = 0.0;  
        
        if ($fHKDCNY)   $this->fConvertHKD = $this->fConvertCNY / $fHKDCNY;
        else              $this->fConvertHKD = 0.0;  
    }
}

?>
