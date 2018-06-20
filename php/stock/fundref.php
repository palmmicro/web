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
        }
    }
    
    function SetForex($strForex)
    {
        $this->forex_sql = new ForexHistorySql(SqlGetStockId($strForex));
    }

    // Update database
    function UpdateEstNetValue()
    {
        $sql = new FundHistorySql($this->GetStockId());
        $sql->UpdateEstValue($this->est_ref->strDate, $this->fOfficialNetValue);
    }

    function UpdateOfficialNetValue()
    {
        $strNetValue = $this->strPrice;
        $sql = new FundHistorySql($this->GetStockId());
        if ($strEstValue = $sql->UpdateNetValue($this->strDate, $strNetValue))
        {
            StockCompareEstResult($this->GetStockSymbol(), $strNetValue, $strEstValue);
            return true;
        }
        return false;
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

    function GetPriceDisplay($fVal)
    {
    	if ($fVal)
    	{
    		if ($this->stock_ref)
    		{
    			return $this->stock_ref->GetPriceDisplay($fVal);
    		}
    		return parent::GetPriceDisplay($fVal);
    	}
        return '';
    }
    
    function GetPercentageDisplay($fVal)
    {
    	if ($fVal)
    	{
    		if ($this->stock_ref)
    		{
    			return $this->stock_ref->GetPercentageDisplay($fVal);
    		}
    		return parent::GetPercentageDisplay($fVal);
    	}
        return '';
    }
    
    function AdjustPosition($fVal)
    {
        return $fVal * FUND_POSITION_RATIO + $this->fPrice * (1.0 - FUND_POSITION_RATIO);
    }
}

?>
