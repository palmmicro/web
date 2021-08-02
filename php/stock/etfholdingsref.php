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
    
    function GetAdjustHkd($bOfficial = false)
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
//		return 1.0;
    }
    
    function GetAdjustCny($bOfficial = false)
    {
		$fOldUSDCNY = floatval($this->uscny_ref->GetClose($this->strHoldingsDate));
		$fUSDCNY = $bOfficial ? floatval($this->uscny_ref->GetClose($this->GetDate())) : floatval($this->uscny_ref->GetPrice());
		return $fOldUSDCNY / $fUSDCNY;
    }
    
    // (x - x0) / x0 = sum{ r * (y - y0) / y0} 
    function _estNav($bOfficial = false)
    {
    	$fAdjustH = $this->GetAdjustHkd($bOfficial);
    	
		$his_sql = GetStockHistorySql();
		$fTotalChange = 0.0;
		$fTotalRatio = 0.0;
		foreach ($this->ar_holdings_ref as $ref)
		{
			$strStockId = $ref->GetStockId();
			$fRatio = floatval($this->arHoldingsRatio[$strStockId]) / 100.0;
			$fTotalRatio += $fRatio;
			
			if ($bOfficial)
			{
				$strDate = $this->GetDate();
				$strPrice = $his_sql->GetAdjClose($strStockId, $strDate);
				if ($strPrice === false)		$strPrice = $ref->GetPrice();	
			}
			else								$strPrice = $ref->GetPrice();
			
			if ($strAdjClose = $his_sql->GetAdjClose($strStockId, $this->strHoldingsDate))
			{
				$fChange = $fRatio * floatval($strPrice) / floatval($strAdjClose);
				if ($ref->IsSymbolH())	$fChange *= $fAdjustH; 
				$fTotalChange += $fChange;
			}
		}
		$fNewNav = floatval($this->strNav) * (1.0 + $fTotalChange - $fTotalRatio);
		if ($this->IsFundA())		$fNewNav /= $this->GetAdjustCny($bOfficial);
		return $fNewNav; 
    }

    function GetNavChange()
    {
    	return $this->_estNav() / floatval($this->strNav);
    }
    
    function GetOfficialNav()
    {
    	$strNav = strval($this->_estNav(true));
   		StockUpdateEstResult($this->GetFundEstSql(), $this->GetStockId(), $strNav, $this->GetDate());
   		return $strNav;
    }

    function GetFairNav()
    {
		if ($this->GetDate() == $this->uscny_ref->GetDate())		return false;
    	return strval($this->_estNav());
    }
}

?>
