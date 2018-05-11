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

    function Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	$strStockId = $this->GetStockId(); 
    	return SqlTable::Insert("(id, stock_id, date, open, high, low, close, volume, adjclose) VALUES('0', '$strStockId', '$strDate', '$strOpen', '$strHigh', '$strLow', '$strClose', '$strVolume', '$strAdjClose')");
    }
    
    function Update($strId, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
		return SqlTable::Update("open = '$strOpen', high = '$strHigh', low = '$strLow', close = '$strClose', volume = '$strVolume', adjclose = '$strAdjClose' WHERE "._SqlBuildWhere_id($strId));
    }

    function UpdateAdjClose($strId, $strAdjClose)
    {
		return SqlTable::Update("adjclose = '$strAdjClose' WHERE "._SqlBuildWhere_id($strId));
    }

    function DeleteByZeroVolume()
    {
    	return $this->Delete("volume = '0' AND ".$this->BuildWhere_stock(), false);
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

function SqlGetStockHistoryByDate($strStockId, $strDate)
{
	$sql = new SqlStockHistory($strStockId);
	return $sql->Get($strDate);
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
