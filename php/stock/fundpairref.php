<?php

function PairNavGetClose($ref, $strDate)
{
	if (method_exists($ref, 'GetFundEstSql'))
	{
		$sql = GetNavHistorySql();
	}
	else
	{
		$sql = GetStockHistorySql();
	}
    return $sql->GetClose($ref->GetStockId(), $strDate);
}

class MyPairReference extends MyStockReference
{
	var $pair_sql = false;
	
    var $pair_ref = false;
    var $cny_ref = false;
    
	var $calibration_sql;
	var $fCalibrationVal = false;

    var $fRatio;
	
    public function __construct($strSymbol) 
    {
        parent::__construct($strSymbol);
        if ($this->pair_sql)
        {
        	if ($strPair = $this->pair_sql->GetPairSymbol($strSymbol))	
        	{
        		$this->pair_ref = new MyStockReference($strPair);
        		$strCNY = false;
        		if ($this->pair_ref->IsSymbolA())
        		{
        			if ($this->IsSymbolA())
        			{
        				if ($this->pair_ref->IsShangHaiB())			$strCNY = 'USCNY';
						else if ($this->pair_ref->IsShenZhenB())		$strCNY = 'HKCNY';
        			}
//        			else if ($this->IsSymbolH())		$strCNY = 'HKCNY';
        			else if ($this->IsSymbolUS())	$strCNY = 'USCNY';
        		}
        		else if ($this->pair_ref->IsSymbolH())
        		{
        			if ($this->IsSymbolA())			$strCNY = 'HKCNY';
					else if ($this->IsSymbolUS())	$this->cny_ref = new HkdUsdReference();
        		}
        		else
        		{
        			if ($this->IsSymbolA())			$strCNY = 'USCNY';
        		}
        		if ($strCNY)		$this->cny_ref = new CnyReference($strCNY);
    		}
    	}
    	
       	$this->fRatio = RefGetPosition($this);
		$this->calibration_sql = new CalibrationSql();
		$strStockId = $this->GetStockId();
/*		if ($strClose = $this->calibration_sql->GetCloseNow($strStockId))
		{
			$this->fFactor = floatval($strClose);
			$this->fCalibrationVal = floatval(SqlGetNavByDate($strStockId, $this->calibration_sql->GetDateNow($strStockId))); 
		}*/
    	if ($record = $this->calibration_sql->GetRecordNow($strStockId))
    	{
			$this->fFactor = floatval($record['close']);
			$this->fCalibrationVal = floatval(SqlGetNavByDate($strStockId, $record['date'])); 
    	}
		else	$this->fFactor = 1.0 / $this->fRatio; 
    }
    
    function GetRatio()
    {
    	return $this->fRatio;
    }
    
    function GetPairRef()
    {
    	return $this->pair_ref;
    }
    
    function GetCnyRef()
    {
    	return $this->cny_ref;
    }
    
    function GetDefaultCny($strDate = false)
    {
		return $this->cny_ref ? $this->cny_ref->GetVal($strDate) : 1.0;
    }
    
    function EstFromPair($fPairVal = false, $fCny = false)
    {
    	if ($fPairVal == false)	$fPairVal = floatval($this->pair_ref->GetPrice());
    	if ($fCny == false)		$fCny = $this->GetDefaultCny();
    	
		$fVal = QdiiGetVal($fPairVal, $fCny, $this->fFactor);
		return FundAdjustPosition($this->fRatio, $fVal, ($this->fCalibrationVal ? $this->fCalibrationVal : $fVal));
    }
    
    function EstToPair($fMyVal = false, $fCny = false)
    {
    	if ($fMyVal == false)	$fMyVal = floatval($this->GetPrice());
    	if ($fCny == false)		$fCny = $this->GetDefaultCny();
    	
		$fVal = FundReverseAdjustPosition($this->fRatio, $fMyVal, ($this->fCalibrationVal ? $this->fCalibrationVal : $fMyVal));
		return QdiiGetPeerVal($fVal, $fCny, $this->fFactor);
    }
    
    function GetPriceRatio($strDate = false)
    {
    	if ($this->pair_ref)
    	{
    		if ($strDate)
    		{
    			$strPrice = $this->GetClose($strDate);
    			$strPair = $this->pair_ref->GetClose($strDate);
    		}
    		else
    		{
    			$strPrice = $this->GetPrice();
    			$strPair = $this->pair_ref->GetPrice();
    		}
    		if ((empty($strPrice) == false) && (empty($strPair) == false))		return floatval($strPrice) / $this->EstFromPair(floatval($strPair), $this->GetDefaultCny($strDate));
    	}
    	return 1.0;
    }
}

