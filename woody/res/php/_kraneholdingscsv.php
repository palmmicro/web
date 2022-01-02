<?php
require_once('/php/csvfile.php');
require_once('/php/stockhis.php');
require_once('/php/stock/updatestockhistory.php');

class _KraneHoldingsCsvFile extends CsvFile
{
	var $bUse;
	var $strStockId;
	var $strDate;

	var $sql;
	var $his_sql;
	var $holdings_sql;
	
    var $fUSDHKD;
    var $fMarketValue;
	
    function _KraneHoldingsCsvFile($strPathName, $strStockId, $strDate) 
    {
        parent::CsvFile($strPathName);
        
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
    	if (count($arWord) < 2)	return;
    	
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

// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
function SaveKraneHoldingsCsvFile($strSymbol, $strDate)
{
	$arYMD = explode('-', $strDate);
	$strUrl = GetKraneUrl().'csv/'.$arYMD[1].'_'.$arYMD[2].'_'.$arYMD[0].'_'.strtolower($strSymbol).'_holdings.csv';
	return SaveHoldingsCsvFile($strSymbol, $strUrl);	
}

function CopyHoldings($strStockId)
{
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

	$strId = SqlGetStockId('SZ164906');
	$holdings_sql->DeleteAll($strId);
    $holdings_sql->InsertHoldingsArray($strId, $ar);

	$date_sql = new HoldingsDateSql();
	$strDate = $date_sql->ReadDate($strStockId); 
	$date_sql->WriteDate($strId, $strDate);
}

function ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate, $strNav)
{
	$strPathName = SaveKraneHoldingsCsvFile($strSymbol, $strDate);
 	if ($strPathName === false)		return;
 	
	$csv = new _KraneHoldingsCsvFile($strPathName, $strStockId, $strDate);
   	$csv->Read();
   	$fMarketValue = $csv->GetMarketValue();
   	if ($fMarketValue < MIN_FLOAT_VAL)	return;
   	
	$shares_sql = new SharesHistorySql();
	$shares_sql->WriteDaily($strStockId, $strDate, strval_round($fMarketValue / floatval($strNav) / 10000.0));

	$date_sql = new HoldingsDateSql();
	$date_sql->WriteDate($strStockId, $strDate);
	
	if ($strSymbol != 'KWEB')		return;		// next step: copy SZ164906 holdings
	CopyHoldings($strStockId);
}

?>
