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
class NetValueReference extends MysqlReference
{
	var $sql;
	var $fund_est_sql;
	
    function NetValueReference($strSymbol) 
    {
        parent::MysqlReference($strSymbol);
        
       	$this->fund_est_sql = new FundEstSql();
        if ($this->IsFundA())
        {
       		StockCompareEstResult($this->fund_est_sql, $this->GetStockId(), $this->GetPrice(), $this->GetDate(), $this->GetSymbol());
        }
    }
    
    public function LoadData()
    {
    	$strSymbol = $this->GetSymbol();
    	$this->strSqlId = SqlGetStockId($strSymbol);
        if ($this->IsFundA())
        {
        	$this->LoadSinaFundData();
        }
        else
        {
        	$this->LoadSqlData();
        }
    }

    function GetFundEstSql()
    {
    	return $this->fund_est_sql;
    }
}

// ****************************** EtfReference class *******************************************************
class EtfReference extends MyPairReference
{
	var $nav_ref;
    var $pair_nav_ref = false;
    var $cny_ref = false;

    var $strNav = '0';
    var $strPairNav = '0';
    var $fCnyValue = 1.0;
    
    var $fRatio = 1.0;

    var $strOfficialDate;	// Official net value est date
 
    function EtfReference($strSymbol) 
    {
        parent::MyPairReference($strSymbol);
       	$this->nav_ref = new NetValueReference($strSymbol);
       	if ($strFactorDate = $this->_onCalibration())
       	{
       		$this->_load_cny_ref($strFactorDate);
       	}
    }

    function GetFundEstSql()
    {
    	return $this->nav_ref->GetFundEstSql();
    }
    
    function GetPairNavRef()
    {
    	return $this->pair_nav_ref;
    }
    
    function GetNav()
    {
    	return $this->strNav;
    }
    
	function _load_pair_ref($strStockId)
	{
		$strSymbol = SqlGetStockSymbol($strStockId);
		$sym = new StockSymbol($strSymbol);
/*		if ($sym->IsSinaFuture())
		{
        	$this->pair_nav_ref = new NetValueReference($strSymbol);
			$this->pair_ref = new FutureReference($strSymbol);
			return false;
		}
		else*/ if ($sym->IsEtf())
		{
        	$this->pair_nav_ref = new NetValueReference($strSymbol);
			$this->pair_ref = new MyPairReference($strSymbol);
		}
		else
		{
			$this->pair_nav_ref = new MyStockReference($strSymbol);	// index
			if ($this->pair_nav_ref->HasData() == false)
			{
				$this->pair_nav_ref = new NetValueReference($strSymbol);
			}
			$this->pair_ref = $this->pair_nav_ref;
		}
		return true;
	}
    
 	function GetFactor($strPairNav, $strNav)
 	{
		return floatval($strPairNav) / floatval($strNav);
 	}

	function ManualCalibration()
	{
		$ar = explode(' ', YahooGetWebData($this));
		if (count($ar) < 3)	return false;
   	
		$strNav = $ar[0];
		$strDate = $ar[2];
		$strStockId = $this->GetStockId();
		$nav_sql = GetNavHistorySql();
		$nav_sql->WriteDaily($strStockId, $strDate, $strNav);
		DebugString($this->GetSymbol().' netvalue '.$strNav);
		
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
 	
	function _onNormalEtfCalibration()
	{
		$strStockId = $this->GetStockId();
		$nav_sql = GetNavHistorySql();
   		$calibration_sql = new CalibrationSql();
   		if ($calibration_sql->Count($strStockId) > 0)
   		{
   			$strDate = $calibration_sql->GetDateNow($strStockId); 
    		$ymd = new StringYMD($strDate);
    		
   			$strCurDate = $this->GetDate();
    		$cur_ymd = new StringYMD($strCurDate);
    		
    		if ($cur_ymd->GetTick() > $ymd->GetTick())
    		{
    			if ($this->strNav = $nav_sql->GetClose($strStockId, $strCurDate))
    			{
   					if ($this->strPairNav = PairNavGetClose($this->pair_nav_ref, $strCurDate))
   					{
   						$this->fFactor = $this->GetFactor($this->strPairNav, $this->strNav);
   						$calibration_sql->WriteDaily($strStockId, $strCurDate, strval($this->fFactor));
   						return $strCurDate;
   					}
    			}
    		}
			$this->strNav = $nav_sql->GetClose($strStockId, $strDate);
			$this->strPairNav = PairNavGetClose($this->pair_nav_ref, $strDate);
			$this->fFactor = $calibration_sql->GetCloseNow($strStockId);
			return $strDate;
   		}
   		else
   		{
   			if ($result = $nav_sql->GetAll($strStockId)) 
   			{
   				while ($record = mysql_fetch_assoc($result)) 
   				{
   					$strDate = $record['date'];
   					if ($this->strPairNav = PairNavGetClose($this->pair_nav_ref, $strDate))
   					{
   						$this->strNav = rtrim0($record['close']);
   						$this->fFactor = $this->GetFactor($this->strPairNav, $this->strNav);
   						$calibration_sql->WriteDaily($strStockId, $strDate, strval($this->fFactor));
   						@mysql_free_result($result);
   						return $strDate;
   					}
   				}
   				@mysql_free_result($result);
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
	function _onCalibration()
	{
        $pair_sql = new EtfPairSql($this->GetStockId());
        if ($record = $pair_sql->GetRecord())
        {
        	$this->fRatio = floatval($record['ratio']);
			if ($this->_load_pair_ref($record['pair_id']))
			{
				return $this->_onNormalEtfCalibration();
			}
//			return $this->_onFutureEtfCalibration();
        }
        return false;
	}

	function _load_cny_ref($strDate)
	{
    	if ($pair_sym = $this->GetPairSym())
    	{
    		$strCNY = false;
    		if ($pair_sym->IsSymbolA())
    		{
    			if ($this->IsSymbolUS())			$strCNY = 'USCNY';
    			else if ($this->IsSymbolH())		$strCNY = 'HKCNY';
    		}
    		else if ($pair_sym->IsSymbolH())
    		{
    			if ($this->IsSymbolA())			$strCNY = 'HKCNY';
    		}
    		else
    		{
    			if ($this->IsSymbolA())			$strCNY = 'USCNY';
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
    	if ($this->pair_nav_ref)
    	{
    		return $this->pair_nav_ref;
    	}
    	DebugString('pair_nav_ref NOT set');
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
    // fRatio * (cny_now * fEst - cny * fPairNetValue)/(x - fNetValue) = cny * fPairNetValue / fNetValue 
    // x = (fRatio * (cny_now * fEst - cny * fPairNetValue) / (cny * fPairNetValue) + 1) * fNetValue;
    function EstFromPair($strEst, $strCny = false)
    {
    	$fVal = (floatval($strEst) - floatval($this->strPairNav)) * $this->fRatio / $this->fFactor + floatval($this->strNav);
    	return $this->_adjustByCny($fVal, $strCny, ($this->IsSymbolA() ? false : true));
    }

    // (x - fPairNetValue)/(fEsts - fNetValue) = fFactor / fRatio;
    function EstToPair($fEst, $strCny = false)
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
		
   		$strVal = $this->EstFromPair($strEst, $strCny);
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