class AbPairReference extends MyPairReference
{
    public function __construct($strSymbolA) 
    {
        $this->pair_sql = new AbPairSql();
        parent::__construct($strSymbolA);
    }
}

class AdrPairReference extends MyPairReference
{
    public function __construct($strAdr) 
    {
        $this->pair_sql = new AdrPairSql();
        parent::__construct($strAdr);
    }
}

class AhPairReference extends MyPairReference
{
    public function __construct($strSymbolA) 
    {
        $this->pair_sql = new AhPairSql();
        parent::__construct($strSymbolA);
    }
}

class FundPairReference extends MyPairReference
{
	var $nav_ref;
    var $pair_nav_ref = false;

    var $strNav = '0';
    var $strPairNav = '0';
    var $fCnyValue = 1.0;
    
    var $strOfficialDate;	// Official net value est date
 
    public function __construct($strSymbol) 
    {
        $this->pair_sql = new FundPairSql();
        parent::__construct($strSymbol);
        
       	$this->nav_ref = new NetValueReference($strSymbol);
       	if ($strDate = $this->_onCalibration($strSymbol))
       	{
			if ($cny_ref = $this->GetCnyRef())		$this->fCnyValue = floatval($cny_ref->GetClose($strDate));
       	}
    }

    function GetFundEstSql()
    {
    	return $this->nav_ref->GetFundEstSql();
    }
    
    function GetNavRef()
    {
    	return $this->nav_ref;
    }
    
    function GetPairNavRef()
    {
    	return $this->pair_nav_ref;
    }
    
    function GetNav()
    {
    	return $this->strNav;
    }
    
	function _load_pair_ref($strSymbol)
	{
		$sym = new StockSymbol($strSymbol);
/*		if ($sym->IsSinaFuture())
		{
        	$this->pair_nav_ref = new NetValueReference($strSymbol);
			return false;
		}
		else*/ if ($sym->IsEtf())
		{
        	$this->pair_nav_ref = new NetValueReference($strSymbol);
		}
		else
		{
			$this->pair_nav_ref = $this->pair_ref;
		}
		return true;
	}
    
 	function GetFactor($strPairNav, $strNav)
 	{
		return floatval($strPairNav) / floatval($strNav);
 	}

	function ManualCalibration()
	{
		$ar = YahooGetNetValue($this);
		if (!$ar)	return false;
   	
		list($strNav, $strDate) = $ar;
		$strStockId = $this->GetStockId();
		$nav_sql = GetNavHistorySql();
		$nav_sql->WriteDaily($strStockId, $strDate, $strNav);
//		DebugString($this->GetSymbol().' netvalue '.$strNav);
		
		if ($strPairNav = PairNavGetClose($this->pair_nav_ref, $strDate))
		{
			$this->strPairNav = $strPairNav; 
			$this->strNav = $strNav; 
			$this->fFactor = $this->GetFactor($this->strPairNav, $this->strNav);
//			DebugString($this->strPairNav.' '.$this->strNav);
			$calibration_sql = new CalibrationSql();
   			if ($strDate != $calibration_sql->GetDateNow($strStockId))
   			{
   				if ($this->cny_ref)	$this->fCnyValue = floatval($this->cny_ref->GetClose($strDate));
   			}
   			$calibration_sql->WriteDaily($strStockId, $strDate, strval($this->fFactor));
		}

		return $strNav;
	}

	function _onNavResultCalibration($result, $calibration_sql, $strStockId)
	{
		while ($record = mysqli_fetch_assoc($result)) 
		{
			$this->strNav = rtrim0($record['close']);
			$strDate = $record['date'];
			if ($this->strPairNav = PairNavGetClose($this->pair_nav_ref, $strDate))
			{
				$this->fFactor = $this->GetFactor($this->strPairNav, $this->strNav);
				$calibration_sql->WriteDaily($strStockId, $strDate, strval($this->fFactor));
   				mysqli_free_result($result);
   				return $strDate;
   			}
   		}
   		mysqli_free_result($result);
   		return false;
   	}
 	
