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

    function Convert($strUSDCNY, $strHKDCNY = false) 
    {
        $this->fConvertCNY = $this->fCNY;
        if ($strUSDCNY)   $this->fConvertCNY += $this->fUSD * floatval($strUSDCNY);    
        if ($strHKDCNY)   $this->fConvertCNY += $this->fHKD * floatval($strHKDCNY);

        $this->fConvertUSD = $strUSDCNY ? $this->fConvertCNY / floatval($strUSDCNY) : 0.0;
        $this->fConvertHKD = $strHKDCNY ? $this->fConvertCNY / floatval($strHKDCNY) : 0.0;
    }
}

?>
