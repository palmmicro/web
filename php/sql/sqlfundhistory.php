<?php

// ****************************** Fund History tables *******************************************************

// Date, Net Value, Estimated Value, Estimated Time
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
	return SqlDieByQuery($str, 'Create fundhistory table failed');
}

function SqlGetFundHistoryNow($strStockId)
{
	return SqlGetSingleTableData(TABLE_FUND_HISTORY, _SqlBuildWhere_stock($strStockId), _SqlOrderByDate());
/*	if ($result = SqlGetFundHistory($strStockId, 0, 1))
	{
	    $history = mysql_fetch_assoc($result);
	    return $history;
	}
	return false;*/
}

function SqlCountFundHistory($strStockId)
{
    return SqlCountTableData(TABLE_FUND_HISTORY, _SqlBuildWhere_stock($strStockId));
}

function SqlGetFundHistory($strStockId, $iStart, $iNum)
{
    return SqlGetTableData(TABLE_FUND_HISTORY, _SqlBuildWhere_stock($strStockId), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
}

function SqlGetFundHistoryByDate($strStockId, $strDate)
{
	return SqlGetUniqueTableData(TABLE_FUND_HISTORY, _SqlBuildWhere_date_stock($strDate, $strStockId));
}

function SqlGetFundNetValueByDate($strStockId, $strDate)
{
	if ($history = SqlGetFundHistoryByDate($strStockId, $strDate))
	{
		return floatval($history['netvalue']);
	}
	return false;
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
