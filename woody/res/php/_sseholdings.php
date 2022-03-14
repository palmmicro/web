<?php
require_once('_etfholdings.php');

class _SseHoldingsFile extends _EtfHoldingsFile
{
    function _SseHoldingsFile($strDebug, $strStockId) 
    {
        parent::_EtfHoldingsFile($strDebug, $strStockId);
        $this->SetSeparator('|');
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) == 1)
    	{
    		$ar = explode('=', $arWord[0]);
    		switch ($ar[0])
    		{
    		case 'EstimateCashComponent':
    			$this->SubCash(floatval($ar[1]));
    			break;
    			
			case 'PreTradingDay':
    			$strDate = $ar[1];
    			$this->SetDate(substr($strDate, 0, 4).'-'.substr($strDate, 4, 2).'-'.substr($strDate, 6, 2));
    			break;
    		
    		case 'NAVperCU':
    			$this->AddCash(floatval($ar[1]));
    			break;
    		}
    	}
    	else
    	{
    		$this->AddHolding(trim($arWord[0]), GbToUtf8(trim($arWord[1])), floatval(trim($arWord[6])));
/*    		$strHolding = trim($arWord[0]);
    		if (is_numeric($strHolding))	$strHolding = BuildHongkongStockSymbol($strHolding);
    		$strName = GbToUtf8(trim($arWord[1]));
    		DebugString($strHolding.' '.$strName);
    		$fVal = floatval(trim($arWord[6]));
    		$this->AddSum($fVal);
    		$this->InsertHolding($strHolding, $strName, strval(100.0 * $fVal / $this->fTotalValue));*/
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
		$csv->DebugCash();
   	
		$date_sql = new HoldingsDateSql();
		$date_sql->WriteDate($strStockId, $csv->GetDate());
	}
}

?>
