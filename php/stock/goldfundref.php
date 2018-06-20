<?php

function GoldEtfGetCnFutureSymbol($strSymbol)
{
    if ($strSymbol == 'SZ161226')   return 'AG0';
    return 'AU0';
}

function GoldEtfGetFutureSymbol($strSymbol)
{
    if ($strSymbol == 'SZ161226')   return 'SI';
    return 'GC';
}

function GoldEtfGetAllSymbolArray($strSymbol)
{
    $strCnFutureSymbol = GoldEtfGetCnFutureSymbol($strSymbol);
    $strFutureSymbol = GoldEtfGetFutureSymbol($strSymbol);
    return array($strSymbol, FutureGetSinaSymbol($strCnFutureSymbol), FutureGetSinaSymbol($strFutureSymbol));
}

class GoldFundReference extends FundReference
{
    // constructor 
    function GoldFundReference($strSymbol)
    {
        parent::FundReference($strSymbol);
        $this->SetForex('USCNY');
        $this->est_ref = new FutureReference(GoldEtfGetCnFutureSymbol($strSymbol));
        $this->future_ref = new FutureReference(GoldEtfGetFutureSymbol($strSymbol));
        $this->EstNetValue();
    }

    function _estGoldEtf($fEst)
    {
        $fVal = $fEst / $this->fFactor;
        return $this->AdjustPosition($fVal); 
    }
    
    function EstNetValue()
    {
        $this->AdjustFactor();
        
        $this->fOfficialNetValue = $this->_estGoldEtf($this->est_ref->fPrice);
        $this->strOfficialDate = $this->est_ref->strDate;
        $this->UpdateEstNetValue();

        $this->EstRealtimeNetValue();
    }

    function EstRealtimeNetValue()
    {
		$fEst = $this->future_ref->fPrice * $this->forex_sql->GetCloseNow() / 31.1035;
		if ($this->future_ref->GetStockSymbol() == 'SI')
		{
//			DebugString('Silver');
			$fEst *= 1000.0;
		}
        $this->fRealtimeNetValue = $this->_estGoldEtf($fEst);
    }

    function AdjustFactor()
    {
        if ($this->UpdateOfficialNetValue())
        {
            $est_ref = $this->est_ref;
            if ($est_ref->bHasData == false)            return false;
            if ($this->strDate != $est_ref->strDate)    return false;
            
            $iHour = intval(substr($est_ref->strTime, 0, 2));
            if ($iHour >= 9 && $iHour <= 15)
            {
                $this->fFactor = $est_ref->fPrice / $this->fPrice;
                $this->InsertFundCalibration($est_ref, $est_ref->strPrice);
            }
            else
            {
                $this->fFactor = $est_ref->fPrevPrice / $this->fPrice;
                $this->InsertFundCalibration($est_ref, $est_ref->strPrevPrice);
            }
            return $this->fFactor;
        }
        return false;
    }
}

?>
