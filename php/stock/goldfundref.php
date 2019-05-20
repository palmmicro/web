<?php

function GoldEtfGetCnFutureSymbol($strSymbol)
{
    if ($strSymbol == 'SZ161226')   return 'AG0';
    return 'AU0';
}

function GoldEtfGetFutureSymbol($strSymbol)
{
    if ($strSymbol == 'SZ161226')   return 'hf_SI';
    return 'hf_GC';
}

function GoldEtfGetAllSymbolArray($strSymbol)
{
    $strCnFutureSymbol = GoldEtfGetCnFutureSymbol($strSymbol);
    $strFutureSymbol = GoldEtfGetFutureSymbol($strSymbol);
    return array($strSymbol, $strCnFutureSymbol, $strFutureSymbol);
}

class GoldFundReference extends FundReference
{
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
        
        $this->fOfficialNetValue = $this->_estGoldEtf(floatval($this->est_ref->GetPrice()));
        $this->strOfficialDate = $this->est_ref->strDate;
        $this->UpdateEstNetValue();

        $this->EstRealtimeNetValue();
    }

    function EstRealtimeNetValue()
    {
		$fEst = floatval($this->future_ref->GetPrice()) * floatval($this->forex_sql->GetCloseNow()) / 31.1035;
		if ($this->future_ref->GetStockSymbol() == 'hf_SI')
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
            if ($est_ref->HasData() == false)            return false;
            if ($this->strDate != $est_ref->strDate)    return false;
            
            $iHour = intval(substr($est_ref->strTime, 0, 2));
            if ($iHour >= 9 && $iHour <= 15)
            {
                $this->fFactor = floatval($est_ref->GetPrice()) / floatval($this->GetPrice());
                $this->InsertFundCalibration($est_ref, $est_ref->GetPrice());
            }
            else
            {
                $this->fFactor = floatval($est_ref->GetPrevPrice()) / floatval($this->GetPrice());
                $this->InsertFundCalibration($est_ref, $est_ref->GetPrevPrice());
            }
            return $this->fFactor;
        }
        return false;
    }
}

?>
