<?php

// ****************************** NetValueReference class *******************************************************
class NetValueReference extends StockReference
{
    function NetValueReference($strStockId, $sym = false) 
    {
    	if ($sym == false)
    	{
    		$sym = new StockSymbol(SqlGetStockSymbol($strStockId));
    	}
    	
        if ($sym->IsIndex() || $sym->IsIndexA())
        {
        	$sql = new StockHistorySql($strStockId);
        	$this->LoadSqlData($sql);
        }
        else if ($sym->IsFundA())
        {
        	$this->LoadSinaFundData($sym);
        }
        else
        {
        	$sql = new FundHistorySql($strStockId);
        	$this->LoadSqlData($sql);
        }
        
        parent::StockReference($sym);
    }
}

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyStockReference
{
    var $strPairId = false;

    var $fNetValue = 0.0;
    var $fPairNetValue = 0.0;
    
    var $fRatio = 1.0;
    
    function EtfReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
        $strStockId = $this->GetStockId();
        $sql = new EtfCalibrationSql($strStockId);
        if ($record = $sql->pair_sql->Get())
        {
        	$this->strPairId = $record['pair_id'];
        	$this->fRatio = floatval($record['ratio']);
        	$nv_ref = new NetValueReference($strStockId, $this->GetSym());
//        	$pair_nv_ref = new NetValueReference($this->strPairId);
//        	if ($history = $sql->fund_sql->GetNow())
        	if (empty($nv_ref->strDate) == false)
        	{
//        		$strDate = $history['date'];
        		$strDate = $nv_ref->strDate;
//        		$fNetValue = floatval($history['close']);
        		$fNetValue = $nv_ref->fPrice;
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
