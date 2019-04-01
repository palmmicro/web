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
    if ((LofGetFutureEtfSymbol($strSymbol) == 'USO') || (LofGetEstSymbol($strSymbol) == 'USO'))     return 'CL';
    else if (LofGetEstSymbol($strSymbol) == 'GLD')                                                     return 'GC';
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
        $ar[] = FutureGetSinaSymbol($strFutureSymbol); 
    }
    if ($strFutureEtfSymbol = LofGetFutureEtfSymbol($strSymbol))
    {
        $ar[] = $strFutureEtfSymbol; 
    }
    return $ar;
}

function LofHkGetEstSymbol($strSymbol)
{
    if ($strSymbol == 'SH501021')                 return '^SPHCMSHP';
    else if ($strSymbol == 'SH501025')   		 return 'SH000869';	// '03143'
    else if (in_arrayHangSengLofHk($strSymbol))   return '^HSI';		// '02800'
    else if (in_arrayHSharesLofHk($strSymbol))    return '^HSCE';	// '02828'
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
    var $fCNY = false;
    
    function _LofReference($strSymbol, $strForex)
    {
        parent::FundReference($strSymbol);
        $this->SetForex($strForex);
    }

    function EstNetValue()
    {
		$this->AdjustFactor();
        
        $strDate = $this->est_ref->strDate;
        if ($strCNY = $this->forex_sql->GetClose($strDate))
        {
            $this->fCNY = floatval($strCNY);
            if ($strEstNetValue = SqlGetNetValueByDate($this->est_ref->GetStockId(), $strDate))
            {
            	$fEst = floatval($strEstNetValue);
            }
            else
            {
            	$fEst = $this->est_ref->fPrice;
            }
            $this->fOfficialNetValue = $this->GetLofValue($fEst, $this->fCNY);
            $this->strOfficialDate = $strDate;
            $this->UpdateEstNetValue();
        }
        else
        {   // Load last value from database
			$sql = new FundEstSql($this->GetStockId());
            if ($history = $sql->GetNow())
            {
                $this->fOfficialNetValue = floatval($history['close']);
                $this->strOfficialDate = $history['date'];
            }
        }
        
        $this->EstRealtimeNetValue();
    }

    function EstRealtimeNetValue()
    {
        $fCNY = floatval($this->forex_sql->GetCloseNow());
        if ($this->fCNY == false)
        {
            $this->fCNY = $fCNY;
        }
        
        if ($this->est_ref == false)    return;
        $this->fFairNetValue = $this->GetLofValue($this->est_ref->fPrice, $fCNY);
        
        if ($this->future_ref)
        {
            if ($this->future_etf_ref == false)
            {
                $this->future_etf_ref = $this->est_ref;
            }
            $this->future_ref->LoadEtfFactor($this->future_etf_ref);
            
            $fRealtime = $this->est_ref->fPrice;
            $fRealtime *= $this->future_ref->fPrice / $this->future_ref->EstByEtf($this->future_etf_ref->fPrice);
            $this->fRealtimeNetValue = $this->GetLofValue($fRealtime, $fCNY);
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
                	$fEst = floatval($strEst);
                }
                else
                {
                	// DebugString($strDate.' '.$this->est_ref->GetStockSymbol().' ETF net value not found, use close price.');
                	$ymd = new StringYMD($strDate);
                	$est_ymd = new StringYMD($est_ref->strDate);
                	if ($strDate == $est_ref->strDate)	                   				$fEst = $est_ref->fPrice;
                	else if ($ymd->GetNextTradingDayTick() == $est_ymd->GetTick())		$fEst = $est_ref->fPrevPrice;
                	else	return false;
                }
        
                $this->fFactor = $fEst * floatval($strCNY) / $this->fPrice;
                $this->InsertFundCalibration($est_ref, strval($fEst));
                return $this->fFactor;
            }
        }
        return false;
    }

    function GetLofValue($fEst, $fCNY)
    {
        $fVal = $fEst * $fCNY / $this->fFactor;
        return $this->AdjustPosition($fVal); 
    }
    
    function GetEstValue($fLof)
    {
        return $fLof * $this->fFactor / $this->fCNY;
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
    // constructor 
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
    }
}

class LofHkReference extends _LofReference
{
    // constructor 
    function LofHkReference($strSymbol)
    {
        parent::_LofReference($strSymbol, 'HKCNY');
        
        if ($strEstSymbol = LofHkGetEstSymbol($strSymbol))
        {
            $this->est_ref = new MyStockReference($strEstSymbol);
        }
        $this->EstNetValue();
    }
}

?>
