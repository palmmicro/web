<?php

define('FUND_POSITION_RATIO', 0.95);
define('FUND_EMPTY_NET_VALUE', '0');

function GetEstErrorPercentage($fEstValue, $fNetValue)
{
    if (abs($fEstValue - $fNetValue) < 0.0005)
    {
        $fPercentage = 0.0;
    }
    else
    {
        $fPercentage = StockGetPercentage($fEstValue, $fNetValue);
    }
    return $fPercentage;
}

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
        $strSqlId = $this->GetStockId();
        $strDate = $this->est_ref->strDate;
        list($strDummy, $strTime) = explodeDebugDateTime();
        $strEstValue = strval($this->fOfficialNetValue);
        if ($history = SqlGetFundHistoryByDate($strSqlId, $strDate))
        {
            if ($history['close'] == FUND_EMPTY_NET_VALUE)
            {   // Only update when official net value is not ready
                SqlUpdateFundHistory($history['id'], FUND_EMPTY_NET_VALUE, $strEstValue, $strTime);
            }
        }
        else
        {
            SqlInsertFundHistory($strSqlId, $strDate, FUND_EMPTY_NET_VALUE, $strEstValue, $strTime);
        }
    }

    function _compareEstResult($strNetValue, $strEstValue)
    {
        $fPercentage = GetEstErrorPercentage(floatval($strEstValue), floatval($strNetValue));
        if (abs($fPercentage) > 1.0)
        {
            $strSymbol = $this->GetStockSymbol();
            $strLink = GetNetValueHistoryLink($strSymbol);
            $str = sprintf('%s%s 实际值%s 估值%s 误差:%.2f%%, 从_compareEstResult函数调用.', $strSymbol, $strLink, $strNetValue, $strEstValue, $fPercentage); 
            EmailReport($str, 'Netvalue estimation error');
        }
    }
    
    function UpdateOfficialNetValue()
    {
        $strDate = $this->strDate;
        $ymd = new StringYMD($strDate);
        if ($ymd->IsWeekend())     return false;   // sina fund may provide wrong weekend data

        $strSqlId = $this->GetStockId();
        $strNetValue = $this->strPrice;
        if ($history = SqlGetFundHistoryByDate($strSqlId, $strDate))
        {
            if ($history['close'] == FUND_EMPTY_NET_VALUE)
            {
                $strEstValue = $history['estimated'];
                SqlUpdateFundHistory($history['id'], $strNetValue, $strEstValue, $history['time']);
                $this->_compareEstResult($strNetValue, $strEstValue);
            }
            else
            {
                return false;
            }
        }
        else
        {
            SqlInsertFundHistory($strSqlId, $strDate, $strNetValue, '0', '0');
        }
        return true;
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
        return $fVal * FUND_POSITION_RATIO + $this->fPrevPrice * (1.0 - FUND_POSITION_RATIO);
    }
}

?>
