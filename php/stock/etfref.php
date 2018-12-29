<?php

// ****************************** NetValueReference class *******************************************************
class NetValueReference extends StockReference
{
	var $sql;
	
    function NetValueReference($strStockId, $sym) 
    {
       	$this->sql = new NavHistorySql($strStockId);
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
       		StockCompareEstResult($this->sql, $this->strPrice, $this->strDate, $this->GetStockSymbol());
        }
    }
    
    function GetStockId()
    {
    	return $this->sql->GetKeyId();
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

    var $sql;
    
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
        $this->sql = new EtfCalibrationSql($strStockId);
       	if ($strFactorDate = $this->_onCalibration())
       	{
       		$this->_load_cny_ref($strFactorDate);
       	}
    }
    
	function _load_pair_ref($strStockId)
	{
		$strSymbol = SqlGetStockSymbol($strStockId);
		$sym = new StockSymbol($strSymbol);
		if ($strFutureSymbol = $sym->IsSinaFuture())
		{
        	$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
			$this->pair_ref = new FutureReference($strFutureSymbol);
			return false;
		}
		else if ($sym->IsEtf())
		{
        	$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
			$this->pair_ref = new MyStockReference($strSymbol, $sym);
		}
		else
		{
			$this->pair_nv_ref = new IndexReference($strSymbol, $sym);
			if ($this->pair_nv_ref->HasData() == false)
			{
				$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
			}
			$this->pair_ref = $this->pair_nv_ref;
		}
		return true;
	}
    
	function _insertCalibartion($strFactorDate)
	{
		$this->fFactor = $this->fPairNetValue / $this->fNetValue;
		$this->sql->Write($strFactorDate, strval($this->fFactor));
	}
	
	function _loadCalibartion()
	{
		if ($calibration = $this->sql->GetNow())
		{
			$this->fFactor = floatval($calibration['close']); 
			$strDate = $calibration['date'];
			$this->fNetValue = $this->nv_ref->sql->GetClose($strDate);
			$this->fPairNetValue = $this->pair_nv_ref->sql->GetClose($strDate);
			return $strDate;
		}

		// This is NOT normal
        DebugString('Missing calibration record');
        return false;
 	}
	
	function _onNormalEtfCalibration()
	{
       	$strDate = $this->nv_ref->strDate;
       	if (empty($strDate) == false)
       	{
        	$this->fNetValue = $this->nv_ref->fPrice;
        	if ($this->fFactor = $this->sql->GetClose($strDate))
        	{
        		$this->fPairNetValue = $this->pair_nv_ref->sql->GetClose($strDate);
        	}
        	else
        	{
        		if ($this->fPairNetValue = $this->pair_nv_ref->sql->GetClose($strDate))
        		{
        			$this->_insertCalibartion($strDate);
        		}
        		else
        		{
        			$strDate = $this->_loadCalibartion();
        		}
        	}
        	return $strDate;
        }
        return false;
	}
	
	function _onFutureEtfCalibration()
	{
		if ($this->CheckAdjustFactorTime($this->pair_ref))
		{
			$strDate = $this->strDate;
			$this->fPairNetValue = $this->pair_ref->fPrice;
			$this->fNetValue = $this->fPrice;
   			$this->_insertCalibartion($strDate);
   			$this->nv_ref->sql->Insert($strDate, $this->fNetValue);
   			$this->pair_nv_ref->sql->Insert($strDate, $this->fPairNetValue);
   			return $strDate;
		}
		return $this->_loadCalibartion();
	}
	
	function _onCalibration()
	{
        if ($record = $this->sql->pair_sql->Get())
        {
        	$this->fRatio = floatval($record['ratio']);
			if ($this->_load_pair_ref($record['pair_id']))
			{
				return $this->_onNormalEtfCalibration();
			}
			return $this->_onFutureEtfCalibration();
        }
        return false;
	}

	function _load_cny_ref($strDate)
	{
    	if ($sym = $this->GetPairSym())
    	{
    		$strCNY = false;
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
	
 	function GetPairSym()
    {
    	if ($this->pair_nv_ref)
    	{
    		return $this->pair_nv_ref->GetSym();
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
    
    function _estOfficialNetValue($fund_sql, $fCny = false)
    {
		$fEst = $this->pair_nv_ref->sql->GetClose($this->strOfficialDate);
		if ($fEst == false)	
		{
			$fEst = $this->pair_ref->fPrice;
		}
		
   		$fVal = $this->EstFromPair($fEst, $fCny);
   		StockUpdateEstResult($this->nv_ref->sql, $fund_sql, $fVal, $this->strOfficialDate);
        return $fVal;
    }
    
    function EstOfficialNetValue()
    {
        $this->strOfficialDate = $this->pair_ref->strDate;
   		$fund_sql = new FundHistorySql($this->nv_ref->GetStockId());
        if ($this->cny_ref)
        {
        	if ($fCny = $this->cny_ref->GetClose($this->strOfficialDate))
        	{
        		return $this->_estOfficialNetValue($fund_sql, $fCny);
        	}
        	else
        	{	// Load last value from database
        		if ($history = $fund_sql->GetNow())
        		{
        			$this->strOfficialDate = $history['date'];
        			return floatval($history['estimated']);
        		}
        	}
        }

        return $this->_estOfficialNetValue($fund_sql);
    }
}

?>
