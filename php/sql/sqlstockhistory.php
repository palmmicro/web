<?php

// ****************************** Stock History tables *******************************************************

// Date,Open,High,Low,Close,Volume
/*
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
	$result = @mysql_query($str);
	if (!$result)	die('Create stockhistory table failed');
}

function SqlAlterStockHistoryTable()
{    
    $strQry = 'ALTER TABLE `camman`.`stockhistory` ADD '
         . ' `adjclose` DOUBLE(13,6) NOT NULL';   // ALTER TABLE这个写法每次只能改一个
	return SqlDieByQuery($strQry, 'Alter stockhistory table failed');
}
*/

function SqlGetStockHistoryNow($strStockId)
{
	if ($result = SqlGetStockHistory($strStockId, 0, 1))
	{
	    $history = mysql_fetch_assoc($result);
	    return $history;
	}
	return false;
}

function SqlCountStockHistory($strStockId)
{
    return SqlCountTableData('stockhistory', _SqlBuildWhere('stock_id', $strStockId));
}

function SqlGetStockHistory($strStockId, $iStart, $iNum)
{
    return SqlGetTableData('stockhistory', _SqlBuildWhere('stock_id', $strStockId), '`date` DESC', _SqlBuildLimit($iStart, $iNum));
}

function SqlGetStockHistoryByDate($strStockId, $strDate)
{
	$strQry = "SELECT * FROM stockhistory WHERE date = '$strDate' AND stock_id = '$strStockId' LIMIT 1";
	return SqlQuerySingleRecord($strQry, 'Query stockhistory by date and stock_id failed');
}

function SqlInsertStockHistory($strStockId, $strDate, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
{
	$strQry = "INSERT INTO stockhistory(id, stock_id, date, open, high, low, close, volume, adjclose) VALUES('0', '$strStockId', '$strDate', '$strOpen', '$strHigh', '$strLow', '$strClose', '$strVolume', '$strAdjClose')";
	return SqlDieByQuery($strQry, 'Insert stockhistory table failed');
}

function SqlUpdateStockHistory($strId, $strOpen, $strHigh, $strLow, $strClose, $strVolume, $strAdjClose)
{
	$strQry = "UPDATE stockhistory SET open = '$strOpen', high = '$strHigh', low = '$strLow', close = '$strClose', volume = '$strVolume', adjclose = '$strAdjClose' WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockhistory table failed');
}

function SqlUpdateStockHistoryAdjClose($strId, $strAdjClose)
{
	$strQry = "UPDATE stockhistory SET adjclose = '$strAdjClose' WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, 'Update stockhistory table adjclose failed');
}

function SqlDeleteStockHistoryWithZeroVolume($strStockId)
{
    return SqlDeleteTableData('stockhistory', "volume = '0' AND stock_id = '$strStockId'", false);
}

function SqlUpdateStockHistoryAdjCloseByDividend($strStockId, $fDividend)
{
    $ar = array();
    if ($result = SqlGetStockHistory($strStockId, 0, 0)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
//            if ($history['date'])
//            {
                $ar[$history['id']] = floatval($history['adjclose']);
//            }
        }
        @mysql_free_result($result);
    }

    foreach ($ar as $strId => $fAdjClose)
    {
        $fAdjClose -= $fDividend;
        SqlUpdateStockHistoryAdjClose($strId, strval($fAdjClose));
    }
}

?>
