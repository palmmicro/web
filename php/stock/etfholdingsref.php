<?php

class EtfHoldingsReference extends MyStockReference
{
    var $uscny_ref;
    var $hkcny_ref;
    
    var $ar_holdings_ref = array();

    var $strNetValue;
    var $strHoldingsDate;
    var $arHoldingsRatio = array();
    
    function EtfHoldingsReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);

        $strStockId = $this->GetStockId();
    	$date_sql = new EtfHoldingsDateSql();
    	if ($this->strHoldingsDate = $date_sql->ReadDate($strStockId))
    	{
    		$this->hkcny_ref = new CnyReference('HKCNY');
    		$this->uscny_ref = new CnyReference('USCNY');

    		$nav_sql = GetNavHistorySql();
    		$this->strNetValue = $nav_sql->GetClose($strStockId, $this->strHoldingsDate);
    		
			$holdings_sql = GetEtfHoldingsSql();
			$this->arHoldingsRatio = $holdings_sql->GetHoldingsArray($strStockId);
			$sql = GetStockSql();
			foreach ($this->arHoldingsRatio as $strId => $strRatio)
			{
    			$this->ar_holdings_ref[] = new MyStockReference($sql->GetKey($strId));
			}
    	}
    }
    
    function GetHoldingsDate()
    {
    	return $this->strHoldingsDate;
    }
    
    function GetHoldingsRatioArray()
    {
    	return $this->arHoldingsRatio;
    }
    
    function GetHoldingRefArray()
    {
    	return $this->ar_holdings_ref;
    }
    
    function GetNetValue()
    {
    	return $this->strNetValue;
    }
    
    function GetAdjustH($bOfficial = false)
    {
		$fOldUSDHKD = floatval($this->uscny_ref->GetClose($this->strHoldingsDate)) / floatval($this->hkcny_ref->GetClose($this->strHoldingsDate));
		if ($bOfficial)	
		{
			$strDate = $this->GetDate();
			$fUSDHKD = floatval($this->uscny_ref->GetClose($strDate)) / floatval($this->hkcny_ref->GetClose($strDate));
		}
		else
		{
			$fUSDHKD = floatval($this->uscny_ref->GetPrice()) / floatval($this->hkcny_ref->GetPrice());
		}
		return $fOldUSDHKD / $fUSDHKD;
    }
    
    // (x - x0) / x0 = sum{ r * (y - y0) / y0} 
    function _estNetValue($bOfficial = false)
    {
    	$fAdjustH = $this->GetAdjustH($bOfficial);
    	
		$his_sql = GetStockHistorySql();
		$fTotalChange = 0.0;
		$fTotalRatio = 0.0;
		foreach ($this->ar_holdings_ref as $ref)
		{
			$strStockId = $ref->GetStockId();
			$fRatio = floatval($this->arHoldingsRatio[$strStockId]) / 100.0;
			$fTotalRatio += $fRatio;
			
			if ($bOfficial)	$strPrice = $his_sql->GetClose($strStockId, $this->GetDate());
			else				$strPrice = $ref->GetPrice();
			
			$fChange = $fRatio * floatval($strPrice) / floatval($his_sql->GetClose($strStockId, $this->strHoldingsDate));
			if ($ref->IsSymbolH())	$fChange *= $fAdjustH; 
			$fTotalChange += $fChange; 
		}
		return floatval($this->strNetValue) * (1.0 + $fTotalChange - $fTotalRatio);
    }
    
    function GetOfficialNetValue()
    {
    	return $this->_estNetValue(true);
    }

    function GetFairNetValue()
    {
		if ($this->GetDate() == $this->uscny_ref->GetDate())		return false;
    	return $this->_estNetValue();
    }
    
    function GetRealtimeNetValue()
    {
    	return false;
    }
    
/*    
    function GetHoldingsIdArray() 
    {
        $holdings_sql = GetEtfHoldingsSql();
    	$arId = array();
    	$ar = $holdings_sql->GetHoldingsArray($this->GetStockId());
    	foreach ($ar as $strId => $strRatio)
    	{
    		$arId[] = $strId;
    	}
    	return $arId;
    }
*/    
}

?>
