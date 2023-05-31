<?php
require_once('_etfholdings.php');

class _SseHoldingsFile extends _EtfHoldingsFile
{
    function _SseHoldingsFile($strFileName, $strStockId) 
    {
        parent::_EtfHoldingsFile($strFileName, $strStockId);
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
				$this->DeleteAllHoldings();
    			break;
    		
    		case 'NAVperCU':
    			$this->AddCash(floatval($ar[1]));
    			break;
    		}
    	}
    	else
    	{
    		$strHolding = trim($arWord[0]);
    		if (is_numeric($strHolding))
    		{
    			if (strlen($strHolding) <= 5)	$strHolding = BuildHongkongStockSymbol($strHolding);
    			else								$strHolding = BuildChinaStockSymbol($strHolding);
    		}
    		$this->AddHolding($strHolding, GbToUtf8(trim($arWord[1])), floatval(trim($arWord[6])));
    	}
    }
}

function ReadSseHoldingsFile($strSymbol, $strStockId)
{
	switch ($strSymbol)
	{
	case 'SH513050':
		$strEtfType = '087';
		break;
    		
	case 'SH513220':
		$strEtfType = '509';
		break;

	case 'SH513360':
		$strEtfType = '395';
		break;

	}
	$strUrl = 'http://query.sse.com.cn/etfDownload/downloadETF2Bulletin.do?etfType='.$strEtfType;
	$strFileName = $strSymbol.'.txt';
	
	if (StockSaveDebugCsv($strFileName, $strUrl))
	{
		$csv = new _SseHoldingsFile($strFileName, $strStockId);
		$csv->Read();
		return $csv->Done();
	}
	return false;
}

?>
