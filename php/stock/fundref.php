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
    var $est_ref = false;      // StockRefenrence for fund net value estimation
    
    // original data
//    var $strPrevNetValue;      // Most recent net value orginal data is in parent::$strPrevPrice 

    // estimated float point data 
    var $fRealtimeNetValue = false;
    var $fFairNetValue = false;

    // constructor 
    function FundReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        $strFundSymbol = $this->sym->GetSinaFundSymbol();
        
        $this->strFileName = DebugGetSinaFileName($strFundSymbol);
        $ar = explodeQuote(_getSinaFundStr($this->sym, $strFundSymbol, $this->strFileName));
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
