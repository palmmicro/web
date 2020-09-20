<?php

function GoldSilverGetCnFutureSymbol($strSymbol)
{
    if ($strSymbol == 'SZ161226')   return 'AG0';
    return 'AU0';
}

function GoldSilverGetFutureSymbol($strSymbol)
{
    if ($strSymbol == 'SZ161226')   return 'hf_SI';
    return 'hf_GC';
}

function GoldSilverGetAllSymbolArray($strSymbol)
{
    $strCnFutureSymbol = GoldSilverGetCnFutureSymbol($strSymbol);
    $strFutureSymbol = GoldSilverGetFutureSymbol($strSymbol);
    return array($strSymbol, $strCnFutureSymbol, $strFutureSymbol);
}

class GoldFundReference extends FundReference
{
    function GoldFundReference($strSymbol)
    {
        parent::FundReference($strSymbol);
        $this->SetForex('USCNY');
        $this->est_ref = new FutureReference(GoldSilverGetCnFutureSymbol($strSymbol));
        $this->future_ref = new FutureReference(GoldSilverGetFutureSymbol($strSymbol));
        $this->EstNetValue();
    }

    function _estGoldSilver($fEst)
    {
    	if (empty($this->fFactor))	return 0.0;
    	
   		$fVal = $fEst / $this->fFactor;
        return $this->AdjustPosition($fVal); 
    }
    
    function EstNetValue()
    {
        $this->AdjustFactor();
        
        $est_ref = $this->GetEstRef();
        $this->fOfficialNetValue = $this->_estGoldSilver(floatval($est_ref->GetPrice()));
        $this->strOfficialDate = $est_ref->GetDate();
        $this->UpdateEstNetValue();

        $this->EstRealtimeNetValue();
    }

    function EstRealtimeNetValue()
    {
		$fEst = floatval($this->future_ref->GetPrice()) * floatval($this->forex_sql->GetCloseNow()) / 31.1035;
		if ($this->future_ref->GetSymbol() == 'hf_SI')
		{
//			DebugString('Silver');
			$fEst *= 1000.0;
		}
        $this->fRealtimeNetValue = $this->_estGoldSilver($fEst);
    }

    function AdjustFactor()
    {
        if ($this->UpdateOfficialNetValue())
        {
        	$est_ref = $this->GetEstRef();
            if ($est_ref->HasData() == false)            return false;
            if ($this->GetDate() != $est_ref->GetDate())    return false;
            
            $iHour = $est_ref->GetHour();
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
