<?php
require_once('_etfholdings.php');

class _SseHoldingsFile extends _EtfHoldingsFile
{
    public function __construct($strFileName, $strStockId) 
    {
        parent::__construct($strFileName, $strStockId);
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
    			$this->SetDate(ConvertYMD($ar[1]));
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

	case 'SH513090':
		$strEtfType = '254';
		break;

	case 'SH513220':
		$strEtfType = '509';
		break;

	case 'SH513230':
		$strEtfType = '459';
		break;

	case 'SH513360':
		$strEtfType = '395';
		break;

	case 'SH513750':
		$strEtfType = '607';
		break;
		
	case 'SH513850':
		$strEtfType = '577';
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
