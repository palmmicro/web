<?php

define('FUND_POSITION_RATIO', 0.95);

// ****************************** FundReference Class *******************************************************
class FundReference extends MysqlReference
{
    var $stock_ref = false;     // MyStockReference
    var $est_ref = false;       // MyStockRefenrence for fund net value estimation
    var $future_ref = false;
    var $future_etf_ref = false;

    // estimated data
    var $fOfficialNetValue = false;
    var $fFairNetValue = false;
    var $fRealtimeNetValue = false;

    var $strOfficialDate;
    
    var $sql;
    var $forex_sql;
    
    function FundReference($strSymbol) 
    {
		$sym = new StockSymbol($strSymbol);
        $this->LoadSinaFundData($sym);
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
        parent::MysqlReference($sym);

        if ($this->sym->IsFundA())
        {
            $this->stock_ref = new MyStockReference($strSymbol);
        }
        if ($strStockId = $this->GetStockId())
        {
        	if ($fVal = SqlGetStockCalibrationFactor($strStockId))		$this->fFactor = $fVal; 
        	$this->sql = new NetValueHistorySql($strStockId);
        }
    }
    
    function GetOfficialNetValue()
    {
    	if ($this->fOfficialNetValue)
    	{
    		return strval($this->fOfficialNetValue);
    	}
    	return false;
    }
    
    function GetFairNetValue()
    {
    	if ($this->fFairNetValue)
    	{
    		return strval($this->fFairNetValue);
    	}
    	return false;
    }
    
    function GetRealtimeNetValue()
    {
    	if ($this->fRealtimeNetValue)
    	{
    		return strval($this->fRealtimeNetValue);
    	}
    	return false;
    }
    
    function SetForex($strForex)
    {
        $this->forex_sql = new NetValueHistorySql(SqlGetStockId($strForex));
    }

    // Update database
    function UpdateEstNetValue()
    {
       	$fund_sql = new FundEstSql($this->GetStockId());
   		StockUpdateEstResult($this->sql, $fund_sql, $this->GetOfficialNetValue(), $this->strOfficialDate);
    }

    function UpdateOfficialNetValue()
    {
		return StockCompareEstResult($this->sql, $this->strPrice, $this->strDate, $this->GetStockSymbol());
    }

    function InsertFundCalibration($est_ref, $strEstPrice)
    {
        return SqlInsertStockCalibration($this->GetStockId(), $est_ref->GetStockSymbol(), $this->strPrice, $strEstPrice, $this->fFactor, DebugGetTimeDisplay());
    }

    function GetStockSymbol()
    {
        if ($this->stock_ref)
        {
            return $this->stock_ref->GetStockSymbol();
        }
        return parent::GetStockSymbol();
    }

    function GetStockId()
    {
        if ($this->stock_ref)
        {
            return $this->stock_ref->GetStockId();
        }
        return parent::GetStockId();
    }

    function GetPriceDisplay($strVal, $bPrev = true)
    {
    	if ($strVal)
    	{
    		if ($this->stock_ref)
    		{
    			return $this->stock_ref->GetPriceDisplay($strVal, $bPrev);
    		}
    		return parent::GetPriceDisplay($strVal, $bPrev);
    	}
        return '';
    }
    
    function GetPercentageDisplay($strVal)
    {
    	if ($strVal)
    	{
    		if ($this->stock_ref)
    		{
    			return $this->stock_ref->GetPercentageDisplay($strVal);
    		}
    		return parent::GetPercentageDisplay($strVal);
    	}
        return '';
    }
    
    function AdjustPosition($fVal)
    {
        return $fVal * FUND_POSITION_RATIO + $this->fPrice * (1.0 - FUND_POSITION_RATIO);
    }
}

?>
