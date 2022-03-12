<?php
require_once('_holdingscsvfile.php');

class _KraneHoldingsCsvFile extends _HoldingsCsvFile
{
	var $bUse;
	
    var $fUSDHKD;
    var $fMarketValue;
	
    function _KraneHoldingsCsvFile($strDebug, $strStockId, $strDate) 
    {
        parent::_HoldingsCsvFile($strDebug, $strStockId);
        
        $this->strDate = $strDate;

        $this->bUse = false;
        $this->fMarketValue = 0.0; 
        
        $strUscnyId = $this->sql->GetId('USCNY');
        $strHkcnyId = $this->sql->GetId('HKCNY');
        $nav_sql = GetNavHistorySql();
       	$this->fUSDHKD = ($strHKDCNY = $nav_sql->GetClose($strHkcnyId, $strDate)) ? floatval($nav_sql->GetClose($strUscnyId, $strDate)) / floatval($strHKDCNY) : floatval($nav_sql->GetCloseNow($strUscnyId)) / floatval($nav_sql->GetCloseNow($strHkcnyId));
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) != 7)	return;
    	
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
    		if (is_numeric($strHolding))	$strHolding = BuildHongkongStockSymbol($strHolding);
    		if ($this->InsertHolding($strHolding, $strName, $strRatio))		$this->fMarketValue += floatval(str_replace(',', '', $arWord[6]));
    	}
    }
    
    function GetMarketValue()
    {
    	return $this->fMarketValue;
    }
}

// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
// https://kraneshares.com/csv/01_12_2022_kweb_holdings.csv
function SaveKraneHoldingsCsvFile($strSymbol, $strDate)
{
	$arYMD = explode('-', $strDate);
	$strUrl = GetKraneUrl().'csv/'.$arYMD[1].'_'.$arYMD[2].'_'.$arYMD[0].'_'.strtolower($strSymbol).'_holdings.csv';
	return StockSaveHoldingsCsv($strSymbol, $strUrl);	
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

function ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate, $strNav)
{
	if ($strDebug = SaveKraneHoldingsCsvFile($strSymbol, $strDate))
	{
		$csv = new _KraneHoldingsCsvFile($strDebug, $strStockId, $strDate);
		$csv->Read();
		$fMarketValue = $csv->GetMarketValue();
		DebugVal($fMarketValue, 'ReadKraneHoldingsCsvFile');
		if ($fMarketValue > MIN_FLOAT_VAL)
		{
			$shares_sql = new SharesHistorySql();
			$shares_sql->WriteDaily($strStockId, $strDate, strval_round($fMarketValue / floatval($strNav) / 10000.0));

			$date_sql = new HoldingsDateSql();
			$date_sql->WriteDate($strStockId, $strDate);
	
			// copy KWEB holdings to SZ164906 
			if ($strSymbol == 'KWEB')		CopyHoldings($date_sql, $strStockId, SqlGetStockId('SZ164906'));
		}
		else	DebugString('ReadKraneHoldingsCsvFile failed');
	}
}

?>
