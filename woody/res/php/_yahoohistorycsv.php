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
    	$strOpen = $arWord[1];
    	$strHigh = $arWord[2];
    	$strLow = $arWord[3];
    	$strClose = $arWord[4]; 
    	$strVolume = $arWord[6];
        if ($strClose == '-' || $strClose == 'null')
        {
        	DebugPrint($arWord);	// debug wrong data
        	return;
        }
        
        if ($strVolume == '0')
        {
        	if (($strClose == $strOpen) && ($strClose == $strHigh) && ($strClose == $strLow))
        	{
        		DebugString('Holiday: '.$strDate.' '.$strClose);
        		return;
        	}
        }
        
        if ($this->oldest_ymd->IsInvalid($strDate) == false)
        {
        	$this->iTotal ++;
        	if ($this->his_sql->WriteHistory($this->strStockId, $strDate, $strClose, $strOpen, $strHigh, $strLow, $strVolume, $arWord[5]))
        	{
//        		DebugString(implode(',', $arWord));
        		$this->iModified ++;
        	}
        }
	}
}

// https://query1.finance.yahoo.com/v7/finance/download/XOP?period1=1611853537&period2=1643389537&interval=1d&events=history&includeAdjustedClose=true
function YahooUpdateStockHistory($ref)
{
	$strSymbol = $ref->GetSymbol();
	$strStockId = $ref->GetStockId();
	
    $ref->SetTimeZone();
    $iEnd = GetNowTick(); 
	$strBegin = strval($iEnd - MAX_QUOTES_DAYS * SECONDS_IN_DAY);
	$strEnd = strval($iEnd);
	$strYahooSymbol = $ref->GetYahooSymbol();
	$strUrl = "https://query1.finance.yahoo.com/v7/finance/download/$strYahooSymbol?period1=$strBegin&period2=$strEnd&interval=1d&events=history&includeAdjustedClose=true";
	
	if ($strDebug = StockSaveHistoryCsv($strSymbol, $strUrl))
	{
		$csv = new _YahooHistoryCsvFile($strDebug, $strStockId);
		$csv->Read();

		DebugVal($csv->iTotal, 'Total');
		DebugVal($csv->iModified, 'Modified');
/*		if ($ref->IsSymbolA() || $ref->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
//			if ($ref->IsIndex() == false)
			{
				$csv->his_sql->DeleteByZeroVolume($strStockId);
			}
		}*/
		unlinkConfigFile($strSymbol);
	}
}

?>
