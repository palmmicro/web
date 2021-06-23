<?php
require_once('/php/csvfile.php');

class _KraneHoldingsCsvFile extends CsvFile
{
	var $bUse;
	
    function _KraneHoldingsCsvFile($strPathName) 
    {
        parent::CsvFile($strPathName);
        
        $this->bUse = false;
    }
    
    public function OnLineArray($arWord)
    {
    	if ($arWord[0] == 'Rank')			$this->bUse = true;
    	else if ($arWord[1] == 'Cash')	$this->bUse = false;
    	else if ($this->bUse)
    	{
    		DebugString($arWord[1]);
    	}
    }
}

// https://kraneshares.com/csv/06_22_2021_kweb_holdings.csv
function ReadKraneHoldingsCsvFile($strSymbol, $strDate)
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

	$csv = new _KraneHoldingsCsvFile($strPathName);
   	$csv->Read();
}

?>
