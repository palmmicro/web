<?php

// ****************************** NetValueReference class *******************************************************
class NetValueReference extends StockReference
{
	var $sql;
	
    function NetValueReference($strStockId, $sym) 
    {
       	$this->sql = new FundHistorySql($strStockId);
        if ($sym->IsFundA())
        {
        	$this->LoadSinaFundData($sym);
        }
        else
        {
        	$this->LoadSqlData($this->sql);
        }

        parent::StockReference($sym);
        if ($sym->IsFundA())
        {
        	$strNetValue = $this->strPrice;
        	if ($strEstValue = $this->sql->UpdateNetValue($this->strDate, $strNetValue))
        	{
        		StockCompareEstResult($sym->GetSymbol(), $strNetValue, $strEstValue);
        	}
        }
    }
}

// ****************************** IndexReference class *******************************************************
class IndexReference extends MyStockReference
{
	var $sql;
	
    function IndexReference($strSymbol, $sym) 
    {
        parent::MyStockReference($strSymbol, $sym);
       	$this->sql = new StockHistorySql($this->GetStockId());
    }
}

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyStockReference
{
	var $nv_ref;
    var $pair_nv_ref = false;

    var $fNetValue = 0.0;
    var $fPairNetValue = 0.0;
    
    var $fRatio = 1.0;
    
    function EtfReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
        $strStockId = $this->GetStockId();
       	$this->nv_ref = new NetValueReference($strStockId, $this->GetSym());
        $sql = new EtfCalibrationSql($strStockId);
        if ($record = $sql->pair_sql->Get())
        {
			$this->_load_pair_nv_ref($record['pair_id']);
        	$this->fRatio = floatval($record['ratio']);
        	if (empty($this->nv_ref->strDate) == false)
        	{
        		$strDate = $this->nv_ref->strDate;
        		$fNetValue = $this->nv_ref->fPrice;
        		if ($fFactor = $sql->GetClose($strDate))
        		{
        			$fPairNetValue = $this->pair_nv_ref->sql->GetClose($strDate);
        		}
        		else
        		{
        			if ($fPairNetValue = $this->pair_nv_ref->sql->GetClose($strDate))
        			{
        				$fFactor = $fPairNetValue / $fNetValue;
        				$sql->Insert($strDate, strval($fFactor));
        			}
        			else
        			{
        				if ($calibration = $sql->GetNow())
        				{
        					$fFactor = floatval($calibration['close']); 
        					$fNetValue = $this->nv_ref->sql->GetClose($calibration['date']);
        					$fPairNetValue = $this->pair_nv_ref->sql->GetClose($calibration['date']);
        				}
        			}
        		}
        		$this->fFactor = $fFactor;
        		$this->fNetValue = $fNetValue;
        		$this->fPairNetValue = $fPairNetValue;
        	}
        }
    }
    
	function _load_pair_nv_ref($strStockId)
	{
		$strSymbol = SqlGetStockSymbol($strStockId);
		$sym = new StockSymbol($strSymbol);
		if ($sym->IsIndex() || $sym->IsIndexA())
		{
			$this->pair_nv_ref = new IndexReference($strSymbol, $sym);
		}
		else
		{
        	$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
		}
	}
    
    function GetPairSymbol()
    {
    	if ($this->pair_nv_ref)
    	{
    		return $this->pair_nv_ref->GetStockSymbol();
    	}
    	DebugString('pair_nv_ref NOT set');
    	return false;
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
