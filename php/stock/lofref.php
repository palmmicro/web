<?php

// https://markets.ft.com/data/indices/tearsheet/charts?s=SPGOGUP:REU
function LofGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SZ162411')         return 'XOP';	// '^SPSIOP'
    else if ($strSymbol == 'SZ162719')   return 'IEO'; // '^DJSOEP'
    else if ($strSymbol == 'SZ162415')   return 'XLY';	// '^IXY'
    else if (in_arrayOilLof($strSymbol)) return 'USO';
    else if ($strSymbol == 'SZ160140')   return 'SCHH';
    else if ($strSymbol == 'SZ160416')   return 'IXC';	// '^SPGOGUP'
    else if ($strSymbol == 'SZ161126')   return 'XLV';
//    else if ($strSymbol == 'F001092')   return 'IBB';
    else if ($strSymbol == 'SZ161127')   return 'XBI';
    else if ($strSymbol == 'SZ161128')   return 'XLK';
    else if ($strSymbol == 'SZ161815')   return 'DBC';
    else if ($strSymbol == 'SZ163208')   return 'XLE';
    else if ($strSymbol == 'SZ164824')   return 'INDA';
    else if (in_arrayChinaInternetLof($strSymbol))   return 'KWEB';
    else if (in_arrayBricLof($strSymbol))   return 'BKF';	// '^SPBRICNTR'
    else if ($strSymbol == 'SZ165513')   return 'GSG';
    else if (in_arraySpyLof($strSymbol))   return '^GSPC';	// 'SPY';
    else if (in_arrayQqqLof($strSymbol))   return '^NDX';	// 'QQQ';
//    else if ($strSymbol == 'SH513030')   return ;
    else if ($strSymbol == 'SH513030')   return 'DAX';		// 'EWG'
    else if (in_arrayGoldLof($strSymbol))   return 'GLD';
    else 
        return false;
}

function LofGetFutureEtfSymbol($strSymbol)
{
    if (in_arrayOilEtfLof($strSymbol))     return 'USO';
    return false;
}

function LofGetFutureSymbol($strSymbol)
{
    if ((LofGetFutureEtfSymbol($strSymbol) == 'USO') || (LofGetEstSymbol($strSymbol) == 'USO'))     return 'hf_CL';
    else if (LofGetEstSymbol($strSymbol) == 'GLD')                                                     return 'hf_GC';
    return false;
}

function LofGetAllSymbolArray($strSymbol)
{
    $ar = array();
    
    $ar[] = $strSymbol; 
    if ($strEstSymbol = LofGetEstSymbol($strSymbol))
    {
        $ar[] = $strEstSymbol; 
    }
    if ($strFutureSymbol = LofGetFutureSymbol($strSymbol))
    {
        $ar[] = $strFutureSymbol; 
    }
    if ($strFutureEtfSymbol = LofGetFutureEtfSymbol($strSymbol))
    {
        $ar[] = $strFutureEtfSymbol; 
    }
    return $ar;
}

function LofHkGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SH501025')   		 		return 'SH000869';	// '03143'
    else if (in_arrayHangSengLofHk($strSymbol))	return '^HSI';		// '02800'
    else if (in_arrayHSharesLofHk($strSymbol))	return '^HSCE';	// '02828'
    else 
        return false;
}

function LofHkGetAllSymbolArray($strSymbol)
{
    $ar = array();
    
    $ar[] = $strSymbol; 
    if ($strEstSymbol = LofHkGetEstSymbol($strSymbol))
    {
        $ar[] = $strEstSymbol; 
    }
    return $ar;
}

class _LofReference extends FundReference
{
    var $strCNY = false;
    
    function _LofReference($strSymbol, $strForex)
    {
        parent::FundReference($strSymbol);
        $this->SetForex($strForex);
    }

    function EstNetValue()
    {
		$this->AdjustFactor();
        
        if ($this->est_ref == false)    return;
        $strDate = $this->est_ref->strDate;
        if ($this->strCNY = $this->forex_sql->GetClose($strDate))
        {
            if (($strEstNetValue = SqlGetNetValueByDate($this->est_ref->GetStockId(), $strDate)) == false)
            {
            	$strEstNetValue = $this->est_ref->GetPrice();
            }
            $this->fOfficialNetValue = $this->GetLofValue($strEstNetValue, $this->strCNY);
            $this->strOfficialDate = $strDate;
            $this->UpdateEstNetValue();
        }
        else
        {   // Load last value from database
			$sql = new FundEstSql($this->GetStockId());
            if ($record = $sql->GetNow())
            {
                $this->fOfficialNetValue = floatval($record['close']);
                $this->strOfficialDate = $record['date'];
            }
        }
    }

