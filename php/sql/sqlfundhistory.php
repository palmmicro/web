<?php
//require_once('sqlstockdaily.php');
require_once('sqlstockhistory.php');

// ****************************** SqlStockHistory class *******************************************************
class SqlFundHistory extends SqlStockDaily
{
	var $stock;
	
    // constructor 
    function SqlFundHistory($strStockId) 
    {
        parent::SqlStockDaily($strStockId, TABLE_FUND_HISTORY);
        $this->stock = new SqlStockHistory($strStockId);
    }
}

// ****************************** Fund History tables *******************************************************

// Date, Net Value, Estimated Value, Estimated Time
function SqlCreateFundHistoryTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`fundhistory` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `close` DOUBLE(13,6) NOT NULL ,'
         . ' `estimated` DOUBLE(10,4) NOT NULL ,'
         . ' `time` TIME NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `date`, `stock_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create fundhistory table failed');
}

function SqlGetFundHistoryNow($strStockId)
{
	$sql = new SqlFundHistory($strStockId);
	return $sql->GetNow();
//	return SqlGetSingleTableData(TABLE_FUND_HISTORY, _SqlBuildWhere_stock($strStockId), _SqlOrderByDate());
}

function SqlGetFundHistoryByDate($strStockId, $strDate)
{
	$sql = new SqlFundHistory($strStockId);
	return $sql->Get($strDate);
//	return SqlGetSingleTableData(TABLE_FUND_HISTORY, _SqlBuildWhere_date_stock($strDate, $strStockId));
}

function SqlGetNetValueByDate($strStockId, $strDate)
{
	$sql = new SqlFundHistory($strStockId);
	return $sql->GetCloseString($strDate);
/*	if ($history = SqlGetFundHistoryByDate($strStockId, $strDate))
	{
		return $history['close'];
	}
	return false;*/
}

function SqlGetFundNetValueByDate($strStockId, $strDate)
{
	$sql = new SqlFundHistory($strStockId);
	return $sql->GetClose($strDate);
/*	if ($str = SqlGetNetValueByDate($strStockId, $strDate))
	{
		return floatval($str);
	}
	return false;*/
}

function SqlInsertFundHistory($strStockId, $strDate, $strNetValue, $strEstimated, $strTime)
{
	$strQry = "INSERT INTO fundhistory(id, stock_id, date, close, estimated, time) VALUES('0', '$strStockId', '$strDate', '$strNetValue', '$strEstimated', '$strTime')";
	return SqlDieByQuery($strQry, 'Insert fundhistory table failed');
}

function SqlUpdateFundHistory($strId, $strNetValue, $strEstimated, $strTime)
{
	$strQry = "UPDATE fundhistory SET close = '$strNetValue', estimated = '$strEstimated', time = '$strTime' WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update fundhistory table failed');
}

?>
