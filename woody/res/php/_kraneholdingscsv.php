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
    var $fTotalValue;
	
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
        
        $this->fTotalValue = 0.0; 
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) < 2)	return;
    	
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
    		
   			$this->fTotalValue += floatval(str_replace(',', '', $arWord[6]));
    		if ($this->his_sql->GetRecord($strId, $this->strDate) === false)
    		{
    			DebugString($strHolding.' missing data on '.$this->strDate);
//		        UpdateStockHistory(new StockSymbol($strHolding), $strId);
    		}
    		
    		$this->holdings_sql->InsertHolding($this->strStockId, $strId, $arWord[2]);
    	}
    }
}

// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
function ReadKraneHoldingsCsvFile($strSymbol, $strStockId, $strDate, $strNav)
{
	$arYMD = explode('-', $strDate);
	$strUrl = GetKraneUrl().'csv/'.$arYMD[1].'_'.$arYMD[2].'_'.$arYMD[0].'_'.strtolower($strSymbol).'_holdings.csv';

	$str = url_get_contents($strUrl);
	if ($str == false)
	{
		DebugString('ReadKraneHoldingsCsvFile没读到数据');
		return;
	}
		
	$strPathName = DebugGetPathName('Holdings_'.$strSymbol.'.csv');
	file_put_contents($strPathName, $str);
	DebugString('Saved '.$strUrl.' to '.$strPathName);

	$csv = new _KraneHoldingsCsvFile($strPathName, $strStockId, $strDate);
   	$csv->Read();
   	
	$shares_sql = new SharesHistorySql();
	$shares_sql->WriteDaily($strStockId, $strDate, strval_round($csv->fTotalValue / floatval($strNav) / 10000.0));

	$date_sql = new EtfHoldingsDateSql();
	$date_sql->WriteDate($strStockId, $strDate);
}

?>
