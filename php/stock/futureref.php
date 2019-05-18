<?php

// ****************************** FutureReference class *******************************************************
class FutureReference extends MysqlReference
{
    function FutureReference($strSymbol) 
    {
    	$sym = new StockSymbol($strSymbol);
        $this->LoadSinaFutureData($sym);
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
        parent::MysqlReference($sym);
    }
    
    function InsertStockCalibration($etf_ref)
    {
        return SqlInsertStockCalibration($this->strSqlId, $etf_ref->GetStockSymbol(), $this->strPrice, $etf_ref->strPrice, $this->fFactor, $etf_ref->GetDateTime());
    }

    // ETF Factor functions
    function EstEtf($fVal)
    {
        return $fVal / $this->fFactor;
    }
    
    function EstByEtf($fEtf)
    {
        return $fEtf * $this->fFactor;
    }
    
    function _loadFactor()
    {
        if ($fVal = SqlGetStockCalibrationFactor($this->strSqlId))
        {
            $this->fFactor = $fVal;
        }
        return $this->fFactor;
    }
    
    function LoadEtfFactor($etf_ref)
    {
        if ($this->AdjustEtfFactor($etf_ref) == false)
        {
            return $this->_loadFactor();
        }
        return $this->fFactor;
    }

    function AdjustEtfFactor($etf_ref)
    {
        if ($this->CheckAdjustFactorTime($etf_ref))
        {
            $this->fFactor = floatval($this->GetCurPrice()) / floatval($etf_ref->GetCurPrice());
            $this->InsertStockCalibration($etf_ref);
            return true;
        }
        return false;
    }
}

?>
