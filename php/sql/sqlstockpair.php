<?php

define('TABLE_AHSTOCK', 'ahstock');
define('TABLE_HADR', 'hadr');

// ****************************** Stock pair tables *******************************************************

function SqlCreateStockPairTable($strTableName)
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`'
         . $strTableName
         . '` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `pair_id` INT UNSIGNED NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `pair_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, $strTableName.' create table failed');
}

function SqlInsertStockPair($strTableName, $strStockId, $strPairId)
{
    if ($strStockId == false || $strPairId == false)    return false;
    
	$strQry = 'INSERT INTO '.$strTableName."(id, stock_id, pair_id) VALUES('0', '$strStockId', '$strPairId')";
	return SqlDieByQuery($strQry, $strTableName.' insert stock pair failed');
}

function SqlGetStockPairId($strTableName, $strStockId)
{
    if ($record = SqlGetUniqueTableData($strTableName, _SqlBuildWhere_stock($strStockId)))
    {
		return $record['pair_id'];
    }
    return false;
}

function SqlGetStockPairStockId($strTableName, $strPairId)
{
    if ($record = SqlGetUniqueTableData($strTableName, _SqlBuildWhere('pair_id', $strPairId)))
    {
		return $record['stock_id'];
    }
    return false;
}

// ****************************** Support functions *******************************************************

function SqlGetAhSymbolArray()
{
	$ar = array();
	if ($result = SqlGetTableData(TABLE_AHSTOCK, false, false, false)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $strSymbolA = SqlGetStockSymbol($record['stock_id']);
            $strSymbolH = SqlGetStockSymbol($record['pair_id']);
            $ar[$strSymbolA] = $strSymbolH;
        }
        @mysql_free_result($result);
    }
	return $ar;
}

function SqlGetAhPairIdById($strStockIdA)
{
	return SqlGetStockPairId(TABLE_AHSTOCK, $strStockIdA);
}

function SqlGetAhPairId($strSymbolA)
{
	if ($strStockIdA = SqlGetStockId($strSymbolA))
	{
		return SqlGetAhPairIdById($strStockIdA);
	}
	return false;
}

function SqlGetAhPair($strSymbolA)
{
	if ($strStockId = SqlGetAhPairId($strSymbolA))
	{
		return SqlGetStockSymbol($strStockId);
	}
	return false;
}

function SqlGetHaPairIdById($strStockIdH)
{
	return SqlGetStockPairStockId(TABLE_AHSTOCK, $strStockIdH);
}

function SqlGetHaPairId($strSymbolH)
{
	if ($strStockIdH = SqlGetStockId($strSymbolH))
	{
		return SqlGetHaPairIdById($strStockIdH);
	}
	return false;
}

function SqlGetHaPair($strSymbolH)
{
	if ($strStockId = SqlGetHaPairId($strSymbolH))
	{
		return SqlGetStockSymbol($strStockId);
	}
	return false;
}

?>
