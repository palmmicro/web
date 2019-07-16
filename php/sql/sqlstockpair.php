<?php
require_once('sqltable.php');

define('TABLE_AH_STOCK', 'ahstock');
define('TABLE_ADRH_STOCK', 'adrhstock');
define('TABLE_ETF_PAIR', 'etfpair');

// ****************************** StockPairSql class *******************************************************
class StockPairSql extends KeyPairSql
{
    function StockPairSql($strStockId, $strTableName) 
    {
        parent::KeyPairSql($strStockId, 'stock', $strTableName);
    }
}

// ****************************** AhPairSql class *******************************************************
class AhPairSql extends StockPairSql
{
    function AhPairSql($strStockId = false) 
    {
        parent::StockPairSql($strStockId, 'ahpair');
    }
}

// ****************************** PairStockSql class *******************************************************
class PairStockSql extends StockTableSql
{
    function PairStockSql($strStockId, $strTableName) 
    {
        parent::StockTableSql($strStockId, $strTableName);
    }
    
    function Get()
    {
    	return $this->GetSingleData($this->BuildWhere_key());
    }

    function GetRatio()
    {
    	if ($record = $this->Get())
    	{
    		return floatval($record['ratio']);
    	}
    	return false;
    }

    function GetPairId()
    {
    	if ($record = $this->Get())
    	{
    		return $record['pair_id'];
    	}	
    	return false;
    }
    
    function BuildWhere_pair()
    {
    	return _SqlBuildWhere('pair_id', $this->GetKeyId());
    }
    
    function GetFirstStockId()
    {
    	if ($record = $this->GetSingleData($this->BuildWhere_pair()))
    	{
    		return $record['stock_id'];
    	}
    	return false;
    }

    function GetAllStockId()
    {
    	$ar = array();
    	if ($result = $this->GetData($this->BuildWhere_pair())) 
    	{
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$ar[] = $record['stock_id'];
    		}
    		@mysql_free_result($result);
    	}
    	return $ar;
    }

	function Update($strId, $strPairId, $strRatio)
    {
		return $this->UpdateById(array('pair_id' => $strPairId, 'ratio' => $strRatio), $strId);
	}
}

class EtfPairSql extends PairStockSql
{
    function EtfPairSql($strStockId) 
    {
        parent::PairStockSql($strStockId, TABLE_ETF_PAIR);
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

function SqlGetStockPairRatio($strTableName, $strStockId)
{
	$sql = new PairStockSql($strStockId, $strTableName);
	return $sql->GetRatio();
}

// ****************************** Support functions *******************************************************

function _sqlGetStockPairArray($strTableName)
{
	$ar = array();
	$sql = new TableSql($strTableName);
	if ($result = $sql->GetData()) 
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
	$arSymbol = array();
	$sql = new StockSql();
	$pair_sql = new AhPairSql();
	
	$ar = $pair_sql->GetAllId();
	foreach ($ar as $strStockId)
	{
		$arSymbol[] = $sql->GetKeyName($strStockId);
	}
    sort($arSymbol);
	return $arSymbol;
}

function SqlGetAdrhArray()
{
	return _sqlGetStockPairArray(TABLE_ADRH_STOCK);
}

function SqlGetEtfPairArray()
{
	return _sqlGetStockPairArray(TABLE_ETF_PAIR);
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
		$sql = new PairStockSql($strStockId, $strTableName);
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

// Use GetAllStockId() for all Index matches
/*
function SqlGetIndexPair($strIndex)
{
	return _sqlGetPair(TABLE_ETF_PAIR, $strIndex, 'GetFirstStockId');
}
*/

function SqlGetHaPair($strSymbolH)
{
	return _sqlGetPair(TABLE_AH_STOCK, $strSymbolH, 'GetFirstStockId');
}

function SqlGetHadrPair($strSymbolH)
{
	return _sqlGetPair(TABLE_ADRH_STOCK, $strSymbolH, 'GetFirstStockId');
}

?>
