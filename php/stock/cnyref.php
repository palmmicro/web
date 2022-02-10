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
    
	function GetClose($strDate)
	{
		if ($strDate == $this->GetDate())	return $this->GetPrice();
		return SqlGetNavByDate($this->strSqlId, $strDate);
	}
}

?>
