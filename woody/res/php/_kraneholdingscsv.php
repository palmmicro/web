<?php
require_once('_holdingscsvfile.php');

class _KraneHoldingsCsvFile extends _HoldingsCsvFile
{
	var $bUse;
	
    function _KraneHoldingsCsvFile($strFileName, $strStockId, $strDate) 
    {
        parent::_HoldingsCsvFile($strFileName, $strStockId);
        $this->SetDate($strDate);
        
        $this->bUse = false;
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) != 7)	return;
    	
    	$strName = $arWord[1];
//    	DebugString($strName);
    	if (($strName == 'HONG KONG DOLLAR') || ($strName == 'Cash'))	return;
    	
    	$strRatio = $arWord[2];
    	if ($arWord[0] == 'Rank')
    	{
    		$this->DeleteAllHoldings();
    		$this->bUse = true;
    	}
    	else if (floatval($strRatio) < 0.01)		$this->bUse = false;
    	else if ($this->bUse)
    	{
    		$strHolding = $arWord[3];
    		if (is_numeric($strHolding))	$strHolding = BuildHongkongStockSymbol($strHolding);
    		if ($this->InsertHolding($strHolding, $strName, $strRatio))		$this->AddSum(floatval(str_replace(',', '', $arWord[6])));
    	}
    }
}

function CopyHoldings($date_sql, $strStockId, $strDstId)
{
	$strDate = $date_sql->ReadDate($strStockId);
	if (SqlGetNavByDate($strDstId, $strDate) === false)	return;
	$date_sql->WriteDate($strDstId, $strDate);
	
    $holdings_sql = GetHoldingsSql();
   	$ar = $holdings_sql->GetHoldingsArray($strStockId);
   	$arStrict = GetSecondaryListingArray();    	
   	foreach ($ar as $strHoldingId => $strRatio)
   	{
		$strHoldingSymbol = SqlGetStockSymbol($strHoldingId);
		if (isset($arStrict[$strHoldingSymbol]))
		{	// Hong Kong secondary listings
			$strStrictId = SqlGetStockId($arStrict[$strHoldingSymbol]);
			if (isset($ar[$strStrictId]))
			{
				$ar[$strStrictId] = strval(floatval($strRatio) + floatval($ar[$strStrictId]));
			}
			else
			{
				$ar[$strStrictId] = $strRatio;
			}
			unset($ar[$strHoldingId]);
		}
   	}

	$holdings_sql->DeleteAll($strDstId);
    $holdings_sql->InsertHoldingsArray($strDstId, $ar);
}

// https://kraneshares.com/csv/01_12_2022_kweb_holdings.csv
function ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate, $strNav)
{
	$arYMD = explode('-', $strDate);
	$strFileName = $arYMD[1].'_'.$arYMD[2].'_'.$arYMD[0].'_'.strtolower($strSymbol).'_holdings.csv';
	$strUrl = GetKraneUrl().'csv/'.$strFileName;
	$strHeaders = array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36',
//							'x-test: true',
//							'x-test2: true',
//							'stream: True'
							);
	
	if (StockSaveDebugCsv($strFileName, $strUrl, $strHeaders))
//	if (StockSaveDebugCsv($strFileName, $strUrl))
	{
		$csv = new _KraneHoldingsCsvFile($strFileName, $strStockId, $strDate);
		$csv->Read();
		$fMarketValue = $csv->GetSum();
		DebugVal($fMarketValue, 'ReadKraneHoldingsCsvFile');
		if ($fMarketValue > MIN_FLOAT_VAL)
		{
			$csv->UpdateHoldingsDate();

			$shares_sql = new SharesHistorySql();
			$shares_sql->WriteDaily($strStockId, $strDate, strval_round($fMarketValue / floatval($strNav) / 10000.0));
	
			if ($strSymbol == 'KWEB')		CopyHoldings(new HoldingsDateSql(), $strStockId, SqlGetStockId('SZ164906'));
		}
		else	DebugString('ReadKraneHoldingsCsvFile failed');
	}
}

?>
