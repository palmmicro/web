<?php

// ****************************** MyPairReference class *******************************************************
class MyPairReference extends MyStockReference
{
    var $pair_ref = false;

    function MyPairReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
    }
    
    function GetPairRef()
    {
    	return $this->pair_ref;
    }
}

// ****************************** AbPairReference class *******************************************************
class AbPairReference extends MyPairReference
{
    var $ab_sql;

    function AbPairReference($strSymbolA) 
    {
        parent::MyPairReference($strSymbolA);
        $this->ab_sql = new AbPairSql();
    	if ($strSymbolB = $this->ab_sql->GetPairSymbol($strSymbolA))
    	{
    		$this->pair_ref = new MyStockReference($strSymbolB);
    	}
    }
}

// ****************************** AhPairReference class *******************************************************
class AhPairReference extends MyPairReference
{
    var $ah_sql;

    function AhPairReference($strSymbolA) 
    {
        parent::MyPairReference($strSymbolA);
        $this->ah_sql = new AhPairSql();
    	if ($strSymbolH = $this->ah_sql->GetPairSymbol($strSymbolA))
    	{
    		$this->pair_ref = new MyStockReference($strSymbolH);
    	}
    }
}

// ****************************** NetValueReference class *******************************************************
class NetValueReference extends StockReference
{
	var $sql;
	
