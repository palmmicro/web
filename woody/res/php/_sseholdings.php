<?php
require_once('/php/csvfile.php');

class _SseHoldingsFile extends CsvFile
{
	var $strStockId;

	var $strDate;
    var $fTotalValue;

	var $sql;
	var $his_sql;
	var $holdings_sql;
	
    function _SseHoldingsFile($strPathName, $strStockId) 
    {
        parent::CsvFile($strPathName);
        $this->SetSeparator('|');
        
        $this->strStockId = $strStockId;
        
        $this->sql = GetStockSql();
        $this->his_sql = GetStockHistorySql();
        $this->holdings_sql = GetEtfHoldingsSql();
        $this->holdings_sql->DeleteAll($strStockId);
    }
    
    public function OnLineArray($arWord)
    {
    	if (count($arWord) == 1)
    	{
    	}
    	else
    	{
	    	DebugPrint($arWord);
/*    		$strHolding = $arWord[3];
    		if (is_numeric($strHolding))		
    		{
    			$strHolding = BuildHongkongStockSymbol($strHolding);
    			$bHk = true;
    		}
    		else	$bHk = false;
   			$this->sql->InsertSymbol($strHolding, $strName);
    		$strId = $this->sql->GetId($strHolding);
    		
   			$strValue = str_replace(',', '', $arWord[6]);
   			$fValue = floatval($strValue);
   			$this->fTotalValue += $fValue;
    		if ($this->his_sql->GetRecord($strId, $this->strDate) === false)
    		{
    			DebugString($strHolding.' missing data on '.$this->strDate);
    			$strShares = str_replace(',', '', $arWord[5]);
    			$fClose = $fValue / floatval($strShares);
    			if ($bHk)	$fClose *= $this->fUSDHKD; 
    			$strClose = strval_round($fClose, 3);
    			if ($this->his_sql->WriteHistory($strId, $this->strDate, $strClose))		DebugString('WriteHistory '.$strHolding.' '.$strClose.' '.$strShares.' '.$strValue);
    		}
    		
    		$this->holdings_sql->InsertHolding($this->strStockId, $strId, $arWord[2]);*/
    	}
    }
}

function ReadSseHoldingsFile($strSymbol, $strStockId)
{
	$strUrl = 'http://query.sse.com.cn/etfDownload/downloadETF2Bulletin.do?etfType=087';
	$str = url_get_contents($strUrl);
	if ($str == false)
	{
		DebugString('ReadSseHoldingsFile没读到数据');
		return;
	}
		
	$strPathName = DebugGetPathName('Holdings_'.$strSymbol.'.csv');
	file_put_contents($strPathName, $str);
	DebugString('Saved '.$strUrl.' to '.$strPathName);

	$csv = new _SseHoldingsFile($strPathName, $strStockId);
   	$csv->Read();
   	
//	$date_sql = new EtfHoldingsDateSql();
//	$date_sql->WriteDate($strStockId, $strDate);
}

?>
