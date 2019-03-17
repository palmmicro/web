<?php

// ****************************** Sql database maintenance functions *******************************************************
function ValidateTableIpField($strTableName)
{
    $ar = array();
    if ($result = SqlGetTableData($strTableName)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if (!filter_valid_ip($record['ip']))
            {
                $ar[] = $record['id'];
            }
        }
        @mysql_free_result($result);
    }
    
    $iCount = count($ar);
    DebugVal($iCount, $strTableName.': invalid ip number'); 
    if ($iCount > 0)
    {
        foreach ($ar as $strId)
        {
            SqlDeleteTableDataById($strTableName, $strId);
        }
    }
}

function CorrectBlogTable()
{
    $ar = array();
    if ($result = SqlGetTableData(TABLE_BLOG)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            if (substr($record['uri'], 0, 2) == '//')
            {
                $ar[] = $record['id'];
            }
        }
        @mysql_free_result($result);
    }
    DebugVal(count($ar));
    
    foreach ($ar as $str)
    {
        SqlDeleteTableDataById(TABLE_BLOG, $str);
    }
}

/*
function SqlInsertFuture()
{
    SqlInsertStock('hf_CL', 'NYMEX原油期货');
    SqlInsertStock('hf_GC', 'COMEX黄金期货');
    SqlInsertStock('hf_NG', 'NYMEX天然气期货');
    SqlInsertStock('hf_OIL', 'Brent布伦特原油期货');
    SqlInsertStock('hf_SI', 'COMEX白银期货');
}

function SqlInsertUSCNY()
{
    SqlInsertStock('USCNY', '美元人民币中间价');
}

function SqlInsertHKCNY()
{
    SqlInsertStock('HKCNY', '港币人民币中间价');
}
*/

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

function MergeNavTable()
{
    $fStart = microtime(true);
/*    if ($result = SqlGetTableData(TABLE_FUND_HISTORY)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
        	$sql = new NavHistorySql($record['stock_id']);
        	$sql->Write($record['date'], $record['close']);
        }
        @mysql_free_result($result);
    }*/
    $sql = new UscnyHistorySql();
    $sql->DeleteZeroData();
    DebugString('MergeNavTable: '.DebugGetStopWatchDisplay($fStart));
}

?>
