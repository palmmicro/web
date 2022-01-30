<?php
require_once('/php/csvfile.php');

class _HoldingsCsvFile extends DebugCsvFile
{
	var $strStockId;
	var $strDate;

	var $sql;
	var $his_sql;
	var $holdings_sql;
	
    function _HoldingsCsvFile($strDebug, $strStockId) 
    {
        parent::DebugCsvFile($strDebug);
        
        $this->strStockId = $strStockId;
        $this->sql = GetStockSql();
        $this->his_sql = GetStockHistorySql();
        $this->holdings_sql = GetHoldingsSql();
        $this->holdings_sql->DeleteAll($strStockId);
    }
    
    function InsertHolding($strSymbol, $strName, $strRatio)
    {
		$this->sql->InsertSymbol($strSymbol, $strName);
    	if ($strStockId = $this->sql->GetId($strSymbol))
    	{
    		if ($this->his_sql->GetRecord($strStockId, $this->strDate) == false)		$this->ErrorReport($strSymbol.' missing data on '.$this->strDate);
			return $this->holdings_sql->InsertHolding($this->strStockId, $strStockId, $strRatio);
		}
		return false;
    }
}

?>
