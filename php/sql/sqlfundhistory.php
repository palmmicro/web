<?php

// ****************************** Fund History tables *******************************************************

// Date, Net Value, Estimated Value, Estimated Time
/*
function SqlCreateFundHistoryTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`fundhistory` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `netvalue` DOUBLE(10,4) NOT NULL ,'
         . ' `estimated` DOUBLE(10,4) NOT NULL ,'
         . ' `time` TIME NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `date`, `stock_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	$result = @mysql_query($str);
	if (!$result)	die('Create fundhistory table failed');
}
*/

function SqlGetFundHistoryNow($strStockId)
{
	if ($result = SqlGetFundHistory($strStockId, 0, 1))
	{
	    $history = mysql_fetch_assoc($result);
	    return $history;
	}
	return false;
}

function SqlCountFundHistory($strStockId)
{
    return SqlCountTableData('fundhistory', _SqlBuildWhere('stock_id', $strStockId));
}

function SqlGetFundHistory($strStockId, $iStart, $iNum)
{
    return SqlGetTableData('fundhistory', _SqlBuildWhere('stock_id', $strStockId), '`date` DESC', _SqlBuildLimit($iStart, $iNum));
}

function SqlGetFundHistoryByDate($strStockId, $strDate)
{
	$strQry = "SELECT * FROM fundhistory WHERE date = '$strDate' AND stock_id = '$strStockId' LIMIT 1";
	return SqlQuerySingleRecord($strQry, 'Query fundhistory by date failed');
}

function SqlInsertFundHistory($strStockId, $strDate, $strNetValue, $strEstimated, $strTime)
{
	$strQry = "INSERT INTO fundhistory(id, stock_id, date, netvalue, estimated, time) VALUES('0', '$strStockId', '$strDate', '$strNetValue', '$strEstimated', '$strTime')";
	return SqlDieByQuery($strQry, 'Insert fundhistory table failed');
}

function SqlUpdateFundHistory($strId, $strNetValue, $strEstimated, $strTime)
{
	$strQry = "UPDATE fundhistory SET netvalue = '$strNetValue', estimated = '$strEstimated', time = '$strTime' WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update fundhistory table failed');
}

?>