	function _onNormalEtfCalibration()
	{
		$strStockId = $this->GetStockId();
		$nav_sql = GetNavHistorySql();
   		$calibration_sql = new CalibrationSql();
   		if ($calibration_sql->Count($strStockId) > 0)
   		{
   			$strDate = $calibration_sql->GetDateNow($strStockId); 
   			if ($result = $nav_sql->GetToDate($strStockId, $strDate)) 
   			{
   				if ($strCalibrationDate = $this->_onNavResultCalibration($result, $calibration_sql, $strStockId))
   				{
   					return $strCalibrationDate; 
   				}
   			}
			$this->strNav = $nav_sql->GetClose($strStockId, $strDate);
			$this->strPairNav = PairNavGetClose($this->pair_nav_ref, $strDate);
			$this->fFactor = $calibration_sql->GetCloseNow($strStockId);
//			DebugVal($this->fFactor, __FUNCTION__, true); 
			return $strDate;
   		}
   		else
   		{
   			if ($result = $nav_sql->GetAll($strStockId)) 
   			{
   				if ($strCalibrationDate = $this->_onNavResultCalibration($result, $calibration_sql, $strStockId))
   				{
   					return $strCalibrationDate; 
   				}
   			}
   		}
        return false;
	}
/*	
	function _onFutureEtfCalibration()
	{
		$nav_sql = GetNavHistorySql();
		if ($this->CheckAdjustFactorTime($this->pair_ref))
		{
			$strDate = $this->GetDate();
   			$nav_sql->WriteDaily($this->GetStockId(), $strDate, $this->GetPrice());
   			$nav_sql->WriteDaily($this->pair_nav_ref->GetStockId(), $strDate, $this->pair_ref->GetPrice());
		}
		return $this->_onNormalEtfCalibration();
	}
*/	

	function _onCalibration($strSymbol)
	{
        if ($strPair = $this->pair_sql->GetPairSymbol($strSymbol))
        {
			if ($this->_load_pair_ref($strPair))
			{
				return $this->_onNormalEtfCalibration();
			}
//			return $this->_onFutureEtfCalibration();
        }
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
    	return $fVal;
    }
    
    // (fEst - fPairNetValue)/(x - fNetValue) = fFactor / fRatio;
    // fRatio * (cny_now * fEst - cny * fPairNetValue)/(x - fNetValue) = cny * fPairNetValue / fNetValue 
    // x = (fRatio * (cny_now * fEst - cny * fPairNetValue) / (cny * fPairNetValue) + 1) * fNetValue;
    function EstFromPair($strEst = false, $strCny = false)
    {
//		DebugVal($this->fFactor, __FUNCTION__, true); 
    	$fVal = (floatval($strEst) - floatval($this->strPairNav)) * $this->fRatio / $this->fFactor + floatval($this->strNav);
    	return $this->_adjustByCny($fVal, $strCny, ($this->IsSymbolA() ? false : true));
    }

    // (x - fPairNetValue)/(fEsts - fNetValue) = fFactor / fRatio;
    function EstToPair($fEst = false, $strCny = false)
    {
    	$fVal = ($fEst - floatval($this->strNav)) * $this->fFactor / $this->fRatio + floatval($this->strPairNav);
    	return $this->_adjustByCny($fVal, $strCny, $this->IsSymbolA());
    }

    function GetOfficialDate()
    {
    	return $this->strOfficialDate;
    }
    
    function _estOfficialNetValue($strCny = false)
    {
		if (($strEst = PairNavGetClose($this->pair_nav_ref, $this->strOfficialDate)) == false)
		{
			$strEst = $this->pair_ref->GetPrice();
		}
		
   		$strVal = strval($this->EstFromPair($strEst, $strCny));
   		StockUpdateEstResult($this->GetFundEstSql(), $this->GetStockId(), $strVal, $this->strOfficialDate);
        return $strVal;
    }
    
    function GetOfficialNav()
    {
        $this->strOfficialDate = $this->pair_ref->GetDate();
        if ($this->cny_ref)
        {
        	if ($strCny = $this->cny_ref->GetClose($this->strOfficialDate))
        	{
        		return $this->_estOfficialNetValue($strCny);
        	}
        	else
        	{	// Load last value from database
        		$fund_est_sql = $this->GetFundEstSql();
        		if ($record = $fund_est_sql->GetRecordNow($this->GetStockId()))
        		{
        			$this->strOfficialDate = $record['date'];
        			return $record['close'];
        		}
        	}
        }

        return $this->_estOfficialNetValue();
    }

    function GetFairNav()
    {
    	return false;
    }
}

?>
