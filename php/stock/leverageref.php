<?php

function _getEtfLeverageRatio($strSymbol)
{
    if ($strSymbol == 'SH')         return -1.0;
    else if ($strSymbol == 'VXX')  return 0.5;      // compare with UVXY
    else if ($strSymbol == 'SVXY')  return -0.5;    // compare with UVXY
    else if ($strSymbol == 'DGP' || $strSymbol == 'AGQ' || $strSymbol == 'UCO')   return 2.0;
    else if ($strSymbol == 'SDS' || $strSymbol == 'DZZ' || $strSymbol == 'ZSL' || $strSymbol == 'SCO')  return -2.0;
    else if ($strSymbol == 'GUSH' || $strSymbol == 'UWT' || $strSymbol == 'UPRO' || $strSymbol == 'UGAZ')  return 3.0;
    else if ($strSymbol == 'DRIP' || $strSymbol == 'DWT' || $strSymbol == 'SPXU' || $strSymbol == 'DGAZ')  return -3.0;
    else if ($strSymbol == 'WB')  return 1.46;      // compare with SINA
    else 
        return 1.0;
}

class LeverageReference extends MyStockReference
{
    var $fRatio;
    
    // constructor 
    function LeverageReference($strSymbol) 
    {
        $this->fRatio = _getEtfLeverageRatio($strSymbol);
        parent::MyStockReference($strSymbol);
    }

    function EstByEtf1x($fEtf1x, $ref_1x)
    {
        $fGain1x = ($fEtf1x / $ref_1x->fPrevPrice) - 1.0;
        return (1.0 + $this->fRatio * $fGain1x) * $this->fPrevPrice; 
    }
    
    function GetEstByEtf1xDisplay($fEtf1x, $ref_1x)
    {
        $fVal = $this->EstByEtf1x($fEtf1x, $ref_1x);
        return $this->GetPriceDisplay($fVal);
    }
}

?>
