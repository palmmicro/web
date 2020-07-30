<?php
require_once('_commonupdatestock.php');
require_once('/php/stock/yahoostock.php');

function UpdateIndexTable($arSymbols, $strTableName)
{
	$sql = new TableSql($strTableName);
	$arOld = array();
	if ($result = $sql->GetData()) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $arOld[] = $record['id'];
        }
        @mysql_free_result($result);
    }
    
	$iCount = 0;
	$arNew = array();
	foreach ($arSymbols as $strSymbol)
	{
		if ($strStockId = SqlGetStockId($strSymbol))
		{
			$arNew[] = $strStockId;
			if (in_array($strStockId, $arOld) == false)
			{
				$sql->InsertId($strStockId);
				DebugString('Inserted: '.$strSymbol);
				$iCount ++;
			}
		}
	}
	
	if ($iCount != 0)
	{
		foreach ($arOld as $strStockId)
		{
			if (in_array($strStockId, $arNew) == false)
			{
				$sql->DeleteById($strStockId);
				DebugString('Deleted: '.SqlGetStockSymbol($strStockId));
			}
		}
	}
	
    DebugVal($iCount, 'updated');
}

function _updateDowJones()
{
	if ($ar = YahooUpdateComponents('^DJI'))
	{
		UpdateIndexTable($ar, TABLE_DOW_JONES);
	}
}
	
   	$acct = new Account();
	$acct->AdminCommand('_updateDowJones');
?>