    function NetValueReference($strStockId, $sym) 
    {
       	$this->sql = new NetValueHistorySql($strStockId);
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
       	$this->sql = $this->his_sql;
    }
}

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyPairReference
{
	var $nv_ref;
    var $pair_nv_ref = false;
    var $cny_ref = false;

    var $strNetValue = '0';
    var $strPairNetValue = '0';
    var $fCnyValue = 1.0;
    
    var $fRatio = 1.0;

    var $strOfficialDate;	// Official net value est date
 
    function EtfReference($strSymbol) 
    {
        parent::MyPairReference($strSymbol);
        $strStockId = $this->GetStockId();
       	$this->nv_ref = new NetValueReference($strStockId, $this->GetSym());
       	if ($strFactorDate = $this->_onCalibration())
       	{
       		$this->_load_cny_ref($strFactorDate);
       	}
    }
    
    function GetNetValue()
    {
    	return $this->strNetValue;
    }
    
	function _load_pair_ref($strStockId)
	{
		$strSymbol = SqlGetStockSymbol($strStockId);
		$sym = new StockSymbol($strSymbol);
		if ($sym->IsSinaFuture())
		{
        	$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
			$this->pair_ref = new FutureReference($strSymbol);
			return false;
		}
		else if ($sym->IsEtf())
		{
        	$this->pair_nv_ref = new NetValueReference($strStockId, $sym);
			$this->pair_ref = new MyPairReference($strSymbol, $sym);
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
    
 	function GetFactor($strPairNetValue, $strNetValue)
 	{
		return floatval($strPairNetValue) / floatval($strNetValue);
 	}
 	
	function _onNormalEtfCalibration()
	{
    	if ($result = $this->nv_ref->sql->GetAll()) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$strDate = $record['date'];
        		if ($this->strPairNetValue = $this->pair_nv_ref->sql->GetClose($strDate))
        		{
        			$this->strNetValue = rtrim0($record['close']);
        			$this->fFactor = $this->GetFactor($this->strPairNetValue, $this->strNetValue);
        			@mysql_free_result($result);
        			return $strDate;
        		}
    		}
    		@mysql_free_result($result);
    	}
        return false;
	}
	
	function _onFutureEtfCalibration()
	{
		if ($this->CheckAdjustFactorTime($this->pair_ref))
		{
			$strDate = $this->strDate;
   			$this->nv_ref->sql->Write($strDate, $this->GetPrice());
   			$this->pair_nv_ref->sql->Write($strDate, $this->pair_ref->GetPrice());
		}
		return $this->_onNormalEtfCalibration();
	}
	
	function _onCalibration()
	{
        $pair_sql = new EtfPairSql($this->GetStockId());
        if ($record = $pair_sql->Get())
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
		$sym = $this->GetSym();
    	if ($pair_sym = $this->GetPairSym())
    	{
    		$strCNY = false;
    		if ($pair_sym->IsSymbolA())
    		{
    			if ($sym->IsSymbolUS())			$strCNY = 'USCNY';
    			else if ($sym->IsSymbolH())		$strCNY = 'HKCNY';
    		}
    		else if ($pair_sym->IsSymbolH())
    		{
    			if ($sym->IsSymbolA())			$strCNY = 'HKCNY';
    		}
    		else
    		{
    			if ($sym->IsSymbolA())			$strCNY = 'USCNY';
    		}
    		
    		if ($strCNY)
    		{
    			$this->cny_ref = new CnyReference($strCNY);
    			$this->fCnyValue = floatval($this->cny_ref->GetClose($strDate));
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
    
    function _adjustByCny($fVal, $strCny, $bSymbolA)
    {
    	if ($this->cny_ref)
    	{
    		$fCny = $strCny ? floatval($strCny) : floatval($this->cny_ref->GetPrice());
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
    	return strval($fVal);
    }
    
    // (fEst - fPairNetValue)/(x - fNetValue) = fFactor / fRatio;
    function EstFromPair($strEst, $strCny = false)
    {
    	$fVal = (floatval($strEst) - floatval($this->strPairNetValue)) * $this->fRatio / $this->fFactor + floatval($this->strNetValue);
    	return $this->_adjustByCny($fVal, $strCny, ($this->sym->IsSymbolA() ? false : true));
    }

    // (x - fPairNetValue)/(fEsts - fNetValue) = fFactor / fRatio;
    function EstToPair($fEst, $strCny = false)
    {
    	$fVal = ($fEst - floatval($this->strNetValue)) * $this->fFactor / $this->fRatio + floatval($this->strPairNetValue);
    	return $this->_adjustByCny($fVal, $strCny, $this->sym->IsSymbolA());
    }

    function GetOfficialDate()
    {
    	return $this->strOfficialDate;
    }
    
    function _estOfficialNetValue($fund_sql, $strCny = false)
    {
		if (($strEst = $this->pair_nv_ref->sql->GetClose($this->strOfficialDate)) == false)
		{
			$strEst = $this->pair_ref->GetPrice();
		}
		
   		$strVal = $this->EstFromPair($strEst, $strCny);
   		StockUpdateEstResult($this->nv_ref->sql, $fund_sql, $strVal, $this->strOfficialDate);
        return $strVal;
    }
    
    function GetOfficialNetValue()
    {
        $this->strOfficialDate = $this->pair_ref->strDate;
   		$fund_sql = new FundEstSql($this->nv_ref->GetStockId());
        if ($this->cny_ref)
        {
        	if ($strCny = $this->cny_ref->GetClose($this->strOfficialDate))
        	{
        		return $this->_estOfficialNetValue($fund_sql, $strCny);
        	}
        	else
        	{	// Load last value from database
        		if ($record = $fund_sql->GetNow())
        		{
        			$this->strOfficialDate = $record['date'];
        			return $record['close'];
        		}
        	}
        }

        return $this->_estOfficialNetValue($fund_sql);
    }

    function GetFairNetValue()
    {
    	return false;
    }
    
    function GetRealtimeNetValue()
    {
    	return false;
    }
}

function EtfRefManualCalibration($ref)
{
   	$ar = explode(' ', YahooGetWebData($ref));
   	if (count($ar) < 3)	return false;
   	
   	$strNetValue = $ar[0];
   	$strDate = $ar[2];
	$ref->nv_ref->sql->Write($strDate, $strNetValue);
	DebugString($ref->GetStockSymbol().' netvalue '.$strNetValue);
    return $strNetValue;
}

?>
