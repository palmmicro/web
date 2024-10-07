<?php
require_once('../../php/csvfile.php');
//require_once('_yahoohistorychart.php');

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
	
    public function __construct($strFileName, $strStockId) 
    {
        parent::__construct($strFileName);
        
        $this->fSum = 0.0;
        $this->strStockId = $strStockId;
        
        $this->sql = GetStockSql();
        $this->his_sql = GetStockHistorySql();
        $this->holdings_sql = GetHoldingsSql();
    }
    
    function InsertHolding($strSymbol, $strName, $strRatio)
    {
        $strSymbol = str_replace('/', '.', $strSymbol);	// BRK/B -> BRK.B
		$this->sql->InsertSymbol($strSymbol, $strName);
    	if ($strStockId = $this->sql->GetId($strSymbol))
    	{
    		if ($this->his_sql->GetRecord($strStockId, $this->strDate) == false)
    		{
    			$this->DebugReport($strSymbol.' missing data on '.$this->strDate);
//    			UpdateYahooHistoryChart(new MyStockReference($strSymbol));
    		}
			return $this->holdings_sql->InsertHolding($this->strStockId, $strStockId, $strRatio);
		}
		return false;
    }

    function DeleteAllHoldings()
    {
		$this->holdings_sql->DeleteAll($this->strStockId);
    }
    
    function UpdateHoldingsDate()
    {
    	if ($this->strDate)
    	{
    		$date_sql = new HoldingsDateSql();
    		return $date_sql->WriteDate($this->strStockId, $this->strDate);
    	}
    	return false;
    }
    
    function GetDate()
    {
    	return $this->strDate;
    }
    
    public function SetDate($strDate)
    {
		DebugString(__CLASS__.'->'.__FUNCTION__.': '.$strDate);
    	$this->strDate = $strDate;
    }

    function CalcCurrency($strDate)
    {
    	$strDebug = __CLASS__.'->'.__FUNCTION__.': '.$strDate;
        $strUscnyId = $this->sql->GetId('USCNY');
        $strHkcnyId = $this->sql->GetId('HKCNY');
        $nav_sql = GetNavHistorySql();
        
        $str = ($strUSDCNY = $nav_sql->GetClose($strUscnyId, $strDate)) ? $strUSDCNY : $nav_sql->GetCloseNow($strUscnyId);
        $this->fUSDCNY = floatval($str);
        $strDebug .= ' '.$str;
        
        $str = ($strHKDCNY = $nav_sql->GetClose($strHkcnyId, $strDate)) ? $strHKDCNY : $nav_sql->GetCloseNow($strHkcnyId);
        $this->fHKDCNY = floatval($str);
        $strDebug .= ' '.$str;
        
       	$this->fUSDHKD = $this->fUSDCNY / $this->fHKDCNY;
		DebugString($strDebug);
    }
/*    
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
*/    
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
		if ($strStockId = $this->sql->GetId($strHolding))
		{
			$fForex = is_numeric($strHolding) ? $this->fHKDCNY : $this->fUSDCNY;
			return $iQuantity * floatval($this->his_sql->GetAdjClose($strStockId, $this->strDate)) * $fForex;
		}
		DebugString('GetMarketVal failed with '.$strHolding);
		return 0.0;
    }
}

?>
