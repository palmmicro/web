<?php

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyStockReference
{
    var $strPairId = false;

    var $fNetValue = 0.0;
    var $fPairNetValue = 0.0;
    
    var $fRatio = 1.0;
    var $fFactor = 1.0;
    
    // constructor 
    function EtfReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
        $strStockId = $this->GetStockId();
        if ($record = SqlGetStockPair(TABLE_ETF_PAIR, $strStockId))
        {
        	$strEtfPairId = $record['id'];
        	$this->strPairId = $record['pair_id'];
        	$this->fRatio = floatval($record['ratio']);
        	if ($history = SqlGetFundHistoryNow($strStockId))
        	{
        		$strDate = $history['date'];
        		$fNetValue = floatval($history['netvalue']);
        		SqlCreateCalibrationTable();
        		if ($fFactor = SqlGetCalibrationByDate($strEtfPairId, $strDate))
        		{
        			$fPairNetValue = SqlGetFundNetValueByDate($this->strPairId, $strDate);
        		}
        		else
        		{
        			if ($fPairNetValue = SqlGetFundNetValueByDate($this->strPairId, $strDate))
        			{
        				$fFactor = $fPairNetValue / $fNetValue;
        				SqlInsertCalibration($strEtfPairId, strval($fFactor), $strDate);
        			}
        			else
        			{
        				if ($calibration = SqlGetCalibrationNow($strEtfPairId))
        				{
        					$fFactor = floatval($calibration['factor']); 
        					$fNetValue = SqlGetFundNetValueByDate($strStockId, $calibration['date']);
        					$fPairNetValue = SqlGetFundNetValueByDate($this->strPairId, $calibration['date']);
        				}
        			}
        		}
        		$this->fFactor = $fFactor;
        		$this->fNetValue = $fNetValue;
        		$this->fPairNetValue = $fPairNetValue;
        	}
        }
    }
    
    // (fEst - fPairNetValue)/(x - fNetValue) = fFactor / fRatio;
    function EstFromPair($fEst)
    {
    	return ($fEst - $this->fPairNetValue) * $this->fRatio / $this->fFactor + $this->fNetValue;
    }

    // (x - fPairNetValue)/(fEsts - fNetValue) = fFactor / fRatio;
    function EstToPair($fEst)
    {
    	return ($fEst - $this->fNetValue) * $this->fFactor / $this->fRatio + $this->fPairNetValue;
    }
}

?>
