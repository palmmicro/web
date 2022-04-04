<?php

class CnyReference extends MysqlReference
{
    public function LoadData()
    {
    	$strSymbol = $this->GetSymbol();
    	
    	$this->strSqlId = SqlGetStockId($strSymbol);
       	$this->LoadSqlData();
   		$this->strTime = '09:15:00';
        $this->strFileName = DebugGetChinaMoneyFile();
        $this->strExternalLink = GetReferenceRateForexLink($strSymbol);
    }
    
	public function GetClose($strDate)
	{
		if ($strDate == $this->GetDate())	return $this->GetPrice();
		return SqlGetNavByDate($this->strSqlId, $strDate);
	}
	
	function GetVal($strDate = false)
	{
		if ($strDate)
		{
			if ($strClose = $this->GetClose($strDate))		return floatval($strClose);
		}
		return floatval($this->GetPrice());
	}
}

class HkdUsdReference
{
	var $uscny_ref;
	var $hkcny_ref;
    
    function HkdUsdReference()
    {
   		$this->uscny_ref = new CnyReference('USCNY');
   		$this->hkcny_ref = new CnyReference('HKCNY');
    }
    
    function GetUsRef()
    {
    	return $this->uscny_ref;
    }

    function GetHkRef()
    {
    	return $this->hkcny_ref;
    }

	function GetVal($strDate = false)
	{
		return $this->hkcny_ref->GetVal($strDate) / $this->uscny_ref->GetVal($strDate); 
	}
}

?>
