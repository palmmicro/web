<?php
require_once('sqlstocktable.php');

define('TABLE_AH_STOCK', 'ahstock');
define('TABLE_ADRH_STOCK', 'adrhstock');
define('TABLE_ETF_PAIR', 'etfpair');

// ****************************** SqlStockPair class *******************************************************
class SqlStockPair extends SqlStockTable
{
    // constructor 
    function SqlStockPair($strStockId, $strTableName) 
    {
        parent::SqlStockTable($strStockId, $strTableName);
//        $this->Create();
    }
    
    function Get()
    {
    	return $this->GetUniqueData($this->BuildWhere_stock());
    }

    function GetPairId()
    {
    	if ($record = $this->Get())
    	{
    		return $record['pair_id'];
    	}	
    	return false;
    }
    
    function GetStockId()
    {
    	$strPairId = parent::GetStockId();
    	if ($record = $this->GetSingleData(_SqlBuildWhere('pair_id', $strPairId), false))
    	{
    		return $record['stock_id'];
    	}
    	return false;
    }
}

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
         . ' FOREIGN KEY (`pair_id`) REFERENCES `stock`(`id`) ON DELETE CASCADE ,'
         . ' UNIQUE ( `stock_id` )'
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
	$sql = new SqlStockPair($strStockId, $strTableName);
	return $sql->Get();
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
	$sql = new SqlStockPair($strPairId, $strTableName);
	return $sql->GetStockId();
}

// ****************************** Support functions *******************************************************

function _sqlGetStockPairArray($strTableName)
{
	$ar = array();
	$sql = new SqlTable($strTableName);
	if ($result = $sql->GetAllData()) 
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
	return _sqlGetStockPairArray(TABLE_AH_STOCK);
}

function SqlGetAdrhArray()
{
	return _sqlGetStockPairArray(TABLE_ADRH_STOCK);
}

function SqlGetEtfPairArray()
{
	return _sqlGetStockPairArray(TABLE_ETF_PAIR);
}

function SqlGetAhPairRatio($a_ref)
{
	return SqlGetStockPairRatio(TABLE_AH_STOCK, $a_ref->GetStockId());
}

function SqlGetAdrhPairRatio($adr_ref)
{
	return SqlGetStockPairRatio(TABLE_ADRH_STOCK, $adr_ref->GetStockId());
}

function SqlGetEtfPairRatio($strEtfId)
{
	return SqlGetStockPairRatio(TABLE_ETF_PAIR, $strEtfId);
}

function _sqlGetPair($strTableName, $strSymbol, $callback)
{
	if ($strStockId = SqlGetStockId($strSymbol))
	{
		$sql = new SqlStockPair($strStockId, $strTableName);
		if ($strPairId = $sql->$callback())
		{
			return SqlGetStockSymbol($strPairId);
		}
	}
	return false;
}

function SqlGetEtfPair($strEtf)
{
	return _sqlGetPair(TABLE_ETF_PAIR, $strEtf, 'GetPairId');
}

function SqlGetAhPair($strSymbolA)
{
	return _sqlGetPair(TABLE_AH_STOCK, $strSymbolA, 'GetPairId');
}

function SqlGetAdrhPair($strSymbolAdr)
{
	return _sqlGetPair(TABLE_ADRH_STOCK, $strSymbolAdr, 'GetPairId');
}

function SqlGetHaPair($strSymbolH)
{
	return _sqlGetPair(TABLE_AH_STOCK, $strSymbolH, 'GetStockId');
}

function SqlGetHadrPair($strSymbolH)
{
	return _sqlGetPair(TABLE_ADRH_STOCK, $strSymbolH, 'GetStockId');
}

?>
