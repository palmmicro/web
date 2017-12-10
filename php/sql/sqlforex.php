<?php

// ****************************** Forex History tables *******************************************************

function SqlCreateForexHistoryTable()
{
    $strQry = 'CREATE TABLE IF NOT EXISTS `camman`.`forexhistory` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `date` DATE NOT NULL ,'
         . ' `close` DOUBLE(10,4) NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `date`, `stock_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($strQry, 'Create forexhistory table failed');
}

function SqlGetForexHistory($strStockId, $strDate)
{
	$strQry = "SELECT * FROM forexhistory WHERE date = '$strDate' AND stock_id = '$strStockId' LIMIT 1";
	return SqlQuerySingleRecord($strQry, 'Query forexhistory by date and stock_id failed');
}

function SqlGetForexHistoryNow($strStockId)
{
	$strQry = "SELECT * FROM forexhistory WHERE stock_id = '$strStockId' ORDER BY `date` DESC LIMIT 1";
	return SqlQuerySingleRecord($strQry, 'Query forexhistory by stock_id failed');
}

function SqlInsertForexHistory($strStockId, $strDate, $strClose)
{
	$strQry = "INSERT INTO forexhistory(id, stock_id, date, close) VALUES('0', '$strStockId', '$strDate', '$strClose')";
	return SqlDieByQuery($strQry, 'Insert forexhistory table failed');
}

// ****************************** Functions *******************************************************

/*
function SqlInsertFuture()
{
    SqlInsertStock('hf_CL', 'NYMEX Oil Future', 'NYMEX原油期货');
    SqlInsertStock('hf_GC', 'COMEX Gold Future', 'COMEX黄金期货');
    SqlInsertStock('hf_NG', 'NYMEX Gas Future', 'NYMEX天然气期货');
    SqlInsertStock('hf_OIL', 'Brent Oil Future', '布伦特原油期货');
    SqlInsertStock('hf_SI', 'COMEX Silver Future', 'COMEX白银期货');
}

function SqlInsertUSCNY()
{
    SqlInsertStock('USCNY', 'USD/CNY Reference Rate', '美元人民币中间价');
}

function SqlInsertHKCNY()
{
    SqlInsertStock('HKCNY', 'HKD/CNY Reference Rate', '港币人民币中间价');
}

function SqlInsertUSCNYHistory($strDate, $strClose)
{
    return SqlInsertForexHistory(SqlGetStockId('USCNY'), $strDate, $strClose);
}
*/

function SqlGetForexCloseHistory($strStockId, $strDate)
{
    $history = SqlGetForexHistory($strStockId, $strDate);
    if ($history)   return floatval($history['close']);
    return false;
}

?>
