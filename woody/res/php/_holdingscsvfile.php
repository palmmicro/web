<?php
require_once('/php/csvfile.php');

class _HoldingsCsvFile extends DebugCsvFile
{
	var $strStockId;
	var $strDate = false;

    var $fSum;
    var $fUSDCNY;
    var $fHKDCNY;
    var $fUSDHKD;
    
	var $sql;
	var $his_sql;
	var $holdings_sql;
	
    function _HoldingsCsvFile($strDebug, $strStockId) 
    {
        parent::DebugCsvFile($strDebug);
        
        $this->fSum = 0.0;
        $this->strStockId = $strStockId;
        
        $this->sql = GetStockSql();
        $this->his_sql = GetStockHistorySql();
        $this->holdings_sql = GetHoldingsSql();
    }
    
    function InsertHolding($strSymbol, $strName, $strRatio)
    {
		$this->sql->InsertSymbol($strSymbol, $strName);
    	if ($strStockId = $this->sql->GetId($strSymbol))
    	{
    		if ($this->his_sql->GetRecord($strStockId, $this->strDate) == false)		$this->DebugReport($strSymbol.' missing data on '.$this->strDate);
			return $this->holdings_sql->InsertHolding($this->strStockId, $strStockId, $strRatio);
		}
		return false;
    }

    function DeleteAllHoldings()
    {
		$this->holdings_sql->DeleteAll($this->strStockId);
    }
    
    function GetDate()
    {
    	return $this->strDate;
    }
    
    public function SetDate($strDate)
    {
		DebugString('_HoldingsCsvFile SetDate: '.$strDate);
    	$this->strDate = $strDate;
    }

    function CalcCurrency($strDate)
    {
		DebugString('_HoldingsCsvFile CalcCurrency: '.$strDate);
        $strUscnyId = $this->sql->GetId('USCNY');
        $strHkcnyId = $this->sql->GetId('HKCNY');
        $nav_sql = GetNavHistorySql();
        
        $this->fUSDCNY = ($strUSDCNY = $nav_sql->GetClose($strUscnyId, $strDate)) ? floatval($strUSDCNY) : floatval($nav_sql->GetCloseNow($strUscnyId));
        $this->fHKDCNY = ($strHKDCNY = $nav_sql->GetClose($strHkcnyId, $strDate)) ? floatval($strHKDCNY) : floatval($nav_sql->GetCloseNow($strHkcnyId));
       	$this->fUSDHKD = $this->fUSDCNY / $this->fHKDCNY;
    }
    
    function GetUSDCNY()
    {
    	return $this->fUSDCNY;
    }
    
    function GetHKDCNY()
    {
    	return $this->fHKDCNY;
    }

    function GetUSDHKD()
    {
    	return $this->fUSDHKD;
    }
    
    function AddSum($fVal)
    {
    	$this->fSum += $fVal;
    }
    
    function GetSum()
    {
    	return $this->fSum;
    }
    
    function GetMarketVal($strHolding, $iQuantity)
    {
		if (is_numeric($strHolding))	
		{
			$strHolding = BuildHongkongStockSymbol($strHolding);
			$fForex = $this->fHKDCNY;
		}
		else	$fForex = $this->fUSDCNY;
		
		if ($strStockId = $this->sql->GetId($strHolding))		return $iQuantity * floatval($this->his_sql->GetAdjClose($strStockId, $this->strDate)) * $fForex;
		return 0.0;
    }
}

?>
