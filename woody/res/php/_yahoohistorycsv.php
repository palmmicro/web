<?php
require_once('/php/csvfile.php');
require_once('/php/stockhis.php');

class _YahooHistoryCsvFile extends DebugCsvFile
{
	var $strStockId;

	var $his_sql;
	var $oldest_ymd;
	
	var $iTotal;
	var $iModified;
	
    function _YahooHistoryCsvFile($strDebug, $strStockId) 
    {
        parent::DebugCsvFile($strDebug);
        
        $this->strStockId = $strStockId;
        $this->his_sql = GetStockHistorySql();
        $this->oldest_ymd = new OldestYMD();
        
        $this->iTotal = 0;
        $this->iModified = 0;
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) < 7)						return;
    	
    	$strDate = $arWord[0];
    	if ($strDate == 'Date')						return;
   		if ($this->oldest_ymd->IsTooOld($strDate))	return;

    	// Date,Open,High,Low,Close,Adj Close,Volume        		
    	$strClose = $arWord[4]; 
        if ($strClose == '-' || $strClose == 'null')				DebugPrint($arWord);	// debug wrong data
        else if ($this->oldest_ymd->IsInvalid($strDate) == false)
        {
        	$this->iTotal ++;
        	if ($this->his_sql->WriteHistory($this->strStockId, $strDate, $strClose, $arWord[1], $arWord[2], $arWord[3], $arWord[6], $arWord[5]))
        	{
//        		DebugString(implode(',', $arWord));
        		$this->iModified ++;
        	}
        }
	}
}

// https://query1.finance.yahoo.com/v7/finance/download/KWEB?period1=1611673365&period2=1643209365&interval=1d&events=history&includeAdjustedClose=true
// https://query1.finance.yahoo.com/v7/finance/download/XOP?period1=1611853537&period2=1643389537&interval=1d&events=history&includeAdjustedClose=true
// https://query1.finance.yahoo.com/v7/finance/download/AMD?period1=1611878400&period2=1643414400&interval=1d&events=history&includeAdjustedClose=true
function YahooUpdateStockHistory($ref)
{
	$strSymbol = $ref->GetSymbol();
	$strStockId = $ref->GetStockId();
	
    $ref->SetTimeZone();
/*    $now_ymd = new NowYMD();
    $ymd = new StringYMD($now_ymd->GetYMD());
    $iEnd = $ymd->GetTick();*/ 
	$iEnd = time();
	$strBegin = strval($iEnd - MAX_QUOTES_DAYS * SECONDS_IN_DAY);
	$strEnd = strval($iEnd);
	$strUrl = "https://query1.finance.yahoo.com/v7/finance/download/$strSymbol?period1=$strBegin&period2=$strEnd&interval=1d&events=history&includeAdjustedClose=true";
	
	if ($strDebug = StockSaveHistoryCsv($strSymbol, $strUrl))
	{
		$csv = new _YahooHistoryCsvFile($strDebug, $strStockId);
		$csv->Read();

		DebugVal($csv->iTotal, 'Total');
		DebugVal($csv->iModified, 'Modified');
		if ($ref->IsSymbolA() || $ref->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
//			if ($ref->IsIndex() == false)
			{
				$csv->his_sql->DeleteByZeroVolume($strStockId);
			}
		}
		unlinkConfigFile($strSymbol);
	}
}

?>
