<?php

define ('FUND_POSITION_RATIO', 0.95);
define ('FUND_EMPTY_NET_VALUE', '0');

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

// ****************************** Private functions *******************************************************

function _getSinaFundStr($sym, $strFundSymbol, $strFileName)
{
    if (($str = IsNewDailyQuotes($sym, $strFileName, false, _GetFundQuotesYMD)) === false)
    {
        $str = GetSinaQuotes($strFundSymbol);
        if ($str)   file_put_contents($strFileName, $str);
        else         $str = file_get_contents($strFileName);
    }
    return $str;
}

// ****************************** FundReference Class *******************************************************

class FundReference extends MysqlReference
{
    // original data
//    var $strPrevNetValue;      // Most recent net value orginal data is in StockReference::$strPrevPrice 

    var $est_ref = false;       // MyStockRefenrence for fund net value estimation
    var $stock_ref = false;     // MyStockReference
    var $index_ref = false;
    var $etf_ref = false;
    var $future_ref = false;
    var $future_etf_ref = false;

    // estimated float point data 
    var $fRealtimeNetValue = false;
    var $fFairNetValue = false;

    var $strOfficialDate = false;
    
    var $fFactor = 1.0;
    
    var $strForexSymbol;
    var $strForexSqlId;
    
    function SetForex($strForex)
    {
        $this->strForexSymbol = $strForex;
        $this->strForexSqlId = SqlGetStockId($this->strForexSymbol);
    }

    function GetForexNow()
    {
        return SqlGetForexNow($this->strForexSqlId);
    }
    
    // Update database
    function UpdateEstNetValue()
    {
        $strSqlId = $this->GetStockId();
        $strDate = $this->est_ref->strDate;
        list($strDummy, $strTime) = explodeDebugDateTime();
        $strPrice = strval($this->fPrice);
        if ($history = SqlGetFundHistoryByDate($strSqlId, $strDate))
        {
            if ($history['netvalue'] == FUND_EMPTY_NET_VALUE)
            {   // Only update when official net value is not ready
                SqlUpdateFundHistory($history['id'], FUND_EMPTY_NET_VALUE, $strPrice, $strTime);
            }
        }
        else
        {
            SqlInsertFundHistory($strSqlId, $strDate, FUND_EMPTY_NET_VALUE, $strPrice, $strTime);
        }
    }

    function _compareEstResult($strNetValue, $strEstValue)
    {
        $fPercentage = GetEstErrorPercentage(floatval($strEstValue), floatval($strNetValue));
        if (abs($fPercentage) > 1.0)
        {
            $strSymbol = $this->GetStockSymbol();
            $strLink = GetNetValueHistoryLink($strSymbol, true);
            $str = sprintf('%s%s 实际值%s 估值%s 误差:%.2f%%, 从_compareEstResult函数调用.', $strSymbol, $strLink, $strNetValue, $strEstValue, $fPercentage); 
            EmailDebug($str, 'Netvalue estimation error');
        }
    }
    
    function UpdateOfficialNetValue()
    {
        $strDate = $this->strDate;
        $ymd = new YMDString($strDate);
        if ($ymd->IsWeekend())     return false;   // sina fund may provide wrong weekend data

        $strSqlId = $this->GetStockId();
        $strNetValue = $this->strPrevPrice;
        if ($history = SqlGetFundHistoryByDate($strSqlId, $strDate))
        {
            if ($history['netvalue'] == FUND_EMPTY_NET_VALUE)
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
        return SqlInsertStockCalibration($this->GetStockId(), $est_ref->GetStockSymbol(), $this->strPrevPrice, $strEstPrice, $this->fFactor, DebugGetTimeDisplay());
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

    function AdjustPosition($fVal)
    {
        return $fVal * FUND_POSITION_RATIO + $this->fPrevPrice * (1.0 - FUND_POSITION_RATIO);
    }
    
    function LoadSinaFundData()
    {
        $sym = $this->sym;
        $this->strExternalLink = GetSinaFundLink($sym);
        
        if ($sym->IsSinaFund())	$strFundSymbol = $sym->strSymbol;
        else						$strFundSymbol = $sym->GetSinaFundSymbol();
        $this->strFileName = DebugGetSinaFileName($strFundSymbol);
        
        $ar = explodeQuote(_getSinaFundStr($sym, $strFundSymbol, $this->strFileName));
        if (count($ar) < 4)
        {
            $this->bHasData = false;
            return;
        }
        
        $this->strPrice = '0.0';
        $this->strPrevPrice = $ar[1];   // net value
//        $this->strPrevNetValue = $ar[3];
        
        $this->strDate = $ar[4];
        $this->strName = $ar[0];

        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
    }
	
    // constructor 
    function FundReference($strSymbol) 
    {
        $this->_newStockSymbol($strSymbol);
        $this->LoadSinaFundData();
        parent::MysqlReference($strSymbol);

        if ($this->sym->IsFundA())
        {
            $this->stock_ref = new MyStockReference($strSymbol);
        }
        if ($strStockId = $this->GetStockId())
        {
        	if ($fVal = SqlGetStockCalibrationFactor($strStockId))		$this->fFactor = $fVal; 
        }
    }
}

?>
