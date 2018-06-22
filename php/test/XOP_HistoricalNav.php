<?php

class NavCsvFile extends CsvFile
{
	var $sql;
	var $oldest_ymd;
	
    function NavCsvFile($strPathName, $strSymbol) 
    {
        parent::CsvFile($strPathName);
        $this->sql = new FundHistorySql(SqlGetStockId($strSymbol));
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
   				$this->sql->UpdateNetValue($strDate, $arWord[1]);
   			}
    	}
    }
}

function SaveHistoricalNav($strSymbol = 'XOP')
{
	$csv = new NavCsvFile('/debug/XOP_HistoricalNav.csv', $strSymbol);
	$csv->Read();
}            

?>
