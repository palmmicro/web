<?php

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyStockReference
{
    var $strPairId = false;

    var $fNetValue = 0.0;
    var $fPairNetValue = 0.0;
    
    var $fRatio = 1.0;
    
    // constructor 
    function EtfReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
        $strStockId = $this->GetStockId();
        $sql = new EtfCalibrationSql($strStockId);
        if ($record = $sql->pair_sql->Get())
        {
        	$this->strPairId = $record['pair_id'];
        	$this->fRatio = floatval($record['ratio']);
        	if ($history = $sql->fund_sql->GetNow())
        	{
        		$strDate = $history['date'];
        		$fNetValue = floatval($history['close']);
        		if ($fFactor = $sql->GetClose($strDate))
        		{
        			$fPairNetValue = $sql->pair_fund_sql->GetClose($strDate);
        		}
        		else
        		{
        			if ($fPairNetValue = $sql->pair_fund_sql->GetClose($strDate))
        			{
        				$fFactor = $fPairNetValue / $fNetValue;
        				$sql->Insert($strDate, strval($fFactor));
        			}
        			else
        			{
        				if ($calibration = $sql->GetNow())
        				{
        					$fFactor = floatval($calibration['close']); 
        					$fNetValue = $sql->fund_sql->GetClose($calibration['date']);
        					$fPairNetValue = $sql->pair_fund_sql->GetClose($calibration['date']);
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
    
    function GetPairId()
    {
		return $this->strPairId;
    }
}

?>
