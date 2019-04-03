<?php

class NetValueCsvFile extends CsvFile
{
	var $sql;
	var $oldest_ymd;
	
    function NetValueCsvFile($strPathName, $strSymbol) 
    {
        parent::CsvFile($strPathName);
        $this->sql = new NetvalueHistorySql(SqlGetStockId($strSymbol));
		$this->oldest_ymd = new OldestYMD();
    }

    function OnLineArray($arWord)
    {
    	if (empty($arWord[1]) == false)
    	{
    		$ymd = new TickYMD(strtotime($arWord[0]));
    		$strDate = $ymd->GetYMD();
   			if ($this->oldest_ymd->IsInvalid($strDate) == false)
   			{
   				$this->sql->Insert($strDate, $arWord[1]);
   			}
    	}
    }
}

function SaveHistoricalNetvalue($strSymbol = 'XOP')
{
	$strPathName = '/debug/'.$strSymbol.'_Historical.csv';
	$csv = new NetValueCsvFile($strPathName, $strSymbol);
	$csv->Read();
	return $strPathName;
}            

?>