    function EstRealtimeNetValue()
    {
        $strCNY = $this->forex_sql->GetCloseNow();
        if ($this->strCNY == false)
        {
            $this->strCNY = $strCNY;
        }
        
        if ($this->est_ref == false)    return;
        $this->fFairNetValue = $this->GetLofValue($this->est_ref->GetPrice(), $strCNY);
        
		if ($this->future_ref)
        {
            if ($this->future_etf_ref == false)
            {
                $this->future_etf_ref = $this->est_ref;
            }
            $this->future_ref->LoadEtfFactor($this->future_etf_ref);
            
            $strFutureEtfPrice = $this->future_etf_ref->GetPrice();
            if (empty($strFutureEtfPrice) == false)
            {
            	$fRealtime = floatval($this->est_ref->GetPrice());
            	$fRealtime *= floatval($this->future_ref->GetPrice()) / $this->future_ref->EstByEtf(floatval($strFutureEtfPrice));
            	$this->fRealtimeNetValue = $this->GetLofValue(strval($fRealtime), $strCNY);
            }
        }
    }

    function AdjustFactor()
    {
        if ($this->UpdateOfficialNetValue())
        {
            $strDate = $this->strDate;
            if ($strCNY = $this->forex_sql->GetClose($strDate))
            {
                $est_ref = $this->est_ref;
                if (RefHasData($est_ref) == false)    return false;
                
                if ($strEst = SqlGetNetValueByDate($this->est_ref->GetStockId(), $strDate))
                {
                }
                else
                {
                	// DebugString($strDate.' '.$this->est_ref->GetStockSymbol().' ETF net value not found, use close price.');
                	$ymd = new StringYMD($strDate);
                	$est_ymd = new StringYMD($est_ref->strDate);
                	if ($strDate == $est_ref->strDate)	                   				$strEst = $est_ref->GetPrice();
                	else if ($ymd->GetNextTradingDayTick() == $est_ymd->GetTick())		$strEst = $est_ref->GetPrevPrice();
                	else	return false;
                }
        
                $this->fFactor = floatval($strEst) * floatval($strCNY) / floatval($this->GetPrice());
                $this->InsertFundCalibration($est_ref, $strEst);
                return $this->fFactor;
            }
        }
        return false;
    }

    function GetLofValue($strEst, $strCNY)
    {
    	if ($this->fFactor)
    	{
    		$fVal = floatval($strEst) * floatval($strCNY) / $this->fFactor;
    		return $this->AdjustPosition($fVal);
    	}
    	return 0.0;
    }
    
    function GetEstValue($strLof)
    {
        return strval(floatval($strLof) * $this->fFactor / floatval($this->strCNY));
    }
    
    function GetEstQuantity($iLofQuantity)
    {
        return intval($iLofQuantity / $this->fFactor);
    }

    function GetLofQuantity($iEstQuantity)
    {
        return intval($iEstQuantity * $this->fFactor);
    }
}

class LofReference extends _LofReference
{
    function LofReference($strSymbol)
    {
        parent::_LofReference($strSymbol, 'USCNY');
        
        if ($strEstSymbol = LofGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        if ($strFutureEtfSymbol = LofGetFutureEtfSymbol($strSymbol))
        {
            $this->future_etf_ref = new MyStockReference($strFutureEtfSymbol);
        }
        if ($strFutureSymbol = LofGetFutureSymbol($strSymbol))
        {
            $this->future_ref = new FutureReference($strFutureSymbol);
        }
        
        $this->EstNetValue();
        $this->EstRealtimeNetValue();
    }
}

class LofHkReference extends _LofReference
{
    function LofHkReference($strSymbol)
    {
        parent::_LofReference($strSymbol, 'HKCNY');
        
        if ($strEstSymbol = LofHkGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        $this->EstNetValue();
        $this->EstRealtimeNetValue();
    }
}

?>
