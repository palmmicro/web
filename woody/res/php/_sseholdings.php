<?php
require_once('_holdingscsvfile.php');

class _SseHoldingsFile extends _HoldingsCsvFile
{
    var $fTotalValue;
	
    function _SseHoldingsFile($strDebug, $strStockId) 
    {
        parent::_HoldingsCsvFile($strDebug, $strStockId);

        $this->SetSeparator('|');
        $this->holdings_sql->DeleteAll($strStockId);
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) == 1)
    	{
    		$ar = explode('=', $arWord[0]);
    		switch ($ar[0])
    		{
    		case 'PreTradingDay':
    			$strDate = $ar[1];
    			$this->strDate = substr($strDate, 0, 4).'-'.substr($strDate, 4, 2).'-'.substr($strDate, 6, 2);
    			DebugString($this->strDate);
    			break;
    		
    		case 'NAVperCU':
    			$this->fTotalValue = floatval($ar[1]);
    			break;
    		}
    	}
    	else
    	{
//	    	DebugPrint($arWord);
    		$strHolding = trim($arWord[0]);
    		if (is_numeric($strHolding))	$strHolding = BuildHongkongStockSymbol($strHolding);
    		$strName = GbToUtf8(trim($arWord[1]));
    		DebugString($strHolding.' '.$strName);
    		$this->InsertHolding($strHolding, $strName, strval(100.0 * floatval(trim($arWord[6])) / $this->fTotalValue));
    	}
    }
}

function ReadSseHoldingsFile($strSymbol, $strStockId)
{
	$strUrl = 'http://query.sse.com.cn/etfDownload/downloadETF2Bulletin.do?etfType=087';
	if ($strDebug = StockSaveHoldingsCsv($strSymbol, $strUrl))
	{
		$csv = new _SseHoldingsFile($strDebug, $strStockId);
		$csv->Read();
   	
		$date_sql = new HoldingsDateSql();
		$date_sql->WriteDate($strStockId, $csv->strDate);
	}
}

?>
