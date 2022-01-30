<?php
require_once('/php/csvfile.php');
require_once('/php/stockhis.php');
/*
class _YahooHistoryCsvFile extends DebugCsvFile
{
	var $bUse;
	var $strStockId;
	var $strDate;

	var $sql;
	var $his_sql;
	var $holdings_sql;
	
    var $fUSDHKD;
    var $fMarketValue;
	
    function _YahooHistoryCsvFile($strDebug, $strStockId, $strDate) 
    {
        parent::DebugCsvFile($strDebug);
        
        $this->bUse = false;
        $this->strStockId = $strStockId;
        $this->strDate = $strDate;
        
        $this->sql = GetStockSql();
        $this->his_sql = GetStockHistorySql();
        $this->holdings_sql = GetHoldingsSql();
        
        $strUscnyId = $this->sql->GetId('USCNY');
        $strHkcnyId = $this->sql->GetId('HKCNY');
        $nav_sql = GetNavHistorySql();
        if ($strHKDCNY = $nav_sql->GetClose($strHkcnyId, $strDate))
        {
        	$this->fUSDHKD = floatval($nav_sql->GetClose($strUscnyId, $strDate)) / floatval($strHKDCNY);
        }
        else
        {
        	$this->fUSDHKD = floatval($nav_sql->GetCloseNow($strUscnyId)) / floatval($nav_sql->GetCloseNow($strHkcnyId));
        }
        
        $this->fMarketValue = 0.0; 
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) < 7)	return;
    	
    	$strName = $arWord[1];
    	if (($strName == 'HONG KONG DOLLAR') || ($strName == 'Cash'))	return;
    	
    	$strRatio = $arWord[2];
    	if ($arWord[0] == 'Rank')
    	{
    		$this->holdings_sql->DeleteAll($this->strStockId);
    		$this->bUse = true;
    	}
    	else if (floatval($strRatio) < 0.01)		$this->bUse = false;
    	else if ($this->bUse)
    	{
    		$strHolding = $arWord[3];
    		if (is_numeric($strHolding))		
    		{
    			$strHolding = BuildHongkongStockSymbol($strHolding);
    			$bHk = true;
    		}
    		else	$bHk = false;
   			$this->sql->InsertSymbol($strHolding, $strName);
    		$strId = $this->sql->GetId($strHolding);
    		
   			$this->fMarketValue += floatval(str_replace(',', '', $arWord[6]));
    		if ($this->his_sql->GetRecord($strId, $this->strDate) === false)
    		{
    			DebugString($strHolding.' missing data on '.$this->strDate);
//		        UpdateStockHistory(new StockSymbol($strHolding), $strId);
    		}
    		
    		$this->holdings_sql->InsertHolding($this->strStockId, $strId, $strRatio);
    	}
    }
    
    function GetMarketValue()
    {
    	return $this->fMarketValue;
    }
}
*/

// https://query1.finance.yahoo.com/v7/finance/download/KWEB?period1=1611673365&period2=1643209365&interval=1d&events=history&includeAdjustedClose=true
// https://query1.finance.yahoo.com/v7/finance/download/XOP?period1=1611853537&period2=1643389537&interval=1d&events=history&includeAdjustedClose=true
// https://query1.finance.yahoo.com/v7/finance/download/AMD?period1=1611878400&period2=1643414400&interval=1d&events=history&includeAdjustedClose=true
function YahooUpdateStockHistory($sym, $strStockId)
{
	$strSymbol = $sym->GetSymbol();
	
    $sym->SetTimeZone();
/*    $now_ymd = new NowYMD();
    $ymd = new StringYMD($now_ymd->GetYMD());
    $iEnd = $ymd->GetTick();*/ 
	$iEnd = time();
	$strBegin = strval($iEnd - MAX_QUOTES_DAYS * SECONDS_IN_DAY);
	$strEnd = strval($iEnd);
	$strUrl = "https://query1.finance.yahoo.com/v7/finance/download/$strSymbol?period1=$strBegin&period2=$strEnd&interval=1d&events=history&includeAdjustedClose=true";
	
	StockSaveHistoryCsv($strSymbol, $strUrl);
}

?>
