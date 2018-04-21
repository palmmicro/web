<?php

define('TABLE_AH_STOCK', 'ahstock');
define('TABLE_ADRH_STOCK', 'adrhstock');
define('TABLE_LEVERAGE_ETF', 'leverageetf');

// ****************************** Stock pair tables *******************************************************

function SqlCreateStockPairTable($strTableName)
{
    $str = 'CREATE TABLE IF NOT EXISTS `camman`.`'
         . $strTableName
         . '` ('
         . ' `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,'
         . ' `stock_id` INT UNSIGNED NOT NULL ,'
         . ' `pair_id` INT UNSIGNED NOT NULL ,'
         . ' `ratio` DOUBLE(10,6) NOT NULL ,'
         . ' FOREIGN KEY (`stock_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' INDEX ( `pair_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, $strTableName.' create table failed');
}

function SqlInsertStockPair($strTableName, $strStockId, $strPairId, $strRatio)
{
    if ($strStockId == false || $strPairId == false)    return false;
    
	$strQry = 'INSERT INTO '.$strTableName."(id, stock_id, pair_id, ratio) VALUES('0', '$strStockId', '$strPairId', '$strRatio')";
	return SqlDieByQuery($strQry, $strTableName.' insert stock pair failed');
}

function SqlUpdateStockPair($strTableName, $strId, $strStockId, $strPairId, $strRatio)
{
	$strQry = "UPDATE $strTableName SET stock_id = '$strStockId', pair_id = '$strPairId', ratio = '$strRatio' WHERE id = '$strId' LIMIT 1";
	return SqlDieByQuery($strQry, $strTableName.' update stock pair failed');
}

function SqlGetStockPair($strTableName, $strStockId)
{
    return SqlGetUniqueTableData($strTableName, _SqlBuildWhere_stock($strStockId));
}

function SqlGetStockPairId($strTableName, $strStockId)
{
    if ($record = SqlGetStockPair($strTableName, $strStockId))
    {
		return $record['pair_id'];
    }
    return false;
}

function SqlGetStockPairRatio($strTableName, $strStockId)
{
    if ($record = SqlGetStockPair($strTableName, $strStockId))
    {
		return floatval($record['ratio']);
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

function SqlGetStockPairArray($strTableName)
{
	$ar = array();
	if ($result = SqlGetTableData($strTableName, false, false, false)) 
    {
        while ($record = mysql_fetch_assoc($result)) 
        {
            $ar[] = SqlGetStockSymbol($record['stock_id']);
        }
        @mysql_free_result($result);
    }
    sort($ar);
	return $ar;
}

function SqlGetAhArray()
{
	return SqlGetStockPairArray(TABLE_AH_STOCK);
}

function SqlGetAdrhArray()
{
	return SqlGetStockPairArray(TABLE_ADRH_STOCK);
}

function SqlGetAhPairRatio($a_ref)
{
	return SqlGetStockPairRatio(TABLE_AH_STOCK, $a_ref->GetStockId());
}

function SqlGetAdrhPairRatio($adr_ref)
{
	return SqlGetStockPairRatio(TABLE_ADRH_STOCK, $adr_ref->GetStockId());
}

function SqlGetPair($strTableName, $strSymbol, $callback)
{
	if ($strStockId = SqlGetStockId($strSymbol))
	{
//		if ($strPairId = SqlGetStockPairId($strTableName, $strStockId))
		if ($strPairId = call_user_func($callback, $strTableName, $strStockId))
		{
			return SqlGetStockSymbol($strPairId);
		}
	}
	return false;
}

function SqlGetAhPair($strSymbolA)
{
	return SqlGetPair(TABLE_AH_STOCK, $strSymbolA, SqlGetStockPairId);
}

function SqlGetAdrhPair($strSymbolAdr)
{
	return SqlGetPair(TABLE_ADRH_STOCK, $strSymbolAdr, SqlGetStockPairId);
}

function SqlGetHaPair($strSymbolH)
{
	return SqlGetPair(TABLE_AH_STOCK, $strSymbolH, SqlGetStockPairStockId);
}

function SqlGetHadrPair($strSymbolH)
{
	return SqlGetPair(TABLE_ADRH_STOCK, $strSymbolH, SqlGetStockPairStockId);
}

?>
