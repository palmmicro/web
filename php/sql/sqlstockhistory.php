<?php
require_once('sqlstockdaily.php');

// ****************************** StockHistorySql class *******************************************************
class StockHistorySql extends DailyStockSql
{
    function StockHistorySql($strStockId) 
    {
        parent::DailyStockSql($strStockId, TABLE_STOCK_HISTORY);
    }

    function Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	$strStockId = $this->GetId(); 
    	return TableSql::Insert("(id, stock_id, date, open, high, low, close, volume, adjclose) VALUES('0', '$strStockId', '$strDate', '$strOpen', '$strHigh', '$strLow', '$strClose', '$strVolume', '$strAdjClose')");
    }
    
    function Update($strId, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
		return TableSql::Update("open = '$strOpen', high = '$strHigh', low = '$strLow', close = '$strClose', volume = '$strVolume', adjclose = '$strAdjClose' WHERE "._SqlBuildWhere_id($strId));
    }

    function Merge($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
    {
    	if ($history = $this->Get($strDate))
    	{
    		$this->Update($history['id'], $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    	}
    	else
    	{
    		$this->Insert($strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose);
    	}
    }
    
    function UpdateAdjClose($strId, $strAdjClose)
    {
		return TableSql::Update("adjclose = '$strAdjClose' WHERE "._SqlBuildWhere_id($strId));
    }

    function DeleteByZeroVolume()
    {
    	return $this->Delete("volume = '0' AND ".$this->BuildWhere_id());
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
         . ' `volume` BIGINT UNSIGNED NOT NULL ,'
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

?>
