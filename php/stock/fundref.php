<?php

// ****************************** Private functions *******************************************************

function _getSinaFundStr($sym, $strFundSymbol, $strFileName)
{
    if (($str = IsNewDailyQuotes($sym, $strFileName, false, _GetFundQuotesYMD)) === false)
    {
        $str = GetSinaQuotes($strFundSymbol);
        if ($str)   file_put_contents($strFileName, $str);
        else         $str = file_get_contents($strFileName);
    }
    return $str;
}

// ****************************** FundReference Class *******************************************************

class FundReference extends StockReference
{
    // original data
//    var $strPrevNetValue;      // Most recent net value orginal data is in parent::$strPrevPrice 

    // constructor 
    function FundReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        $sym = $this->sym;
        if ($sym->IsSinaFund())	$strFundSymbol = $strSymbol;
        else						$strFundSymbol = $sym->GetSinaFundSymbol();
        
        $this->strFileName = DebugGetSinaFileName($strFundSymbol);
        $ar = explodeQuote(_getSinaFundStr($sym, $strFundSymbol, $this->strFileName));
        if (count($ar) < 4)
        {
            $this->bHasData = false;
            return;
        }
        
        $this->strPrice = '0.0';
        $this->strPrevPrice = $ar[1];   // net value
//        $this->strPrevNetValue = $ar[3];
        
        $this->strDate = $ar[4];
        $this->strName = $ar[0];

        parent::StockReference($strSymbol);
    }
}

?>
