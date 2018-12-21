<?php

class NavCsvFile extends CsvFile
{
	var $sql;
	var $oldest_ymd;
	
    function NavCsvFile($strPathName, $strSymbol) 
    {
        parent::CsvFile($strPathName);
        $this->sql = new NavHistorySql(SqlGetStockId($strSymbol));
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

function SaveHistoricalNav($strSymbol = 'XOP')
{
	$strPathName = '/debug/'.$strSymbol.'_HistoricalNav.csv';
	$csv = new NavCsvFile($strPathName, $strSymbol);
	$csv->Read();
	return $strPathName;
}            

?>
