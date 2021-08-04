<?php

class EtfHoldingsReference extends MyStockReference
{
	var $nav_ref;
    var $uscny_ref;
    var $hkcny_ref;
    
    var $ar_holdings_ref = array();

    var $strNav;
    var $strHoldingsDate;
    var $arHoldingsRatio = array();
    
    function EtfHoldingsReference($strSymbol) 
    {
        parent::MyStockReference($strSymbol);
       	$this->nav_ref = new NetValueReference($strSymbol);
   		$this->hkcny_ref = new CnyReference('HKCNY');
   		$this->uscny_ref = new CnyReference('USCNY');

        $strStockId = $this->GetStockId();
    	$date_sql = new EtfHoldingsDateSql();
    	if ($this->strHoldingsDate = $date_sql->ReadDate($strStockId))
    	{
    		$nav_sql = GetNavHistorySql();
    		$this->strNav = $nav_sql->GetClose($strStockId, $this->strHoldingsDate);
    		
			$holdings_sql = GetEtfHoldingsSql();
			$this->arHoldingsRatio = $holdings_sql->GetHoldingsArray($strStockId);
			$sql = GetStockSql();
			foreach ($this->arHoldingsRatio as $strId => $strRatio)
			{
    			$this->ar_holdings_ref[] = new MyStockReference($sql->GetKey($strId));
			}
    	}
    }
    
    function GetFundEstSql()
    {
    	return $this->nav_ref->GetFundEstSql();
    }
    
    function GetNavRef()
    {
    	return $this->nav_ref;
    }
    
    function GetUscnyRef()
    {
    	return $this->uscny_ref;
    }
    
    function GetHkcnyRef()
    {
    	return $this->hkcny_ref;
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
    
    function GetNav()
    {
    	return $this->nav_ref->GetPrice();
    }
    
    function GetAdjustHkd($strDate = false)
    {
		$fOldUSDHKD = floatval($this->uscny_ref->GetClose($this->strHoldingsDate)) / floatval($this->hkcny_ref->GetClose($this->strHoldingsDate));
		$fUSDHKD = floatval($this->uscny_ref->GetPrice()) / floatval($this->hkcny_ref->GetPrice());
		if ($strDate)	
		{
			if ($strHKDCNY = $this->hkcny_ref->GetClose($strDate))	
			{
				if ($strUSDCNY = $this->uscny_ref->GetClose($strDate))		$fUSDHKD = floatval($strUSDCNY) / floatval($strHKDCNY);
			}
		}
		return $fOldUSDHKD / $fUSDHKD;
//		return 1.0;
    }
    
    function GetAdjustCny($strDate = false)
    {
		$fOldUSDCNY = floatval($this->uscny_ref->GetClose($this->strHoldingsDate));
		$fUSDCNY = floatval($this->uscny_ref->GetPrice());
		if ($strDate)
		{
			if ($strUSDCNY = $this->uscny_ref->GetClose($strDate))		$fUSDCNY = floatval($strUSDCNY);
		}
		return $fOldUSDCNY / $fUSDCNY;
    }
    
    // (x - x0) / x0 = sum{ r * (y - y0) / y0} 
    function _estNav($strDate = false)
    {
    	$fAdjustH = $this->GetAdjustHkd($strDate);
    	
		$his_sql = GetStockHistorySql();
		$fTotalChange = 0.0;
		$fTotalRatio = 0.0;
		foreach ($this->ar_holdings_ref as $ref)
		{
			$strStockId = $ref->GetStockId();
			$fRatio = floatval($this->arHoldingsRatio[$strStockId]) / 100.0;
			$fTotalRatio += $fRatio;
			
			$strPrice = $ref->GetPrice();
			if ($strDate)
			{
				if ($str = $his_sql->GetAdjClose($strStockId, $strDate))		$strPrice = $str;
			}
			
			if ($strAdjClose = $his_sql->GetAdjClose($strStockId, $this->strHoldingsDate))
			{
				$fChange = $fRatio * floatval($strPrice) / floatval($strAdjClose);
				if ($ref->IsSymbolH())	$fChange *= $fAdjustH; 
				$fTotalChange += $fChange;
			}
		}
		$fNewNav = floatval($this->strNav) * (1.0 + $fTotalChange - $fTotalRatio);
		if ($this->IsFundA())		$fNewNav /= $this->GetAdjustCny($strDate);
		return $fNewNav; 
    }

    function GetNavChange()
    {
    	return $this->_estNav() / floatval($this->strNav);
    }
    
    function _getEstDate()
    {
   		foreach ($this->ar_holdings_ref as $ref)
   		{
   			if ($ref->IsSymbolUS())
   			{
    			return $ref->GetDate();
   			}
   		}
   		return false;
    }
    
    function GetOfficialDate()
    {
   		$strDate = $this->GetDate();
    	if ($this->IsFundA())
    	{
			if ($str = $this->_getEstDate())		$strDate = $str;
    		
    		if ($this->uscny_ref->GetClose($strDate) === false)
    		{   // Load last value from database
    			$fund_est_sql = $this->GetFundEstSql();
    			$strDate = $fund_est_sql->GetDateNow($this->GetStockId());
    		}
    	}
    	return $strDate;
    }
    
    function GetOfficialNav()
    {
    	$strDate = $this->GetOfficialDate();
    	$strNav = strval($this->_estNav($strDate));
   		StockUpdateEstResult($this->GetFundEstSql(), $this->GetStockId(), $strNav, $strDate);
   		return $strNav;
    }

    function GetFairNav()
    {
    	$strDate = $this->GetOfficialDate(); 
		if (($this->uscny_ref->GetDate() != $strDate) || ($this->_getEstDate() != $strDate))
		{
			return strval($this->_estNav());
		}
		return false;
    }
}

?>
