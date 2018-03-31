<?php

define('TABLE_AH_STOCK', 'ahstock');
define('TABLE_ADRH_STOCK', 'adrhstock');

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
         . ' UNIQUE ( `pair_id` )'
         . ' ) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci '; 
	return SqlDieByQuery($str, $strTableName.' create table failed');
}

function SqlInsertStockPair($strTableName, $strStockId, $strPairId, $strRatio)
{
    if ($strStockId == false || $strPairId == false)    return false;
    
	$strQry = 'INSERT INTO '.$strTableName."(id, stock_id, pair_id, ratio) VALUES('0', '$strStockId', '$strPairId', '$strRatio')";
	return SqlDieByQuery($strQry, $strTableName.' insert stock pair failed');
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

function SqlGetAhPairRatio($ref_a)
{
	return SqlGetStockPairRatio(TABLE_AH_STOCK, $ref_a->GetStockId());
}

function SqlGetAhPairIdById($strStockIdA)
{
	return SqlGetStockPairId(TABLE_AH_STOCK, $strStockIdA);
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
	return SqlGetStockPairStockId(TABLE_AH_STOCK, $strStockIdH);
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
