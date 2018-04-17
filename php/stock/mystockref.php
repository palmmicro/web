<?php

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    var $fFactor;

    function _loadFactor()
    {
        if ($fVal = SqlGetStockCalibrationFactor($this->strSqlId))
        {
            $this->fFactor = $fVal;
        }
        else
        {
            $this->fFactor = 1.0;
        }
        return $this->fFactor;
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

    function InsertStockCalibration($etf_ref)
    {
        return SqlInsertStockCalibration($this->strSqlId, $etf_ref->GetStockSymbol(), $this->strPrice, $etf_ref->strPrice, $this->fFactor, $etf_ref->GetDateTime());
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
    
    function _invalidHistoryData($str)
    {
//        if (empty($str))    return true;
        if ($str == 'N/A')   return true;
        if (FloatNotZero(floatval($str)) == false)  return true;
        return false;
    }
    
    function _updateStockHistory()
    {
        if ($this->bHasData == false)   return false;
        
        $strStockId = $this->strSqlId;
        $strDate = $this->strDate;
        $strOpen = $this->strOpen;
        $strHigh = $this->strHigh;
        $strLow = $this->strLow;
        $strClose = $this->strPrice;
        $strVolume = $this->strVolume;
        SqlCreateStockHistoryTable();
        if ($history = SqlGetStockHistoryByDate($strStockId, $strDate))
        {
//            if ($this->_invalidHistoryData($strOpen))   return false;
//            if ($this->_invalidHistoryData($strHigh))   return false;
//            if ($this->_invalidHistoryData($strLow))    return false;
            if ($this->_invalidHistoryData($strClose))  return false;
            return SqlUpdateStockHistory($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strClose);
        }
        else
        {
            return SqlInsertStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strClose);
        }
        return false;
    }
    
    // constructor 
    function MyStockReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
            if ($strSinaSymbol = $this->sym->GetSinaSymbol())	            $this->LoadSinaData($strSinaSymbol);
			else if ($strGoogleSymbol = $this->sym->GetGoogleSymbol())	$this->LoadGoogleData($strGoogleSymbol);
            else											                    $this->LoadYahooData();
            
/*            if ($this->bHasData == false)
            {
            	$this->bHasData = true;
                $this->LoadYahooData();
                if ($this->bHasData)	DebugString('Wrong symbol classification warning:'.$strSymbol);
            }*/
        }
        else if (self::$strDataSource == STOCK_YAHOO_DATA)
        {
            $this->LoadYahooData();
        }
        else if (self::$strDataSource == STOCK_SINA_FUTURE_DATA)
        {
            $this->strSqlName = FutureGetSinaSymbol($strSymbol);
            $this->LoadSinaFutureData($strSymbol);
        }
        
        parent::MysqlReference($strSymbol);
        if ($this->strSqlId)
        {
            $this->_updateStockHistory();
        }
    }
}

?>
