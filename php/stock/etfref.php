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
    var $pair_ref;
    var $cny_ref = false;

    var $fNetValue = 0.0;
    var $fPairNetValue = 0.0;
    var $fCnyValue = 1.0;
    
    var $fRatio = 1.0;

    var $strOfficialDate;	// Official net value est date
 
    function EtfReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
        $strStockId = $this->GetStockId();
       	$this->nv_ref = new NetValueReference($strStockId, $this->GetSym());
       	if ($strFactorDate = $this->_onCalibration($strStockId))
       	{
       		$this->_load_cny_ref($strFactorDate);
       	}
    }
    
	function _load_pair_ref($strStockId)
	{
		$strSymbol = SqlGetStockSymbol($strStockId);
		$sym = new StockSymbol($strSymbol);
		if ($sym->IsEtf())
		{
        	$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
			$this->pair_ref = new MyStockReference($strSymbol, $sym);
		}
		else
		{
			$this->pair_nv_ref = new IndexReference($strSymbol, $sym);
			$this->pair_ref = $this->pair_nv_ref;
		}
	}
    
	function _onCalibration($strStockId)
	{
        $sql = new EtfCalibrationSql($strStockId);
        if ($record = $sql->pair_sql->Get())
        {
			$this->_load_pair_ref($record['pair_id']);
        	$this->fRatio = floatval($record['ratio']);
        	$strFactorDate = $this->nv_ref->strDate;
        	if (empty($strFactorDate) == false)
        	{
        		$this->fNetValue = $this->nv_ref->fPrice;
        		if ($this->fFactor = $sql->GetClose($strFactorDate))
        		{
        			$this->fPairNetValue = $this->pair_nv_ref->sql->GetClose($strFactorDate);
        		}
        		else
        		{
        			if ($this->fPairNetValue = $this->pair_nv_ref->sql->GetClose($strFactorDate))
        			{
        				$this->fFactor = $this->fPairNetValue / $this->fNetValue;
        				$sql->Insert($strFactorDate, strval($this->fFactor));
        			}
        			else
        			{
        				if ($calibration = $sql->GetNow())
        				{
        					$this->fFactor = floatval($calibration['close']); 
        					$strFactorDate = $calibration['date'];
        					$this->fNetValue = $this->nv_ref->sql->GetClose($strFactorDate);
        					$this->fPairNetValue = $this->pair_nv_ref->sql->GetClose($strFactorDate);
        				}
        			}
        		}
        		return $strFactorDate;
        	}
        }
        return false;
	}

	function _load_cny_ref($strDate)
	{
    	if ($this->pair_nv_ref)
    	{
    		$strCNY = false;
    		$sym = $this->pair_nv_ref->GetSym();
    		if ($sym->IsSymbolA())
    		{
    			if ($this->sym->IsSymbolUS())			$strCNY = 'USCNY';
    			else if ($this->sym->IsSymbolH())	$strCNY = 'HKCNY';
    		}
    		else if ($sym->IsSymbolH())
    		{
    			if ($this->IsSymbolA())				$strCNY = 'HKCNY';
    		}
    		else
    		{
    			if ($this->IsSymbolA())				$strCNY = 'USCNY';
    		}
    		
    		if ($strCNY)
    		{
    			$this->cny_ref = new CnyReference($strCNY);
    			$this->fCnyValue = $this->cny_ref->GetClose($strDate);
    			// DebugVal($this->fCnyValue, '_load_cny_ref');
    		}
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
    
    function _adjustByCny($fVal, $fCny, $bSymbolA)
    {
    	if ($this->cny_ref)
    	{
    		if ($fCny == false)	$fCny = $this->cny_ref->fPrice;
    		
    		if ($bSymbolA)
    		{
    			$fVal *= $this->fCnyValue;
    			$fVal /= $fCny;
    		}
    		else
    		{
    			$fVal /= $this->fCnyValue;
    			$fVal *= $fCny;
    		}
    	}
    	return $fVal;
    }
    
    // (fEst - fPairNetValue)/(x - fNetValue) = fFactor / fRatio;
    function EstFromPair($fEst, $fCny = false)
    {
    	$fVal = ($fEst - $this->fPairNetValue) * $this->fRatio / $this->fFactor + $this->fNetValue;
    	return $this->_adjustByCny($fVal, $fCny, ($this->IsSymbolA() ? false : true));
    }

    // (x - fPairNetValue)/(fEsts - fNetValue) = fFactor / fRatio;
    function EstToPair($fEst, $fCny = false)
    {
    	$fVal = ($fEst - $this->fNetValue) * $this->fFactor / $this->fRatio + $this->fPairNetValue;
    	return $this->_adjustByCny($fVal, $fCny, $this->IsSymbolA());
    }

    function GetOfficialDate()
    {
    	return $this->strOfficialDate;
    }
    
    function _getOfficialNetValue($fCny = false)
    {
		$fEst = $this->pair_nv_ref->sql->GetClose($this->strOfficialDate);
		if ($fEst == false)	
		{
			$fEst = $this->pair_ref->fPrice;
		}
		
   		$fVal = $this->EstFromPair($fEst, $fCny);
       	$this->nv_ref->sql->UpdateEstValue($this->strOfficialDate, $fVal);
//       	DebugVal($fVal, $this->GetStockSymbol().' '.$this->strOfficialDate);
        return $fVal;
    }
    
    function EstOfficialNetValue()
    {
        $this->strOfficialDate = $this->pair_ref->strDate;
        if ($this->cny_ref)
        {
        	if ($fCny = $this->cny_ref->GetClose($this->strOfficialDate))
        	{
        		return $this->_getOfficialNetValue($fCny);
        	}
        	else
        	{	// Load last value from database
        		if ($history = $this->nv_ref->sql->GetNow())
        		{
        			$this->strOfficialDate = $history['date'];
        			return floatval($history['estimated']);
        		}
        	}
        }

        return $this->_getOfficialNetValue();
    }
}

?>
