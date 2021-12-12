<?php
define('LOF_POSITION_RATIO', 0.95);

// ****************************** FundReference Class *******************************************************
class FundReference extends MysqlReference
{
    var $stock_ref = false;     // MyStockReference
    var $est_ref = false;       // MyStockRefenrence for fund net value estimation
    var $future_ref = false;
    var $future_etf_ref = false;
    var $cny_ref;

    // estimated data
    var $fOfficialNetValue = false;
    var $fFairNetValue = false;
    var $fRealtimeNetValue = false;

    var $strOfficialDate;
    
    var $fund_est_sql = false;
    var $calibration_sql = false;
    
    function FundReference($strSymbol) 
    {
        parent::MysqlReference($strSymbol);

        if ($this->IsFundA())
        {
            $this->stock_ref = new MyStockReference($strSymbol);
        }
        if ($strStockId = $this->GetStockId())
        {
	       	$this->fund_est_sql = new FundEstSql();
	       	$this->calibration_sql = new CalibrationSql();
        	if ($strClose = $this->calibration_sql->GetCloseNow($strStockId))		$this->fFactor = floatval($strClose); 
        }
    }
    
    function GetFundEstSql()
    {
    	return $this->fund_est_sql;
    }

    function GetTimeNow()
    {
    	if ($this->calibration_sql)
    	{
    		return $this->calibration_sql->GetTimeNow($this->GetStockId());
    	}
    	return false;
    }
    
    public function LoadData()
    {
        $this->LoadSinaFundData();
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
    }
    
    function GetNav()
    {
    	return $this->GetPrice();
    }
    
    function GetOfficialDate()
    {
    	return $this->strOfficialDate;
    }
    
    function GetOfficialNav()
    {
    	if ($this->fOfficialNetValue)
    	{
    		return strval($this->fOfficialNetValue);
    	}
    	return false;
    }
    
    function GetFairNav()
    {
    	if ($this->fFairNetValue)
    	{
    		return strval($this->fFairNetValue);
    	}
    	return false;
    }
    
    function GetRealtimeNav()
    {
    	if ($this->fRealtimeNetValue)
    	{
    		return strval($this->fRealtimeNetValue);
    	}
    	return false;
    }
    
    function SetForex($strForex)
    {
        $this->cny_ref = new CnyReference($strForex);
    }

    // Update database
    function UpdateEstNetValue()
    {
   		StockUpdateEstResult($this->GetFundEstSql(), $this->GetStockId(), $this->GetOfficialNav(), $this->GetOfficialDate());
    }

    function UpdateOfficialNetValue()
    {
		return StockCompareEstResult($this->fund_est_sql, $this->GetStockId(), $this->GetPrice(), $this->GetDate(), $this->GetSymbol());
    }

    function InsertFundCalibration($est_ref, $strEstPrice)
    {
    	$this->calibration_sql->WriteDaily($this->GetStockId(), $this->GetDate(), strval($this->fFactor));
    }

    public function GetSymbol()
    {
        if ($this->stock_ref)
        {
            return $this->stock_ref->GetSymbol();
        }
        return parent::GetSymbol();
    }

    function GetStockId()
    {
        if ($this->stock_ref)
        {
            return $this->stock_ref->GetStockId();
        }
        return parent::GetStockId();
    }

    function GetPriceDisplay($strDisp = false, $strPrev = false)
    {
   		if ($this->stock_ref)
   		{
   			return $this->stock_ref->GetPriceDisplay($strDisp, $strPrev);
   		}
   		return parent::GetPriceDisplay($strDisp, $strPrev);
    }
    
    function GetPercentageDisplay($strDivisor = false, $strDividend = false)
    {
   		if ($this->stock_ref)
   		{
   			return $this->stock_ref->GetPercentageDisplay($strDivisor, $strDividend);
   		}
   		return parent::GetPercentageDisplay($strDivisor, $strDividend);
    }
    
    function GetStockRef()
    {
    	return $this->stock_ref;
    }

    function GetEstRef()
    {
    	return $this->est_ref;
    }

    function GetFutureRef()
    {
    	return $this->future_ref;
    }

    function GetCnyRef()
    {
    	return $this->cny_ref;
    }

    function GetFundPosition()
    {
		if ($this->IsLofA())
		{
			switch ($this->GetSymbol())
			{
			case 'SZ164906':
				$fRatio = 0.85;
				break;

			default:
				$fRatio = LOF_POSITION_RATIO;
				break;
			}
    	}
		else
		{
    		$fRatio = 1.0;
		}
    	return $fRatio;
    }
    
    /* (x - x0) / x0 = r * (y - y0) / y0
    	x / x0 - 1 = r * y / y0 - r
    	x = x0 * (r * y / y0 + 1 - r) = r * (x0 * y / y0) + (1 - r) * x0 		### used in AdjustPosition
    	y = y0 * (x / x0 - 1 + r) / r = (y0 * x / x0) / r - y0 * (1 / r - 1)	### used in ReverseAdjustPosition
    */
    function AdjustPosition($fVal)
    {
    	$fRatio = $this->GetFundPosition();
        return $fRatio * $fVal + (1.0 - $fRatio) * floatval($this->GetPrice());
    }
    
    function ReverseAdjustPosition($fVal)
    {
    	$fRatio = $this->GetFundPosition();
        return $fVal / $fRatio - floatval($this->GetPrice()) * (1.0 / $fRatio - 1.0);
    }
}

?>
