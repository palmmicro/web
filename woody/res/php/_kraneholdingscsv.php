<?php
require_once('/php/csvfile.php');
require_once('/php/sql/sqldate.php');

class _KraneHoldingsCsvFile extends CsvFile
{
	var $bUse;
	var $strStockId;
	var $strDate;

	var $sql;
	var $his_sql;
	var $holdings_sql;
	
    var $fUSDHKD;
	
    function _KraneHoldingsCsvFile($strPathName, $strStockId, $strDate) 
    {
        parent::CsvFile($strPathName);
        
        $this->bUse = false;
        $this->strStockId = $strStockId;
        $this->strDate = $strDate;
        
        $this->sql = GetStockSql();
        $this->his_sql = GetStockHistorySql();
        $this->holdings_sql = GetEtfHoldingsSql();
        $this->holdings_sql->DeleteAll($strStockId);
        
        $nav_sql = GetNavHistorySql($strStockId);
        $this->fUSDHKD = floatval($nav_sql->GetClose($this->sql->GetId('USCNY'), $strDate)) / floatval($nav_sql->GetClose($this->sql->GetId('HKCNY'), $strDate));
    }
    
    public function OnLineArray($arWord)
    {
    	$strName = $arWord[1]; 
    	if ($arWord[0] == 'Rank')			$this->bUse = true;
    	else if ($strName == 'Cash')		$this->bUse = false;
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
    		
    		if ($this->his_sql->GetRecord($strId, $this->strDate) == false)
    		{
    			$strShares = str_replace(',', '', $arWord[5]);
    			$strValue = str_replace(',', '', $arWord[6]);
    			$fClose = floatval($strValue) / floatval($strShares);
    			if ($bHk)	$fClose *= $this->fUSDHKD; 
    			$this->his_sql->WriteHistory($strId, $this->strDate, strval($fClose));
    			DebugString('WriteHistory '.$strShares.' '.$strValue);
    		}
    		
    		$this->holdings_sql->InsertHolding($this->strStockId, $strId, $arWord[2]);
    	}
    }
}

// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
function ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate)
{
	$arYMD = explode('-', $strDate);
	$strUrl = GetKraneUrl().'/csv/'.$arYMD[1].'_'.$arYMD[2].'_'.$arYMD[0].'_'.strtolower($strSymbol).'_holdings.csv';
	
	$str = url_get_contents($strUrl);
	if ($str == false)
	{
		DebugString('ReadKraneHoldingsCsvFile没读到数据');
		return;
	}
		
	$strPathName = DebugGetPathName('Holdings_'.$strSymbol.'.csv');
	file_put_contents($strPathName, $str);

	$csv = new _KraneHoldingsCsvFile($strPathName, $strStockId, $strDate);
   	$csv->Read();

	$date_sql = new EtfHoldingsDateSql();
	$date_sql->WriteDate($strStockId, $strDate);
}

?>
