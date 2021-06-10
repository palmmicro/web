<?php

// ****************************** MysqlReference class *******************************************************
class MysqlReference extends StockReference
{
    var $strSqlId = false;      // ID in mysql database
	var $bConvertGB2312 = false;

    var $fFactor = 1.0;			// 'factor' field in old stockcalibration table or 'close' field in new etfcalibration table
    
    function MysqlReference($strSymbol) 
    {
        parent::StockReference($strSymbol);
        $this->LoadData();

        $this->_loadSqlId($this->GetSymbol());
        if ($this->strSqlId)
        {
        	if ($this->bHasData)
        	{
        		$now_ymd = new NowYMD();
        		if ($now_ymd->GetYMD() == $this->GetDate())
        		{
        			$this->_updateStockHistory();
       				$this->_updateStockEma($now_ymd);
        		}
        	}
        }
    }
    
    function LoadData()
    {
    }

    function _loadSqlId($strSymbol)
    {
    	if ($this->strSqlId)	return;	// Already set, like in CnyReference
    	
		$sql = GetStockSql();
        if ($this->bHasData)
        {
            $sql->InsertSymbol($strSymbol, $this->GetChineseName());
        }
    	$this->strSqlId = $sql->GetId($strSymbol);
    }
    
    function GetStockId()
    {
        return $this->strSqlId;
    }
    
    function GetEnglishName()
    {
    	if ($this->bConvertGB2312)
    	{
    		return GbToUtf8($this->strName);
    	}
   		return $this->strName;
    }
    
    function GetChineseName()
    {
    	if (empty($this->strChineseName))
    	{
    		return $this->GetEnglishName();	// 数据中只有唯一一个中文或者英文名字的情况下, 优先放strName字段.
    	}

    	if ($this->bConvertGB2312)
    	{
    		return GbToUtf8($this->strChineseName);
    	}
    	return $this->strChineseName;
    }
    
    function _invalidHistoryData($str)
    {
        if (empty($str))    return true;
        if ($str == 'N/A')   return true;
        return false;
    }
    
    function _updateStockHistory()
    {
        $strOpen = $this->strOpen;
        if ($this->_invalidHistoryData($strOpen))  return;
        $strHigh = $this->strHigh;
        if ($this->_invalidHistoryData($strHigh))  return;
        $strLow = $this->strLow;
        if ($this->_invalidHistoryData($strLow))  return;
        $strClose = $this->GetPrice();
        if ($this->_invalidHistoryData($strClose))  return;
        
        $his_sql = GetStockHistorySql();
        return $his_sql->WriteHistory($this->strSqlId, $this->GetDate(), $strOpen, $strHigh, $strLow, $strClose, $this->strVolume, $strClose);
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
		$strDate = $this->GetDate();
		if ($strPrev = $sql->GetClosePrev($strDate))
		{
			$fCur = $this->CalculateEMA(floatval($this->GetPrice()), floatval($strPrev), $iDays);
			$sql->Write($strDate, strval($fCur));
		}
	}
	
    function _updateStockEma($now_ymd)
    {
    	if ($now_ymd->IsTradingHourEnd() == false)	return;
        $this->_updateStockEmaDays(50);
        $this->_updateStockEmaDays(200);
    }
}

?>
