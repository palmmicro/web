<?php
require_once('sqlpair.php');

define('TABLE_ADRH_STOCK', 'adrhstock');
define('TABLE_ETF_PAIR', 'etfpair');

class StockPairSql extends PairSql
{
	var $sql;
	
    function StockPairSql($strTableName)
    {
        parent::PairSql($strTableName);
        
		$this->sql = GetStockSql();
    }
    
    function GetSymbolArray()
    {
		$arSymbol = array();
		$ar = $this->GetIdArray('GetData');
		foreach ($ar as $strStockId)
		{
			$arSymbol[] = $this->sql->GetKey($strStockId);
		}
		sort($arSymbol);
		return $arSymbol;
	}
	
	function GetSymbol($strPairSymbol)
	{
		if ($strPairId = $this->sql->GetId($strPairSymbol))
		{
			if ($strStockId = $this->GetId($strPairId))
			{
				return $this->sql->GetKey($strStockId);
			}
		}
		return false;
	}
	
	function GetPairSymbol($strSymbol)
	{
		if ($strStockId = $this->sql->GetId($strSymbol))
		{
			if ($strPairId = $this->ReadPair($strStockId))
			{
				return $this->sql->GetKey($strPairId);
			}
		}
		return false;
	}

	function WriteSymbol($strSymbol, $strPairSymbol)
	{
		if ($strStockId = $this->sql->GetId($strSymbol))
		{
			if ($strPairId = $this->sql->GetId($strPairSymbol))
			{
				return $this->WritePair($strStockId, $strPairId);
			}
		}
		return false;
	}
	
	function DeleteBySymbol($strSymbol)
	{
		if ($strStockId = $this->sql->GetId($strSymbol))
		{
			return $this->DeleteById($strStockId);
		}
		return false;
	}
	
	function DeleteByPairSymbol($strPairSymbol)
	{
		if ($strPairId = $this->sql->GetId($strPairSymbol))
		{
			return $this->Delete($strPairId);
		}
		return false;
	}
}

class SecondaryListingSql extends StockPairSql
{
    function SecondaryListingSql()
    {
        parent::StockPairSql('secondarylisting');
    }
}

class AhPairSql extends StockPairSql
{
    function AhPairSql() 
    {
        parent::StockPairSql('ahpair');
    }
}

class AbPairSql extends StockPairSql
{
    function AbPairSql() 
    {
        parent::StockPairSql('abpair');
    }
}

// ****************************** PairStockSql class *******************************************************
class PairStockSql extends StockTableSql
{
    function PairStockSql($strTableName, $strStockId) 
    {
        parent::StockTableSql($strTableName, $strStockId);
    }
    
    function GetRecord()
    {
    	return $this->GetSingleData($this->BuildWhere_key());
    }

    function GetRatio()
    {
    	if ($record = $this->GetRecord())
    	{
    		return floatval($record['ratio']);
    	}
    	return false;
    }

    function GetPairId()
    {
    	if ($record = $this->GetRecord())
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
        parent::PairStockSql(TABLE_ETF_PAIR, $strStockId);
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
	$sql = new PairStockSql($strTableName, $strStockId);
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

function _sqlGetPair($strTableName, $strSymbol, $callback)
{
	if ($strStockId = SqlGetStockId($strSymbol))
	{
		$sql = new PairStockSql($strTableName, $strStockId);
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
	$ah_sql = new AhPairSql();
	return $ah_sql->GetPairSymbol($strSymbolA);
}

function SqlGetAdrhPair($strSymbolAdr)
{
	return _sqlGetPair(TABLE_ADRH_STOCK, $strSymbolAdr, 'GetPairId');
}

function SqlGetHaPair($strSymbolH)
{
	$pair_sql = new AhPairSql();
	return $pair_sql->GetSymbol($strSymbolH);
}

function SqlGetHadrPair($strSymbolH)
{
	return _sqlGetPair(TABLE_ADRH_STOCK, $strSymbolH, 'GetFirstStockId');
}

?>
