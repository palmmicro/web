<?php

// ****************************** FutureReference class *******************************************************
class FutureReference extends MyStockReference
{
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
            $this->fFactor = $this->fPrice / $etf_ref->fPrice;
            $this->InsertStockCalibration($etf_ref);
            return true;
        }
        return false;
    }
	
    // Future Factor functions
    function EstByFuture($fEtf, $fCNY)
    {
        return $fEtf * $fCNY / $this->fFactor;
    }
    
    function LoadFutureFactor($future_ref, $strForexSqlId)
    {
        if ($this->AdjustFutureFactor($future_ref, $strForexSqlId) == false)
        {
            $this->_loadFactor();
        }
        return $this->fFactor;
    }
    
    function AdjustFutureFactor($future_ref, $strForexSqlId)
    {
        if ($this->bHasData == false)    return false;
        
        $fCNY = SqlGetForexCloseHistory($strForexSqlId, $this->strDate);
        if ($fCNY)
        {
            if ($this->CheckAdjustFactorTime($future_ref))
            {
                $this->fFactor = $future_ref->fPrice * $fCNY / $this->fPrice;
                $this->InsertStockCalibration($future_ref);
                return true;
            }
        }
        return false;
    }
    
    // constructor 
    function FutureReference($strSymbol) 
    {
        $strBackup = parent::$strDataSource;
        parent::$strDataSource = STOCK_SINA_FUTURE_DATA;
        parent::MyStockReference($strSymbol);
        parent::$strDataSource = $strBackup;
    }
}

?>
