<?php

/*
Array
(
    [0] => Array
        (
            [0] => 1728950400000
            [1] => -0.013070608
        )
)
*/

function GetKraneNav($ref)
{
	$strStockId = $ref->GetStockId();
	$strDate = $ref->GetDate();
	$nav_sql = GetNavHistorySql();
 	$strNavDate = $nav_sql->GetDateNow($strStockId);	
	if ($strNavDate == $strDate)	return false;		// already have current NAV
	$his_sql = GetStockHistorySql();
	$strPrevDate = $his_sql->GetDatePrev($strStockId, $strDate);
	if ($strNavDate == $strPrevDate)	return false;		// already up to date
	
	$ref->SetTimeZone();
	$strSymbol = $ref->GetSymbol();
	$strFileName = DebugGetPathName('NAV_'.$strSymbol.'.txt');
	if (StockNeedFile($strFileName) == false)	return false; 	// updates on every minute

	$strUrl = GetKraneUrl()."product-json/?pid=477&type=premium-discount&start=$strPrevDate&end=$strPrevDate";
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString($strUrl.' save new file to '.$strFileName);
   		file_put_contents($strFileName, $str);
   		$ar = json_decode($str, true);
		if (!isset($ar[0]))			
		{
			DebugString('no data');
			return false;
		}
		return $ar[0][1];
   	}
    return false;
}

?>
