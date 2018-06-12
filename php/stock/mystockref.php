<?php

// ****************************** MyStockReference class *******************************************************
class MyStockReference extends MysqlReference
{
    public static $strDataSource = STOCK_SINA_DATA;

    var $fFactor = 1.0;

    function _loadFactor()
    {
        if ($fVal = SqlGetStockCalibrationFactor($this->strSqlId))
        {
            $this->fFactor = $fVal;
        }
        return $this->fFactor;
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
        $strStockId = $this->strSqlId;
        $strDate = $this->strDate;
        $strOpen = $this->strOpen;
        $strHigh = $this->strHigh;
        $strLow = $this->strLow;
        $strClose = $this->strPrice;
        $strVolume = $this->strVolume;
        if ($this->_invalidHistoryData($strClose))  return;
        SqlCreateStockHistoryTable();
        $sql = new StockHistorySql($strStockId);
        $sql->Merge($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strClose);
    }

    // En = k * X0 + (1 - k) * Em; 其中m = n - 1; k = 2 / (n + 1)
	function CalculateEMA($fPrice, $fPrev, $iDays)
	{
		$f = 2.0 / ($iDays + 1);
		return $f * $fPrice + (1.0 - $f) * $fPrev;
	}
    
	function _updateStockEmaDays($iDays)
	{
		$sql = new StockEmaSql($this->strSqlId, $iDays);
		$strDate = $this->strDate;
		if ($fPrev = $sql->GetClosePrev($strDate))
		{
			$fCur = $this->CalculateEMA($this->fPrice, $fPrev, $iDays);
			$sql->Write($strDate, strval($fCur));
		}
	}
	
    function _updateStockEma($now_ymd)
    {
    	if ($now_ymd->IsTradingHourEnd() == false)	return;
        $this->_updateStockEmaDays(50);
        $this->_updateStockEmaDays(200);
    }
    
    // constructor 
    function MyStockReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        if (self::$strDataSource == STOCK_SINA_DATA)
        {
            if ($strSinaSymbol = $this->sym->GetSinaSymbol())	$this->LoadSinaData($strSinaSymbol);
        }
        else if (self::$strDataSource == STOCK_SINA_FUTURE_DATA)
        {
            $this->strSqlName = FutureGetSinaSymbol($strSymbol);
            $this->LoadSinaFutureData($strSymbol);
        }
        else if (self::$strDataSource == STOCK_YAHOO_DATA)
        {
            $this->LoadYahooData();
        }
        else if (self::$strDataSource == STOCK_GOOGLE_DATA)
        {
			if ($strGoogleSymbol = $this->sym->GetGoogleSymbol())	$this->LoadGoogleData($strGoogleSymbol);
        }
        
        parent::MysqlReference($strSymbol);
        $now_ymd = new NowYMD();
        if ($now_ymd->GetYMD() == $this->strDate && $this->strSqlId && $this->bHasData)
        {
            $this->_updateStockHistory();
            $this->_updateStockEma($now_ymd);
        }
    }
}

?>
