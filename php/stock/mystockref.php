<?php

class MyStockReference extends MysqlReference
{
    public function __construct($strSymbol) 
    {
        parent::__construct($strSymbol);
        
    	if ($strStockId = $this->GetStockId())
   		{
   			if ($this->HasData())
   			{	
   				$this->SetTimeZone();
   				$now_ymd = GetNowYMD();
   				$strDate = $this->GetDate();
   				if ($now_ymd->GetYMD() == $strDate)
   				{
   					$this->_updateStockHistory($strStockId, $strDate);
   					if ($now_ymd->IsStockTradingHourEnd())	$this->_updateStockEma($strStockId, $strDate);
   				}
   			}
   		}
    }
    
    public function LoadData()
    {
       	$this->LoadSinaData();
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
    }
    
    function _invalidHistoryData($str)
    {
        if (empty($str))    return true;
        if ($str == 'N/A')   return true;
        return false;
    }
    
    function _updateStockHistory($strStockId, $strDate)
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
        return $his_sql->WriteHistory($strStockId, $strDate, $strClose, $strOpen, $strHigh, $strLow, $this->GetVolume());
    }
    
    // En = k * X0 + (1 - k) * Em; 其中m = n - 1; k = 2 / (n + 1)
	function CalculateEMA($fPrice, $fPrev, $iDays)
	{
		$f = 2.0 / ($iDays + 1);
		return $f * $fPrice + (1.0 - $f) * $fPrev;
	}
    
	function _updateStockEmaDays($strStockId, $strDate, $iDays)
	{
		$sql = GetStockEmaSql($iDays);
		if ($strPrev = $sql->GetClosePrev($strStockId, $strDate))
		{
			$fCur = $this->CalculateEMA(floatval($this->GetPrice()), floatval($strPrev), $iDays);
			$sql->WriteDaily($strStockId, $strDate, strval($fCur));
		}
	}
	
    function _updateStockEma($strStockId, $strDate)
    {
        $this->_updateStockEmaDays($strStockId, $strDate, 50);
        $this->_updateStockEmaDays($strStockId, $strDate, 200);
    }
}

?>
