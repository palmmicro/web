<?php
require_once('sqlstockdaily.php');

// ****************************** SqlStockHistory class *******************************************************
class SqlStockHistory extends SqlStockDaily
{
    // constructor 
    function SqlStockHistory($strStockId) 
    {
        parent::SqlStockDaily($strStockId, TABLE_STOCK_HISTORY);
//        $this->Create();
    }

    function DeleteByZeroVolume()
    {
    	return SqlDeleteTableData($this->strName, "volume = '0' AND ".$this->BuildWhere_stock(), false);
    }

    function Update($strId, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	$strTableName = $this->strName;
    	$strQry = "UPDATE $strTableName SET open = '$strOpen', high = '$strHigh', low = '$strLow', close = '$strClose', volume = '$strVolume', adjclose = '$strAdjClose' WHERE id = '$strId' LIMIT 1";
    	return SqlDieByQuery($strQry, $strTableName.' update table failed');
    }

    function Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	$strTableName = $this->strName;
    	$strStockId = $this->GetStockId(); 
    	$strQry = "INSERT INTO $strTableName(id, stock_id, date, open, high, low, close, volume, adjclose) VALUES('0', '$strStockId', '$strDate', '$strOpen', '$strHigh', '$strLow', '$strClose', '$strVolume', '$strAdjClose')";
    	return SqlDieByQuery($strQry, $strTableName.' insert table failed');
    }
}

// ****************************** Stock History tables *******************************************************

// Date,Open,High,Low,Close,Volume
function SqlCreateStockHistoryTable()
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`stockhistory` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `open` DOUBLE(10,3) NOT NULL ,'
         . ' `high` DOUBLE(10,3) NOT NULL ,'
         . ' `low` DOUBLE(10,3) NOT NULL ,'
         . ' `close` DOUBLE(10,3) NOT NULL ,'
         . ' `volume` INT UNSIGNED NOT NULL ,'
         . ' `adjclose` DOUBLE(13,6) NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `date`, `stock_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, 'Create stockhistory table failed');
}

/*
function SqlAlterStockHistoryTable()
{    
    $strQry = 'ALTER TABLE `camman`.`stockhistory` ADD '
         . ' `adjclose` DOUBLE(13,6) NOT NULL';   // ALTER TABLE这个写法每次只能改一个
	return SqlDieByQuery($strQry, 'Alter stockhistory table failed');
}
*/

function SqlGetStockHistory($strStockId, $iStart, $iNum)
{
	$sql = new SqlStockHistory($strStockId);
	return $sql->GetAll($iStart, $iNum);
//    return SqlGetTableData(TABLE_STOCK_HISTORY, _SqlBuildWhere_stock($strStockId), _SqlOrderByDate(), _SqlBuildLimit($iStart, $iNum));
}

function SqlGetStockHistoryByDate($strStockId, $strDate)
{
	$sql = new SqlStockHistory($strStockId);
	return $sql->Get($strDate);
//	return SqlGetUniqueTableData(TABLE_STOCK_HISTORY, _SqlBuildWhere_date_stock($strDate, $strStockId));
}

function SqlGetStockHistoryFromDate($strStockId, $strDate, $iNum)
{
    return SqlGetTableData(TABLE_STOCK_HISTORY, "stock_id = '$strStockId' AND date <= '$strDate'", _SqlOrderByDate(), _SqlBuildLimit(0, $iNum));
}

function SqlUpdateStockHistoryAdjClose($strId, $strAdjClose)
{
	$strQry = "UPDATE stockhistory SET adjclose = '$strAdjClose' WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockhistory table adjclose failed');
}

function SqlMergeStockHistory($sql, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
{
    if ($history = $sql->Get($strDate))
    {
        $sql->Update($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    }
    else
    {
        $sql->Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    }
}

?>
