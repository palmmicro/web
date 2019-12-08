<?php

// ****************************** Sql database maintenance functions *******************************************************
function WriteForexDataFromFile()
{
	$uscny_sql = new UscnyHistorySql();
	$hkcny_sql = new HkcnyHistorySql();
    $file = fopen('/debug/cny2018.csv', 'r');
//    $file = fopen('/debug/cny2017.csv', 'r');
//    $file = fopen('/debug/cny2016.csv', 'r');
//    $file = fopen('/debug/cny2015.csv', 'r');
//    $file = fopen('/debug/cny2014.csv', 'r');
    if ($file == false)
    {
    	DebugString('Can not open read file');
    	return;
    }
    
    while (!feof($file))
    {
        $strLine = fgets($file);
        $arWord = explode(',', $strLine);
        if (count($arWord) >= 5)
        {
        	$strDate = $arWord[0];
        	$strUSD = $arWord[1];
        	$strHKD = $arWord[4];
//        	DebugString($strDate.' '.$strUSD.' '.$strHKD);
        	
       		$uscny_sql->Write($strDate, $strUSD);
       		$hkcny_sql->Write($strDate, $strHKD);
        }
    }
    fclose($file);
}

?>
